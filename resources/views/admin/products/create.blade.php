@extends('layouts.admin')

@section('title', 'Thêm mới Sản phẩm')

@section('content')
    <h1 class="text-2xl font-semibold">Thêm mới Sản phẩm</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" class="mt-6">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-bold mb-2">Tên sản phẩm</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="category_id" class="block font-bold mb-2">Danh mục</label>
            <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="price" class="block font-bold mb-2">Giá</label>
            <input type="number" name="price" id="price" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="stock_quantity" class="block font-bold mb-2">Số lượng kho</label>
            <input type="number" name="stock_quantity" id="stock_quantity" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block font-bold mb-2">Mô tả</label>
            <textarea name="description" id="description" rows="5" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Lưu sản phẩm
            </button>
        </div>
    </form>
@endsection