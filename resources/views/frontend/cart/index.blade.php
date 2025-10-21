<x-frontend-layout>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Giỏ hàng của bạn</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($cartItems->count() > 0)
            <div class="flex shadow-md my-10">
                <div class="w-3/4 bg-white px-10 py-10">
                    <div class="flex justify-between border-b pb-8">
                        <h2 class="font-semibold text-2xl">Sản phẩm</h2>
                        <h2 class="font-semibold text-2xl">{{ $cartItems->count() }} sản phẩm</h2>
                    </div>
                    <div class="flex mt-10 mb-5">
                        <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Chi tiết sản phẩm</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Số lượng</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Giá</h3>
                        <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5">Tổng cộng</h3>
                    </div>

                    @foreach ($cartItems as $item)
                        <div class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5">
                            <div class="flex w-2/5">
                                <div class="w-20">
                                    <img class="h-24" src="{{ asset('storage/' . $item->attributes->image) }}" alt="{{ $item->name }}">
                                </div>
                                <div class="flex flex-col justify-between ml-4 flex-grow">
                                    <span class="font-bold text-sm">{{ $item->name }}</span>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold hover:text-red-500 text-gray-500 text-xs">Xóa</button>
                                    </form>
                                </div>
                            </div>
                            <div class="flex justify-center w-1/5">
                          <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                              @csrf
                              @method('PATCH')
                              <input class="mx-2 border text-center w-16" type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                              <button type="submit" class="text-xs text-indigo-500 hover:underline">Cập nhật</button>
                          </form>
                            </div>
                            <span class="text-center w-1/5 font-semibold text-sm">{{ number_format($item->price, 0, ',', '.') }} đ</span>
                            <span class="text-center w-1/5 font-semibold text-sm">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</span>
                        </div>
                    @endforeach

                </div>

                <div id="summary" class="w-1/4 px-8 py-10 bg-gray-100">
                    <h2 class="font-semibold text-2xl border-b pb-8">Tổng kết</h2>
                    <div class="flex justify-between mt-10 mb-5">
                        <span class="font-semibold text-sm uppercase">Tổng cộng</span>
                        <span class="font-semibold text-sm">{{ number_format(Cart::getTotal(), 0, ',', '.') }} đ</span>
                    </div>
                    <div>
                        <label class="font-medium inline-block mb-3 text-sm uppercase">Ghi chú</label>
                        <textarea class="p-2 text-sm w-full" placeholder="Thêm ghi chú cho đơn hàng"></textarea>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="bg-indigo-500 font-semibold hover:bg-indigo-600 py-3 text-sm text-white uppercase w-full block text-center mt-6">
                        Tiến hành thanh toán
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-2xl">Giỏ hàng của bạn đang trống.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block bg-indigo-500 text-white py-2 px-4 rounded hover:bg-indigo-600">Tiếp tục mua sắm</a>
            </div>
        @endif
    </div>
</x-frontend-layout>