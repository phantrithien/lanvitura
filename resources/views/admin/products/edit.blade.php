@extends('layouts.admin')

@section('title', 'Chỉnh sửa Sản phẩm')

@section('content')
    <h1 class="text-2xl font-semibold">Chỉnh sửa Sản phẩm</h1>

    {{-- Hiển thị lỗi validation (nếu có) --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
            <strong class="font-bold">Có lỗi xảy ra!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-bold mb-2">Tên sản phẩm</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" value="{{ $product->name }}" required>
        </div>
        <div class="mb-4">
            <label for="category_id" class="block font-bold mb-2">Danh mục</label>
            <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="price" class="block font-bold mb-2">Giá</label>
            <input type="number" name="price" id="price" class="w-full border rounded px-3 py-2" value="{{ $product->price }}" required>
        </div>
        <div class="mb-4">
            <label for="stock_quantity" class="block font-bold mb-2">Số lượng kho</label>
            <input type="number" name="stock_quantity" id="stock_quantity" class="w-full border rounded px-3 py-2" value="{{ $product->stock_quantity }}" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block font-bold mb-2">Mô tả</label>
            <textarea name="description" id="description" rows="5" class="w-full border rounded px-3 py-2">{{ $product->description }}</textarea>
        </div>

        {{-- Phần hình ảnh --}}
        <div class="mb-4">
            <label class="block font-bold mb-2">Hình ảnh hiện tại</label>
            <div class="flex flex-wrap gap-4">
                @forelse ($product->images as $image)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" class="w-32 h-32 object-cover rounded">
                    </div>
                @empty
                    <p>Chưa có hình ảnh nào.</p>
                @endforelse
            </div>
        </div>

        <div class="mb-4">
            <label for="images" class="block font-bold mb-2">Thêm hình ảnh mới</label>
            <input type="file" name="images[]" id="images" class="w-full border rounded px-3 py-2" multiple>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Cập nhật sản phẩm
            </button>
        </div>
    </form>
@endsection