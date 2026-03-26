<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $trendingProducts = Product::where('is_trending', true)
            ->with('category', 'reviews')
            ->take(8)
            ->get();
    $wishlistIds = session()->get('wishlist', []);


       return view('home', compact('trendingProducts', 'wishlistIds'));
    }
}