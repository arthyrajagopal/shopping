<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'colors', 'sizes', 'reviews');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }
        // Filter by sale (on sale items)
        if ($request->has('sale') && $request->sale == '1') {
            $query->whereNotNull('sale_price');
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->whereHas('sizes', function ($q) use ($request) {
                $q->where('size_id', $request->size);
            });
        }

        // Filter by color
        if ($request->filled('color')) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->where('color_id', $request->color);
            });
        }

        // Price range
        $minPrice = $request->get('min_price', 0);
        $maxPrice = $request->get('max_price', 600);
        $query->where(function ($q) use ($minPrice, $maxPrice) {
            $q->whereBetween('price', [$minPrice, $maxPrice])
              ->orWhereBetween('sale_price', [$minPrice, $maxPrice]);
        });

        // Search query
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);


        // Data for sidebar filters
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();
        $colors = Color::all();
        $sizes = Size::all();
        if ($request->has('trending') && $request->trending == '1') {
    $query->where('is_trending', true);
}
$wishlistIds = session()->get('wishlist', []);

        return view('shop', compact('products', 'categories', 'brands', 'colors', 'sizes', 'wishlistIds'));
    }
    
}