@extends('layouts.admin')

@section('title', 'Chỉnh sửa Danh mục')

@section('content')
    <h1 class="text-2xl font-semibold">Chỉnh sửa Danh mục</h1>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="mt-6">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên danh mục:</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $category->name }}" required>
        </div>
        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Cập nhật
            </button>
        </div>
    </form>
@endsection