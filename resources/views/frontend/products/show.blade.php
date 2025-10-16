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

            <div class="flex items-center gap-4">
                <input type="number" value="1" min="1" class="w-20 border rounded px-3 py-2 text-center">
                <button class="bg-blue-600 text-white font-bold py-2 px-6 rounded hover:bg-blue-700 transition-colors">
                    Thêm vào giỏ hàng
                </button>
            </div>
            <p class="mt-4 text-gray-600">Còn lại: {{ $product->stock_quantity }} sản phẩm</p>
        </div>
    </div>
@endsection