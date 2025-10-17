@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng') {{-- Tiêu đề tĩnh, không dùng biến $order --}}

@section('content')
    <h1 class="text-2xl font-semibold">Quản lý Đơn hàng</h1>

    <div class="mt-6">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">ID</th>
                    <th class="py-3 px-4 text-left">Tên khách hàng</th>
                    <th class="py-3 px-4 text-left">Tổng tiền</th>
                    <th class="py-3 px-4 text-left">Trạng thái</th>
                    <th class="py-3 px-4 text-left">Ngày đặt</th>
                    <th class="py-3 px-4 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                {{-- Vòng lặp sử dụng biến $orders (số nhiều) --}}
                @forelse ($orders as $order)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $order->id }}</td>
                        <td class="py-3 px-4">{{ $order->customer_name }}</td>
                        <td class="py-3 px-4">{{ number_format($order->total_amount) }} đ</td>
                        <td class="py-3 px-4">{{ $order->status }}</td>
                        <td class="py-3 px-4">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-500 hover:text-blue-700">Xem</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Chưa có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Phân trang sử dụng biến $orders (số nhiều) --}}
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection