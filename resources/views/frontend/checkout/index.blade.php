<x-frontend-layout>
    <div class="container mx-auto mt-10 p-4">
        <h1 class="text-3xl font-bold mb-6">Thanh toán</h1>
        <form action="{{ route('checkout.placeOrder') }}" method="POST" class="flex flex-col lg:flex-row gap-12">
             @csrf
            <div class="lg:w-2/3">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-6">Thông tin giao hàng</h2>
                     @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Họ và Tên *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại *</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ *</label>
                            <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('address') }}</textarea>
                        </div>
                         <div>
                            <label for="note" class="block text-sm font-medium text-gray-700">Ghi chú (tùy chọn)</label>
                            <textarea name="note" id="note" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-gray-50 p-8 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-6">Đơn hàng của bạn</h2>
                    @foreach ($cartItems as $item)
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-600">{{ $item->name }} x {{ $item->quantity }}</span>
                            <span class="font-semibold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</span>
                        </div>
                    @endforeach
                    <div class="border-t border-gray-300 pt-4 mt-4">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Tổng cộng</span>
                            <span>{{ number_format(Cart::getTotal(), 0, ',', '.') }} đ</span>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700">
                            Đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-frontend-layout>
