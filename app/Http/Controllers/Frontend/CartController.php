<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getContent();
        $total = Cart::getTotal();

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $product->images->first() ? $product->images->first()->image_path : ''
            ]
        ]);

        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
    
    public function update(Request $request, $rowId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        Cart::update($rowId, [
            'quantity' => [
                'relative' => false, 
                'value' => $request->quantity
            ],
        ]);

        return back()->with('success', 'Đã cập nhật giỏ hàng!');
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }
}