<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private const GCASH_NUMBER = '0917-123-4567';

    private function formatPaymentMethod(string $paymentMethod): string
    {
        return match ($paymentMethod) {
            'gcash', 'paypal' => 'GCash',
            'cash_on_delivery' => 'Cash on Delivery',
            'credit_card' => 'Credit Card',
            default => ucwords(str_replace('_', ' ', $paymentMethod)),
        };
    }

    // Show checkout page
    public function checkout()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $loyaltyPoints = LoyaltyPoint::where('user_id', Auth::id())->first();

        $gcashNumber = self::GCASH_NUMBER;

        return view('checkout.index', compact('cartItems', 'subtotal', 'loyaltyPoints', 'gcashNumber'));
    }

    // Place order
    public function store(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'delivery_address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'payment_method' => 'required|in:gcash,cash_on_delivery',
            'shipping_fee' => 'required|numeric|min:0',
            'redeem_points' => 'nullable|integer|min:0',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($request, $cartItems) {
            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $discount = 0;

            // Apply loyalty points redemption
            if ($request->redeem_points > 0) {
                $loyaltyPoint = LoyaltyPoint::where('user_id', Auth::id())->first();
                $redeemable = min($request->redeem_points, $loyaltyPoint->points_balance);
                $discount = $redeemable;

                $loyaltyPoint->update([
                    'points_redeemed' => $loyaltyPoint->points_redeemed + $redeemable,
                    'points_balance' => $loyaltyPoint->points_balance - $redeemable,
                ]);

                LoyaltyPointTransaction::create([
                    'user_id' => Auth::id(),
                    'type' => 'redeem',
                    'points' => $redeemable,
                ]);
            }

            $totalAmount = $subtotal + $request->shipping_fee - $discount;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'recipient_name' => $request->recipient_name,
                'delivery_address' => $request->delivery_address,
                'contact_number' => $request->contact_number,
                'total_amount' => $totalAmount,
                'shipping_fee' => $request->shipping_fee,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);

                // Deduct stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Earn loyalty points (1 point per PHP 20 spent, min PHP 500)
            if ($totalAmount >= 500) {
                $pointsEarned = floor($totalAmount / 20);

                // Double points for orders PHP 10,000 and above
                if ($totalAmount >= 10000) {
                    $pointsEarned *= 2;
                }

                $loyaltyPoint = LoyaltyPoint::firstOrCreate(
                    ['user_id' => Auth::id()],
                    ['points_earned' => 0, 'points_redeemed' => 0, 'points_balance' => 0]
                );

                $loyaltyPoint->update([
                    'points_earned' => $loyaltyPoint->points_earned + $pointsEarned,
                    'points_balance' => $loyaltyPoint->points_balance + $pointsEarned,
                ]);

                LoyaltyPointTransaction::create([
                    'user_id' => Auth::id(),
                    'order_id' => $order->id,
                    'type' => 'earn',
                    'points' => $pointsEarned,
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();
        });

        $redirect = redirect()->route('orders.index')->with('success', 'Order placed successfully!');

        if ($request->payment_method === 'gcash') {
            $redirect->with('payment_notice', 'Please send your payment to GCash number ' . self::GCASH_NUMBER . '.');
        }

        return $redirect;
    }

    // Show order history
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        $gcashNumber = self::GCASH_NUMBER;

        return view('orders.index', compact('orders', 'gcashNumber'));
    }

    // Show single order
    public function show(Order $order)
    {
        $order->load('orderItems.product');
        $paymentMethodLabel = $this->formatPaymentMethod($order->payment_method);
        $gcashNumber = self::GCASH_NUMBER;

        return view('orders.show', compact('order', 'paymentMethodLabel', 'gcashNumber'));
    }
}