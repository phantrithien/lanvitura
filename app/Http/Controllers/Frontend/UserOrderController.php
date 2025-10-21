<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('frontend.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Đảm bảo người dùng chỉ có thể xem đơn hàng của chính họ
        if (Auth::id() !== $order->user_id) {
            abort(403);
        }

        $order->load('orderDetails.product');
        return view('frontend.orders.show', compact('order'));
    }
}
