@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Phần hình ảnh --}}
        <div>
            @if ($product->images->isNotEmpty())
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md">
                </div>
                {{-- Hiển thị các ảnh con nếu có nhiều hơn 1 ảnh --}}
                @if ($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach ($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" class="w-full h-24 object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-blue-500">
                        @endforeach
                    </div>
                @endif
            @else
                <img src="https://placehold.co/600x600" alt="No image available" class="w-full h-auto rounded-lg shadow-md">
            @endif
        </div>

        {{-- Phần thông tin sản phẩm --}}
        <div>
            <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>
            <p class="text-2xl text-blue-600 font-semibold mb-6">{{ number_format($product->price) }} đ</p>
            
            <div class="mb-6">
                <h3 class="font-bold mb-2">Mô tả sản phẩm:</h3>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>

            {{-- Form thêm vào giỏ hàng --}}
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                {{-- Gửi kèm ID của sản phẩm --}}
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="flex items-center gap-4">
                    <input type="number" name="quantity" value="1" min="1" class="w-20 border rounded px-3 py-2 text-center">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition-colors">
                        Thêm vào giỏ hàng
                    </button>
                </div>
                <p class="mt-4 text-gray-600">Còn lại: {{ $product->stock_quantity }} sản phẩm</p>
            </form>
            <p class="mt-4 text-gray-600">Còn lại: {{ $product->stock_quantity }} sản phẩm</p>
        </div>
    </div>
    {{-- PHẦN HIỂN THỊ VÀ GỬI ĐÁNH GIÁ --}}
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-4">Đánh giá sản phẩm</h2>

        {{-- Form để gửi đánh giá mới --}}
        @auth {{-- Chỉ hiển thị form nếu người dùng đã đăng nhập --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h3 class="text-xl font-semibold mb-4">Viết đánh giá của bạn</h3>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="mb-4">
                        <label for="rating" class="block font-bold mb-2">Chấm điểm:</label>
                        <select name="rating" id="rating" class="border rounded p-2" required>
                            <option value="5">5 Sao</option>
                            <option value="4">4 Sao</option>
                            <option value="3">3 Sao</option>
                            <option value="2">2 Sao</option>
                            <option value="1">1 Sao</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block font-bold mb-2">Nhận xét:</label>
                        <textarea name="comment" id="comment" rows="4" class="w-full border rounded p-2" required></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700">Gửi đánh giá</button>
                </form>
            </div>
        @else
            <p class="mb-8">Vui lòng <a href="{{ route('login') }}" class="text-blue-600 font-bold">đăng nhập</a> để để lại đánh giá.</p>
        @endauth

        {{-- Hiển thị các đánh giá đã được duyệt --}}
        <div class="space-y-6">
            @forelse ($product->reviews->where('status', 'approved') as $review)
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center mb-2">
                        <strong class="mr-2">{{ $review->user->name }}</strong>
                        <span class="text-yellow-500">
                            @for ($i = 0; $i < $review->rating; $i++)
                                &#9733; {{-- Ký tự ngôi sao --}}
                            @endfor
                        </span>
                    </div>
                    <p class="text-gray-700">{{ $review->comment }}</p>
                </div>
            @empty
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            @endforelse
        </div>
    </div>
@endsection