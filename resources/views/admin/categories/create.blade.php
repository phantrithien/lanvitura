@extends('layouts.admin')

@section('title', 'Tạo Danh mục Sản phẩm mới')
@section('header', 'Tạo Danh mục Sản phẩm mới')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Thiết lập danh mục mới để tổ chức sản phẩm theo chủ đề phù hợp.</p>
            </div>
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <p class="text-sm font-semibold text-gray-800">Thông tin danh mục</p>
                    <p class="text-xs text-gray-500">Điền tên danh mục và để trống slug nếu muốn hệ thống tự tạo.</p>
                </div>
                <div class="px-6 py-5">
                    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
                        @include('admin.categories.partials.form', ['category' => new \App\Models\Category()])

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.categories.index') }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                                Hủy
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                <i class="fas fa-save"></i>
                                Lưu danh mục
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Gợi ý nhanh</p>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Đặt tên rõ ràng để khách hàng dễ nhận biết nhóm sản phẩm.
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Giữ slug ngắn gọn, không dấu và tránh ký tự đặc biệt.
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Sau khi lưu, có thể gán danh mục cho sản phẩm tại trang quản lý sản phẩm.
                        </li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 text-white rounded-xl p-5 shadow-sm">
                    <p class="text-sm font-semibold">Mẹo SEO</p>
                    <p class="mt-2 text-sm text-indigo-100">Slug thân thiện giúp trang danh mục dễ được tìm thấy trên công
                        cụ tìm kiếm và mạng xã hội.</p>
                </div>
            </div>
        </div>
    </div>
@endsection