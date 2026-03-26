<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        $products = Product::whereIn('id', $wishlist)->get();
        return view('wishlist', compact('products'));
    }

    public function add($productId)
    {
        $wishlist = session()->get('wishlist', []);
        if (!in_array($productId, $wishlist)) {
            $wishlist[] = $productId;
            session()->put('wishlist', $wishlist);
            return redirect()->back()->with('success', 'Added to wishlist!');
        }
        return redirect()->back()->with('info', 'Already in wishlist.');
    }

    public function remove($productId)
    {
        $wishlist = session()->get('wishlist', []);
        if (($key = array_search($productId, $wishlist)) !== false) {
            unset($wishlist[$key]);
            session()->put('wishlist', $wishlist);
            return redirect()->back()->with('success', 'Removed from wishlist.');
        }
        return redirect()->back()->with('error', 'Product not found in wishlist.');
    }
}