@extends('layouts.frontend')

@section('title', 'Giỏ hàng')

@section('content')
    <h1 class="text-3xl font-bold mb-8">Giỏ hàng của bạn</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($cartItems->isNotEmpty())
        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="font-semibold text-gray-700 p-2">Sản phẩm</th>
                        <th class="font-semibold text-gray-700 p-2">Giá</th>
                        <th class="font-semibold text-gray-700 p-2">Số lượng</th>
                        <th class="font-semibold text-gray-700 p-2">Tổng cộng</th>
                        <th class="font-semibold text-gray-700 p-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr class="border-b">
                            <td class="p-4 flex items-center">
                                <img src="{{ asset('storage/' . $item->attributes->image) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded mr-4">
                                <span>{{ $item->name }}</span>
                            </td>
                            <td class="p-4">{{ number_format($item->price) }} đ</td>
                            <td class="p-4">
                                {{-- Form cập nhật số lượng --}}
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 text-center border rounded">
                                    <button type="submit" class="text-xs text-blue-500">Cập nhật</button>
                                </form>
                            </td>
                            <td class="p-4">{{ number_format($item->price * $item->quantity) }} đ</td>
                            <td class="p-4">
                                {{-- Form xóa sản phẩm --}}
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold">X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-6">
                <p class="text-2xl font-bold">Tổng tiền: <span class="text-blue-600">{{ number_format($total) }} đ</span></p>
                <a href="{{ route('checkout.index') }}" class="mt-4 inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded hover:bg-blue-700">
                    Tiến hành thanh toán
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-xl text-gray-600">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700">
                Tiếp tục mua sắm
            </a>
        </div>
    @endif
@endsection