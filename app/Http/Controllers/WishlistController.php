<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Show wishlist items
    public function index()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    // Add product to wishlist
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist.');
    }

    // Remove item from wishlist
    public function remove(Wishlist $wishlist)
    {
        $wishlist->delete();
        return redirect()->back()->with('success', 'Item removed from wishlist.');
    }
}