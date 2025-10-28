@extends('layouts.admin')

@section('title', 'Quản lý Từ khoá')
@section('header', 'Quản lý Từ khoá')

@section('content')
    @php
        $sortOptions = [
            'newest' => 'Mới nhất',
            'oldest' => 'Cũ nhất',
            'name_asc' => 'Tên A → Z',
            'name_desc' => 'Tên Z → A',
        ];
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tổng số từ khoá</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-sky-50 text-sky-600">
                        <i class="fas fa-hashtag"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Số lượng thẻ đang dùng để phân loại nội dung.</p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tạo mới trong tháng</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                        <i class="fas fa-calendar-plus"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['created_this_month']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Thẻ được thêm kể từ đầu tháng hiện tại.</p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tạo mới trong tuần</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                        <i class="fas fa-calendar-week"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['created_this_week']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Những thẻ vừa xuất hiện trong 7 ngày qua.</p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Thẻ mới nhất</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 text-amber-600">
                        <i class="fas fa-stopwatch"></i>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-semibold text-gray-900">
                    {{ optional($stats['last_created_at'])->diffForHumans() ?? 'Chưa có dữ liệu' }}
                </p>
                <p class="mt-1 text-sm text-gray-500">Thời điểm thêm tag cuối cùng.</p>
            </div>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white px-5 py-4 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <form method="GET" class="grid w-full grid-cols-1 gap-4 md:grid-cols-2 lg:flex lg:items-end">
                    <div class="lg:w-64">
                        <label for="search" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tìm kiếm</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="search" name="search" value="{{ $filters['search'] }}" placeholder="Tên hoặc slug tag"
                                class="w-full rounded-lg border border-gray-200 py-2.5 pl-10 pr-3 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        </div>
                    </div>

                    <div class="lg:w-48">
                        <label for="sort" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Sắp xếp</label>
                        <select id="sort" name="sort"
                            class="mt-1 w-full rounded-lg border border-gray-200 py-2.5 pl-3 pr-8 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                            @foreach($sortOptions as $value => $label)
                                <option value="{{ $value }}" @selected($filters['sort'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-3 lg:ml-4">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                            <i class="fas fa-filter"></i>
                            Áp dụng
                        </button>
                        @if($filters['search'] || $filters['sort'] !== 'newest')
                            <a href="{{ route('admin.tags.index') }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                                <i class="fas fa-rotate-left"></i>
                                Đặt lại
                            </a>
                        @endif
                    </div>
                </form>

                <a href="{{ route('admin.tags.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:from-indigo-700 hover:to-indigo-800">
                    <i class="fas fa-plus"></i>
                    Thêm từ khoá mới
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Danh sách từ khoá</p>
                        <p class="text-xs text-gray-500">Hiển thị {{ $tags->firstItem() ?? 0 }} - {{ $tags->lastItem() ?? 0 }} trên tổng {{ number_format($tags->total()) }} tag.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        Trang {{ $tags->currentPage() }}/{{ max($tags->lastPage(), 1) }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-6 py-4">Tên tag</th>
                                <th class="px-6 py-4">Slug</th>
                                <th class="px-6 py-4">Tạo ngày</th>
                                <th class="px-6 py-4">Cập nhật</th>
                                <th class="px-6 py-4 text-right">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($tags as $tag)
                                <tr class="hover:bg-indigo-50/40">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                                <i class="fas fa-hashtag"></i>
                                            </span>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $tag->name }}</p>
                                                <p class="text-xs text-gray-400">#{{ $tag->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-2 text-sm text-gray-600">
                                            <i class="fas fa-link text-gray-400"></i>
                                            {{ $tag->slug }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">{{ optional($tag->created_at)->format('d/m/Y') ?? '—' }}</div>
                                        <div class="text-xs text-gray-400">{{ optional($tag->created_at)->diffForHumans() ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">{{ optional($tag->updated_at)->format('d/m/Y') ?? '—' }}</div>
                                        <div class="text-xs text-gray-400">{{ optional($tag->updated_at)->diffForHumans() ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.tags.edit', $tag) }}"
                                                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-600 transition hover:bg-gray-50">
                                                <i class="fas fa-pen"></i>
                                                Sửa
                                            </a>
                                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-2 rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                                    <i class="fas fa-trash"></i>
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12">
                                        <div class="flex flex-col items-center justify-center text-center">
                                            <span class="mb-3 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-3xl text-gray-400">
                                                <i class="fas fa-hashtag"></i>
                                            </span>
                                            <p class="text-sm font-medium text-gray-600">Chưa có từ khoá nào.</p>
                                            <p class="mt-1 text-sm text-gray-500">Hãy bắt đầu thêm tag để nhóm nội dung dễ hơn.</p>
                                            <a href="{{ route('admin.tags.create') }}"
                                                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                                <i class="fas fa-plus"></i>
                                                Tạo từ khoá
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tags->hasPages())
                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                        {{ $tags->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Tag vừa tạo gần đây</p>
                    <ul class="mt-4 space-y-3 text-sm text-gray-600">
                        @forelse($recentTags as $recentTag)
                            <li class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $recentTag->name }}</p>
                                    <p class="text-xs text-gray-500">{{ optional($recentTag->created_at)->diffForHumans() ?? '—' }}</p>
                                </div>
                                <a href="{{ route('admin.tags.edit', $recentTag) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Sửa</a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Chưa có dữ liệu gần đây.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Tên tag dài nổi bật</p>
                    <ul class="mt-4 space-y-3 text-sm text-gray-600">
                        @forelse($longestTags as $item)
                            <li class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-gray-900">{{ $item->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->slug }}</p>
                                </div>
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-[11px] font-semibold text-gray-600">
                                    {{ mb_strlen($item->name) }} ký tự
                                </span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Chưa có dữ liệu để hiển thị.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="rounded-xl border border-dashed border-gray-200 bg-white p-5 text-center shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Cần thêm danh mục bài viết?</p>
                    <p class="mt-2 text-sm text-gray-500">Kết hợp tag với danh mục bài viết để tối ưu SEO và trải nghiệm đọc.</p>
                    <a href="{{ route('admin.post_categories.index') }}"
                        class="mt-4 inline-flex items-center gap-2 rounded-lg border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50">
                        Quản lý danh mục bài viết
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection