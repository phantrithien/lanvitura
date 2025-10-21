<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ với các sản phẩm mới nhất.
     */
    public function index()
    {
        // Lấy 8 sản phẩm mới nhất để hiển thị
        $products = Product::latest()->take(8)->get();
        return view('frontend.home', compact('products')); 
    }

    /**
     * Hiển thị trang dashboard của admin.
     */
    public function adminDashboard()
    {
        $totalRevenue = Order::sum('total'); // Tính tổng doanh thu từ tất cả các đơn hàng
        $orderCount = Order::count();
        return view('admin.dashboard', compact('totalRevenue', 'orderCount'));
    }
}