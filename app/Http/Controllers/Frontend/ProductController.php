<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('images', 'category');

        // Search logic
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter logic
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Price filter logic
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('images');
        return view('frontend.products.show', compact('product'));
    }
}