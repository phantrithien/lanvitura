<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getContent();
        return view('frontend.cart.index', compact('cartItems'));
    }

    public function store(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->images->first() ? $product->images->first()->image_path : null
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function add(Request $request, Product $product)
    {
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity ?? 1,
            'attributes' => [
                'image' => $product->image
            ]
        ]);
        
        if ($request->wantsJson() || $request->ajax() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
                'count' => Cart::getContent()->count(),
                'total' => Cart::getTotal(),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function update(Request $request, $id)
    {
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    public function remove($id)
    {
        Cart::remove($id);
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }
}