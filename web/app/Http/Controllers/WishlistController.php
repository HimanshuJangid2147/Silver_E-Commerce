<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\ShopManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class WishlistController extends Controller
{
    // Ensure the user is authenticated for wishlist actions
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display the wishlist (already handled by WebController's wishlist method, but we can add logic here if needed)
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->get();

        return view('pages.wishlist', compact('wishlistItems'));
    }

    // Add a product to the wishlist
    public function add(Request $request, $product_id)
    {
        $user = Auth::user();
        $product = ShopManagement::findOrFail($product_id);

        // Check if the product is already in the wishlist
        $existingWishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->first();

        if ($existingWishlistItem) {
            return redirect()->back()->with('error', 'Product is already in your wishlist.');
        }

        // Add the product to the wishlist
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product_id,
        ]);

        return redirect()->back()->with('success', 'Product added to your wishlist.');
    }

    // Remove a product from the wishlist
    public function remove($id)
    {
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $wishlistItem->delete();

        return redirect()->back()->with('success', 'Product removed from your wishlist.');
    }
}
