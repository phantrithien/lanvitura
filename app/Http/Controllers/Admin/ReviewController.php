<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Lấy tất cả review, sắp xếp các review chờ duyệt lên đầu
        $reviews = Review::with('user', 'product')->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        $review->update(['status' => $request->status]);
        return back()->with('success', 'Đã cập nhật trạng thái đánh giá.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Đã xóa đánh giá thành công.');
    }
}