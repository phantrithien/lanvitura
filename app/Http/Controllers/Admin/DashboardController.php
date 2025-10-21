<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Dữ liệu thống kê chung ---
        $userCount = User::count();
        $productCount = Product::count(); // 
        $orderCount = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // --- Dữ liệu cho Biểu đồ Doanh thu 7 ngày qua ---
        $revenueData = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            ]);
            
        $revenueLabels = $revenueData->pluck('date');
        $revenueValues = $revenueData->pluck('total');

        // --- Dữ liệu Top 5 sản phẩm bán chạy nhất ---
        $bestSellingProducts = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_details.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'userCount',
            'productCount',
            'orderCount',
            'totalRevenue',
            'revenueLabels',
            'revenueValues',
            'bestSellingProducts'
        ));
    }
}