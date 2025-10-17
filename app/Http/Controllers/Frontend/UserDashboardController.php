<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $orders = \App\Models\Order::where('user_id', $userId)->latest()->paginate(10);

        return view('frontend.user.orders', compact('orders'));
    }
}