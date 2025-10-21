@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Quản lý Đơn hàng</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">ID</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Tên Khách Hàng</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Tổng Tiền</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Trạng Thái</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Ngày Đặt</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-500',
                                    'processing' => 'bg-blue-500',
                                    'completed' => 'bg-green-500',
                                    'cancelled' => 'bg-red-500',
                                ];
                            @endphp
                            @foreach ($orders as $order)
                            <tr class="border-b">
                                <td class="py-3 px-4 text-center">{{ $order->id }}</td>
                                <td class="py-3 px-4">{{ $order->name }}</td>
                                <td class="py-3 px-4 text-right">{{ number_format($order->total, 0, ',', '.') }} đ</td>
                                <td class="py-3 px-4 text-center">
                                     <span class="px-2 py-1 text-xs font-bold leading-none text-white rounded {{ $statusColors[$order->status] ?? 'bg-gray-500' }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-500 hover:text-indigo-700">Xem</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
