@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')
    <h1 class="text-2xl font-semibold">Quản lý Danh mục</h1>
    <div class="mt-4">
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Thêm mới
        </a>
    </div>

    {{-- Hiển thị thông báo thành công --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mt-6">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">ID</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Tên</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($categories as $category)
                    <tr>
                        <td class="w-1/3 text-left py-3 px-4">{{ $category->id }}</td>
                        <td class="w-1/3 text-left py-3 px-4">{{ $category->name }}</td>
                        <td class="text-left py-3 px-4">
                            
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">Sửa</a>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">Chưa có danh mục nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection