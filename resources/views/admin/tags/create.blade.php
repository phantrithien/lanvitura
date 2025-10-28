@extends('layouts.admin')

@section('title', 'Thêm Từ khoá mới')
@section('header', 'Thêm Từ khoá mới')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-500">Tạo tag mới để nhóm các bài viết theo chủ đề cụ thể.</p>
            </div>
            <a href="{{ route('admin.tags.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <p class="text-sm font-semibold text-gray-800">Thông tin từ khoá</p>
                    <p class="text-xs text-gray-500">Chọn tên dễ nhớ và phù hợp với nội dung mà tag đại diện.</p>
                </div>
                <div class="px-6 py-5">
                    <form method="POST" action="{{ route('admin.tags.store') }}" class="space-y-6">
                        @include('admin.tags.partials.form', ['tag' => $tag])

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.tags.index') }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                                Hủy
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                                <i class="fas fa-save"></i>
                                Lưu từ khoá
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Gợi ý sử dụng</p>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Ưu tiên từ ngắn gọn, phản ánh chủ đề chính của bài viết.
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Tránh viết hoa toàn bộ, giữ định dạng nhất quán.
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-xs text-emerald-500 mt-1"></i>
                            Tag hữu ích giúp người đọc khám phá thêm bài viết liên quan.
                        </li>
                    </ul>
                </div>

                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Lưu ý về slug</p>
                    <p class="mt-2 text-sm text-gray-500">Slug sẽ được dùng trong URL thân thiện. Bạn có thể để trống để hệ thống tự tạo hoặc tự chỉnh sửa ngay tại đây.</p>
                </div>
            </div>
        </div>
    </div>
@endsection