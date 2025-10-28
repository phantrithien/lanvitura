@extends('layouts.admin')

@section('title', 'Tạo Danh mục Bài viết mới')
@section('header', 'Tạo Danh mục Bài viết mới')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Tạo danh mục mới để tổ chức nội dung blog rõ ràng hơn.</p>
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
                    <p class="text-sm font-semibold text-gray-800">Thông tin danh mục</p>
                    <p class="text-xs text-gray-500">Đặt tên ngắn gọn, bám sát chủ đề chính của nhóm bài viết.</p>
                </div>
                <div class="px-6 py-5">
                    <form method="POST" action="{{ route('admin.post_categories.store') }}" class="space-y-6">
                        @include('admin.post_categories.partials.form', ['category' => $category])

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.post_categories.index') }}"
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
                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Gợi ý đặt tên</p>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Ưu tiên từ khóa phổ biến, phù hợp với nhóm nội dung.
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Tránh trùng lặp với danh mục hiện có để không gây nhầm lẫn.
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Duy trì phong cách viết nhất quán giữa các danh mục.
                        </li>
                    </ul>
                </div>

                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Lưu ý về slug</p>
                    <p class="mt-2 text-sm text-gray-500">Slug được dùng trong URL. Bạn có thể để trống để hệ thống tự tạo
                        hoặc chỉnh sửa nếu cần tối ưu SEO.</p>
                </div>
            </div>
        </div>
    </div>
@endsection