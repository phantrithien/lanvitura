@extends('layouts.admin')

@section('title', 'Chỉnh sửa Danh mục Sản phẩm')
@section('header', 'Chỉnh sửa Danh mục Sản phẩm')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Chỉnh sửa thông tin danh mục để đảm bảo nội dung luôn chính xác.</p>
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
                    <p class="text-sm font-semibold text-gray-800">Cập nhật danh mục</p>
                    <p class="text-xs text-gray-500">Điều chỉnh tên và slug để đồng bộ với sản phẩm liên quan.</p>
                </div>
                <div class="px-6 py-5">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @include('admin.categories.partials.form', ['category' => $category])

                        <div class="flex items-center justify-between gap-3">
                            <div class="text-xs text-gray-500">
                                Cập nhật lần cuối {{ optional($category->updated_at)->diffForHumans() ?? 'chưa xác định' }}.
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.categories.index') }}"
                                    class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                                    Hủy
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                    <i class="fas fa-save"></i>
                                    Lưu thay đổi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Tình trạng hiện tại</p>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        <li class="flex items-center justify-between">
                            <span>Số sản phẩm liên kết</span>
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                                <i class="fas fa-box"></i>
                                {{ $category->products_count ?? 0 }}
                            </span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Ngày tạo</span>
                            <span
                                class="text-xs text-gray-500">{{ optional($category->created_at)->format('d/m/Y H:i') ?? '—' }}</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Slug hiện tại</span>
                            <span class="text-xs text-gray-500">{{ $category->slug ?? '—' }}</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 text-white rounded-xl p-5 shadow-sm">
                    <p class="text-sm font-semibold">Gợi ý quản trị</p>
                    <p class="mt-2 text-sm text-indigo-100">Kiểm tra các liên kết sản phẩm sau khi thay đổi slug để tránh
                        lỗi hiển thị ở mặt tiền cửa hàng.</p>
                </div>
            </div>
        </div>
    </div>
@endsection