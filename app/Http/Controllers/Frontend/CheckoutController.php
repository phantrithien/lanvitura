<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::isEmpty()) {
            return redirect()->route('home')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        return view('frontend.checkout.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
        ]);

        if (Cart::isEmpty()) {
            return redirect()->route('home')->with('error', 'Giỏ hàng trống, không thể đặt hàng!');
        }

        DB::beginTransaction();
        try {

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'total_amount' => Cart::getTotal(),
                'status' => 'pending',
            ]);

            foreach (Cart::getContent() as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'product_name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            DB::commit();

            Cart::clear();

            return redirect()->route('home')->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm.');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra. Vui lòng thử lại.');
        }
    }
}