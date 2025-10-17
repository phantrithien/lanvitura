@extends('layouts.frontend')
@section('title', 'Lịch sử Đơn hàng')
@section('content')
    <h1 class="text-3xl font-bold mb-8">Lịch sử Đơn hàng của bạn</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        @if ($orders->isNotEmpty())
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="font-semibold p-2">Mã ĐH</th>
                        <th class="font-semibold p-2">Ngày đặt</th>
                        <th class="font-semibold p-2">Tổng tiền</th>
                        <th class="font-semibold p-2">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-b">
                            <td class="p-2">#{{ $order->id }}</td>
                            <td class="p-2">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="p-2">{{ number_format($order->total_amount) }} đ</td>
                            <td class="p-2">{{ $order->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <p>Bạn chưa có đơn hàng nào.</p>
        @endif
    </div>
@endsection