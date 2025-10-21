@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Tổng quan</h1>

    {{-- Các thẻ thống kê --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-600">Tổng Doanh thu</h3>
            <p class="text-3xl font-bold mt-2">{{ number_format($totalRevenue) }} đ</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-600">Tổng số Đơn hàng</h3>
            <p class="text-3xl font-bold mt-2">{{ $orderCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-600">Tổng số Sản phẩm</h3>
            <p class="text-3xl font-bold mt-2">{{ $productCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-600">Tổng số Người dùng</h3>
            <p class="text-3xl font-bold mt-2">{{ $userCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
        {{-- Biểu đồ Doanh thu --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Doanh thu 7 ngày qua</h2>
            <canvas id="revenueChart"></canvas>
        </div>

        {{-- Top sản phẩm bán chạy --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Top Sản phẩm Bán chạy</h2>
            <ul>
                @forelse($bestSellingProducts as $product)
                    <li class="flex justify-between items-center py-2 border-b">
                        <span>{{ $product->name }}</span>
                        <span class="font-bold bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">{{ $product->total_sold }} đã bán</span>
                    </li>
                @empty
                    <li class="text-gray-500">Chưa có dữ liệu.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Script cho Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($revenueLabels) !!},
                        datasets: [{
                            label: 'Doanh thu',
                            data: {!! json_encode($revenueValues) !!},
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            fill: true,
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection