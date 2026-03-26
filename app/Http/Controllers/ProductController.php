<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
   public function show($slug)
{
    $product = Product::with('category', 'brand', 'colors', 'sizes', 'reviews')
        ->where('slug', $slug)->firstOrFail();
    $related = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)->take(4)->get();
    $wishlistIds = session()->get('wishlist', []);
    return view('product', compact('product', 'related', 'wishlistIds'));
}
}