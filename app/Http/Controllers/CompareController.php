<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CompareController extends Controller
{
    public function index()
    {
        $compare = session()->get('compare', []);
        $products = Product::whereIn('id', $compare)->get();
        return view('compare', compact('products'));
    }

    public function add($id)
    {
        $compare = session()->get('compare', []);
        if (!in_array($id, $compare) && count($compare) < 4) {
            $compare[] = $id;
            session()->put('compare', $compare);
        }
        return redirect()->back()->with('success', 'Added to compare!');
    }

    public function remove($id)
    {
        $compare = session()->get('compare', []);
        if (($key = array_search($id, $compare)) !== false) {
            unset($compare[$key]);
            session()->put('compare', $compare);
        }
        return redirect()->route('compare.index');
    }
}