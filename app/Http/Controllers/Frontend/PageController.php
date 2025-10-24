<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Hiển thị trang "Về chúng tôi".
     */
    public function about()
    {
        // Giả sử bạn đã tạo view này ở câu trước
        return view('frontend.pages.about');
    }
}