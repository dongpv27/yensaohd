<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** Display home page with best sellers */
    public function home()
    {
        $bestSellers = Product::where('is_best_seller', true)
            ->orWhere('sold_count', '>', 0)
            ->orderBy('sold_count', 'desc')
            ->take(10)
            ->get();

        return view('home', compact('bestSellers'));
    }

    /** Display a listing of products. */
    public function index()
    {
        $products = Product::paginate(9);
        return view('products.index', compact('products'));
    }

    /** Display the specified product. */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
