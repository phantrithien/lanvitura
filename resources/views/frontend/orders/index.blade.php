<x-frontend-layout>
    <div class="container mx-auto mt-10 p-4">
        <h1 class="text-3xl font-bold mb-6">Đơn hàng của tôi</h1>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Mã Đơn</th>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Ngày Đặt</th>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-right">Tổng Tiền</th>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Trạng Thái</th>
                            <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($orders as $order)
                        <tr class="border-b">
                            <td class="py-3 px-4">#{{ $order->id }}</td>
                            <td class="py-3 px-4">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 text-right">{{ number_format($order->total, 0, ',', '.') }} đ</td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2 py-1 text-xs font-bold leading-none text-white bg-blue-500 rounded">{{ $order->status }}</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('user.orders.show', $order->id) }}" class="text-indigo-500 hover:text-indigo-700 font-semibold">Xem chi tiết</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-10">Bạn chưa có đơn hàng nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-frontend-layout>
