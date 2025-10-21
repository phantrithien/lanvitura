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
            <p class="text-2xl text-blue-600 font-semibold mb-6">{{ number_format($product->price) }} VNĐ</p>
            
            <div class="mb-6">
                <h3 class="font-bold mb-2">Mô tả sản phẩm:</h3>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center gap-4 ajax-add-to-cart" data-action="{{ route('cart.add', $product->id) }}">
                @csrf
                <input type="number" name="quantity" value="1" min="1" class="w-20 border rounded px-3 py-2 text-center">
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition-colors">
                    Thêm vào giỏ hàng
                </button>
            </form>
            <p class="mt-4 text-gray-600">Còn lại: {{ $product->stock_quantity }} sản phẩm</p>
        </div>
    </div>

    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900">Đánh giá của khách hàng</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mt-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mt-4">{{ session('error') }}</div>
        @endif

        @if(isset($canReview) && $canReview)
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900">Viết đánh giá</h3>
            <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Xếp hạng *</label>
                    <select id="rating" name="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="5">5 Sao</option>
                        <option value="4">4 Sao</option>
                        <option value="3">3 Sao</option>
                        <option value="2">2 Sao</option>
                        <option value="1">1 Sao</option>
                    </select>
                </div>
                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700">Bình luận</label>
                    <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Gửi đánh giá
                </button>
            </form>
        </div>
        @endif

        <div class="mt-8 flow-root">
            @forelse($product->reviews as $review)
            <div class="py-6 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="font-medium text-gray-900">{{ $review->user->name }}</div>
                    <div class="ml-4 flex items-center">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="h-5 w-5 {{ $i < $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.286 3.957c.3.921-.755 1.688-1.54 1.118l-3.368-2.447a1 1 0 00-1.175 0l-3.368 2.447c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.364-1.118L2.07 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z" />
                            </svg>
                        @endfor
                    </div>
                </div>
                <p class="mt-4 text-gray-600">{{ $review->comment }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
            </div>
            @empty
            <p class="mt-6 text-gray-500">Chưa có đánh giá nào cho sản phẩm này.</p>
            @endforelse
        </div>
    </div>
@endsection