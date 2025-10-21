<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra xem người dùng đã mua sản phẩm này chưa
        $hasPurchased = Order::where('user_id', Auth::id())
                            ->where('status', 'completed')
                            ->whereHas('orderDetails', function ($query) use ($product) {
                                $query->where('product_id', $product->id);
                            })->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm sau khi đã mua hàng!');
        }

        // Kiểm tra xem người dùng đã đánh giá sản phẩm này chưa
        $existingReview = $product->reviews()->where('user_id', Auth::id())->exists();
        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã gửi đánh giá!');
    }
}
