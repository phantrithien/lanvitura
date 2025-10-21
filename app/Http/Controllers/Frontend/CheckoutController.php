<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use Cart;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {
        if (Cart::isEmpty()) {
            return redirect()->route('home')->with('info', 'Giỏ hàng của bạn đang trống.');
        }

        $cartItems = Cart::getContent();
        return view('frontend.checkout.index', compact('cartItems'));
    }

    // Xử lý đặt hàng
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        // Bắt đầu một transaction để đảm bảo toàn vẹn dữ liệu
        \DB::transaction(function () use ($request) {
            // 1. Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'note' => $request->note,
                'total' => Cart::getTotal(),
                'status' => 'pending', // Trạng thái ban đầu
            ]);

            // 2. Lưu chi tiết đơn hàng
            foreach (Cart::getContent() as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }
        });

        // 3. Xóa giỏ hàng
        Cart::clear();

        // 4. Chuyển hướng đến trang thành công
        return redirect()->route('checkout.success')->with('order_success', 'Đơn hàng của bạn đã được đặt thành công!');
    }

    // Hiển thị trang đặt hàng thành công
    public function success()
    {
        // Chỉ cho phép truy cập trang này nếu có session 'order_success'
        if (!session('order_success')) {
            return redirect()->route('home');
        }
        return view('frontend.checkout.success');
    }
}
