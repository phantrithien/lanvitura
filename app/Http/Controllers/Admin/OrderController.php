<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Tải chi tiết đơn hàng cùng với thông tin sản phẩm
        $order->load('orderDetails.product');
        return view('admin.orders.show', compact('order'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);

        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }
}
