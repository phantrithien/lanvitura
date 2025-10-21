@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('content')
    <h1 class="text-2xl font-semibold">Quản lý Sản phẩm</h1>
    <div class="mt-4">
        <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Thêm mới sản phẩm
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mt-6">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">ID</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Tên</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Giá</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Số lượng</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($products as $product)
                    <tr>
                        <td class="text-center py-3 px-4">{{ $product->id }}</td>
                        <td class="py-3 px-4">{{ $product->name }}</td>
                        <td class="text-center py-3 px-4">{{ number_format($product->price) }} đ</td>
                        <td class="text-center py-3 px-4">{{ $product->stock_quantity }}</td>
                        <td class="text-center py-3 px-4">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700">Sửa</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Chưa có sản phẩm nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection