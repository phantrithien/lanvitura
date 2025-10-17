@extends('layouts.frontend')
@section('title', 'Thanh toán')
@section('content')
    <h1 class="text-3xl font-bold mb-8">Thông tin thanh toán</h1>
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-xl font-semibold mb-4">Thông tin giao hàng</h3>
                <div class="mb-4">
                    <label for="customer_name" class="block font-bold mb-2">Họ và tên</label>
                    <input type="text" name="customer_name" id="customer_name" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label for="customer_email" class="block font-bold mb-2">Email</label>
                    <input type="email" name="customer_email" id="customer_email" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label for="customer_phone" class="block font-bold mb-2">Số điện thoại</label>
                    <input type="text" name="customer_phone" id="customer_phone" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label for="customer_address" class="block font-bold mb-2">Địa chỉ</label>
                    <textarea name="customer_address" id="customer_address" rows="3" class="w-full border rounded p-2" required></textarea>
                </div>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-4">Đơn hàng của bạn</h3>
                <div class="bg-white p-4 rounded shadow">
                    @foreach(Cart::getContent() as $item)
                        <div class="flex justify-between border-b py-2">
                            <span>{{ $item->name }} x {{ $item->quantity }}</span>
                            <span>{{ number_format($item->price * $item->quantity) }} đ</span>
                        </div>
                    @endforeach
                    <div class="flex justify-between font-bold text-xl mt-4">
                        <span>Tổng cộng</span>
                        <span>{{ number_format(Cart::getTotal()) }} đ</span>
                    </div>
                </div>
                <button type="submit" class="mt-6 w-full bg-blue-600 text-white font-bold py-3 px-8 rounded hover:bg-blue-700">
                    Đặt hàng
                </button>
            </div>
        </div>
    </form>
@endsection