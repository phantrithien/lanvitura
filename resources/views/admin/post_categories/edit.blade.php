@extends('layouts.admin')

@section('title', 'Chỉnh sửa Danh mục Bài viết')
@section('header', 'Chỉnh sửa Danh mục Bài viết')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Điều chỉnh danh mục để nhóm bài viết chính xác hơn.</p>
            </div>
            <a href="{{ route('admin.post_categories.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <p class="text-sm font-semibold text-gray-800">Cập nhật danh mục</p>
                    <p class="text-xs text-gray-500">Thay đổi sẽ áp dụng cho toàn bộ bài viết thuộc danh mục này.</p>
                </div>
                <div class="px-6 py-5">
                    <form method="POST" action="{{ route('admin.post_categories.update', $category) }}" class="space-y-6">
                        @method('PUT')

                        @include('admin.post_categories.partials.form', ['category' => $category])

                        <div class="flex items-center justify-between gap-3">
                            <div class="text-xs text-gray-500">
                                Cập nhật lần cuối {{ optional($category->updated_at)->diffForHumans() ?? 'chưa xác định' }}.
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.post_categories.index') }}"
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
                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Thông tin hệ thống</p>
                    <dl class="mt-4 space-y-3 text-sm text-gray-600">
                        <div class="flex items-center justify-between">
                            <dt class="text-xs uppercase tracking-wide text-gray-400">Mã danh mục</dt>
                            <dd class="font-medium text-gray-900">#{{ $category->id }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-xs uppercase tracking-wide text-gray-400">Ngày tạo</dt>
                            <dd>{{ optional($category->created_at)->format('d/m/Y H:i') ?? '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-xs uppercase tracking-wide text-gray-400">Slug hiện tại</dt>
                            <dd class="truncate text-right text-xs text-gray-500">{{ $category->slug ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Mẹo quản trị</p>
                    <p class="mt-2 text-sm text-gray-500">Kết hợp danh mục cùng tag để tạo cấu trúc nội dung rõ ràng và hỗ
                        trợ SEO.</p>
                </div>
            </div>
        </div>
    </div>
@endsection