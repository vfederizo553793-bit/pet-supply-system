<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // show cart items
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    // add product to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem =  Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) 
        {
            //if alr in cart, update quantity
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            // else create new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to cart');
        
        }

        // update cart quantity
        public function update(Request $request, Cart $cart)
        {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $cart->update([
                'quantity' => $request->quantity,
            ]);

            return redirect()->back()->with('success', 'Cart updated successfully');
        }

        // remove item from cart
        public function destroy(Cart $cart)
        {
            $cart->delete();
            return redirect()->back()->with('success', 'Item removed from cart');
        }
    }

