<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->latest()->paginate(9);

        return view('frontend.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('images');

        return view('frontend.products.show', compact('product'));
    }
}