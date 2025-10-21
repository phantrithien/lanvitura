<x-frontend-layout>
    <div class="container mx-auto mt-10 p-4">
        <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
            <h2 class="text-2xl font-semibold mb-4">Chi tiết Đơn hàng #{{ $order->id }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="font-bold">Thông tin giao hàng</h3>
                    <p><strong>Tên:</strong> {{ $order->name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                </div>
                <div>
                    <h3 class="font-bold">Thông tin đơn hàng</h3>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong> <span class="px-2 py-1 text-xs font-bold leading-none text-white bg-blue-500 rounded">{{ $order->status }}</span></p>
                    <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
                </div>
            </div>

            <h3 class="font-bold mb-4">Sản phẩm trong đơn hàng</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-3 px-4 font-semibold text-sm text-left">Sản phẩm</th>
                            <th class="py-3 px-4 font-semibold text-sm text-center">Số lượng</th>
                            <th class="py-3 px-4 font-semibold text-sm text-right">Đơn giá</th>
                            <th class="py-3 px-4 font-semibold text-sm text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($order->orderDetails as $detail)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $detail->product->name }}</td>
                            <td class="py-3 px-4 text-center">{{ $detail->quantity }}</td>
                            <td class="py-3 px-4 text-right">{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                            <td class="py-3 px-4 text-right">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-right font-bold">Tổng cộng:</td>
                            <td class="py-3 px-4 text-right font-bold">{{ number_format($order->total, 0, ',', '.') }} đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
             <div class="mt-6">
                <a href="{{ route('user.orders.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</x-frontend-layout>
