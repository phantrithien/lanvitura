@extends('layouts.frontend')

@section('title', 'Tất cả sản phẩm')

@section('content')
    <h1 class="text-3xl font-bold text-center mb-8">Tất cả sản phẩm</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach ($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden group">
                <a href="{{ route('products.show', $product->slug) }}">
                    @if($product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:opacity-75 transition-opacity duration-300">
                    @else
                        <img src="https://placehold.co/400x400" alt="No image" class="w-full h-64 object-cover">
                    @endif
                </a>
                <div class="p-4">
                    <h3 class="font-bold text-lg">
                        <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600">{{ $product->name }}</a>
                    </h3>
                    <p class="text-gray-600 mt-2">{{ number_format($product->price) }} đ</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Hiển thị các nút phân trang --}}
    <div class="mt-8">
        {{ $products->links() }}
    </div>
@endsection