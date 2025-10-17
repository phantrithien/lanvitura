@extends('layouts.admin')
@section('title', 'Chi tiết Đơn hàng #' . $order->id)
@section('content')
    <h1 class="text-2xl font-semibold">Chi tiết Đơn hàng #{{ $order->id }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Thông tin khách hàng</h3>
            <p><strong>Tên:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Điện thoại:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-bold border-b pb-2 mb-4">Thông tin đơn hàng</h3>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Tổng tiền:</strong> <span class="font-bold text-red-600">{{ number_format($order->total_amount) }} đ</span></p>

            {{-- FORM CẬP NHẬT TRẠNG THÁI --}}
            <div class="mt-4">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <label for="status" class="font-bold">Trạng thái đơn hàng:</label>
                    <div class="flex items-center mt-2">
                        <select name="status" id="status" class="border rounded-l p-2">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý (Pending)</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý (Processing)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao (Shipped)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành (Completed)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy (Cancelled)</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-r hover:bg-blue-700">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mt-8">
        <h3 class="text-lg font-bold border-b pb-2 mb-4">Các sản phẩm đã đặt</h3>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left p-2">Sản phẩm</th>
                    <th class="text-left p-2">Số lượng</th>
                    <th class="text-left p-2">Đơn giá</th>
                    <th class="text-left p-2">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $detail)
                <tr class="border-b">
                    <td class="p-2">{{ $detail->product_name }}</td>
                    <td class="p-2">{{ $detail->quantity }}</td>
                    <td class="p-2">{{ number_format($detail->price) }} đ</td>
                    <td class="p-2">{{ number_format($detail->price * $detail->quantity) }} đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection