<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Chi tiết Đơn hàng #{{ $order->id }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-bold">Thông tin khách hàng</h3>
                        <p><strong>Tên:</strong> {{ $order->name }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    </div>
                    <div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-500',
                                'processing' => 'bg-blue-500',
                                'completed' => 'bg-green-500',
                                'cancelled' => 'bg-red-500',
                            ];
                        @endphp
                        <h3 class="font-bold">Thông tin đơn hàng</h3>
                        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Trạng thái:</strong> <span class="px-2 py-1 text-xs font-bold leading-none text-white rounded {{ $statusColors[$order->status] ?? 'bg-gray-500' }}">{{ ucfirst($order->status) }}</span></p>
                        <p class="mb-4"><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>

                        <h3 class="font-bold mb-2">Cập nhật trạng thái</h3>
                        @if (session('success'))
                            <div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-sm">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-center">
                                <select name="status" class="rounded-md border-gray-300 shadow-sm">
                                    <option value="pending" @selected($order->status == 'pending')>Đang chờ</option>
                                    <option value="processing" @selected($order->status == 'processing')>Đang xử lý</option>
                                    <option value="completed" @selected($order->status == 'completed')>Hoàn thành</option>
                                    <option value="cancelled" @selected($order->status == 'cancelled')>Đã hủy</option>
                                </select>
                                <button type="submit" class="ml-3 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>

                <h3 class="font-bold mb-4">Sản phẩm trong đơn hàng</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Sản phẩm</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Số lượng</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Đơn giá</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($order->orderDetails as $detail)
                            <tr>
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
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>