@extends('layouts.frontend')

@section('title', 'Trang chủ')

@section('content')
    <h1 class="text-3xl font-bold text-center mb-8">Sản phẩm mới nhất</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach ($latestProducts as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <a href="#">
                    @if($product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                    @else
                        <img src="https://placehold.co/400x400" alt="No image" class="w-full h-64 object-cover">
                    @endif
                </a>
                <div class="p-4">
                    <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                    <p class="text-gray-600 mt-2">{{ number_format($product->price) }} đ</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $latestProducts->links() }}
    </div>
@endsection