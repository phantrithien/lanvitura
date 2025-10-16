@extends('layouts.admin')

@section('title', 'Thêm mới Danh mục')

@section('content')
    <h1 class="text-2xl font-semibold">Thêm mới Danh mục</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="mt-6">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tên danh mục:</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Lưu
            </button>
        </div>
    </form>
@endsection