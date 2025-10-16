<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = Product::with('images')->latest()->paginate(8);

        return view('frontend.home', compact('latestProducts'));
    }
}