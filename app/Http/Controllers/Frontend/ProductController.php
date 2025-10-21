<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product as ProductModel;
use App\Models\Order;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->latest()->paginate(9);

        return view('frontend.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Tải các ảnh và các đánh giá cùng user
        $product->load('images', 'reviews.user');

        $canReview = false;
        if (Auth::check()) {
            $hasPurchased = Order::where('user_id', Auth::id())
                                ->where('status', 'completed')
                                ->whereHas('orderDetails', fn($q) => $q->where('product_id', $product->id))
                                ->exists();

            $hasReviewed = $product->reviews()->where('user_id', Auth::id())->exists();

            if ($hasPurchased && !$hasReviewed) {
                $canReview = true;
            }
        }

        return view('frontend.products.show', compact('product', 'canReview'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);

        $query = $request->input('query');

        $products = ProductModel::where('name', 'LIKE', "%{$query}%")
                                ->orWhere('description', 'LIKE', "%{$query}%")
                                ->paginate(12);

        return view('frontend.products.search-results', compact('products', 'query'));
    }
}