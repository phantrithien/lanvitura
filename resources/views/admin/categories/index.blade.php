@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')
@section('header', 'Quản lý Danh mục Sản phẩm')

@section('content')
    @php
        $stateOptions = [
            'all' => 'Tất cả danh mục',
            'with_products' => 'Đang có sản phẩm',
            'empty' => 'Chưa có sản phẩm',
        ];
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tổng danh mục</span>
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                        <i class="fas fa-layer-group"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Tổng số danh mục đang có trong hệ thống.</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Có sản phẩm</span>
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                        <i class="fas fa-boxes"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['with_products']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Danh mục đang liên kết với ít nhất một sản phẩm.</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Chưa có sản phẩm</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 text-amber-600">
                        <i class="fas fa-inbox"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['empty']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Danh mục đang chờ thêm sản phẩm mới.</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Cập nhật gần nhất</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-sky-50 text-sky-600">
                        <i class="fas fa-clock"></i>
                    </span>
                </div>
                <p class="mt-3 text-2xl font-semibold text-gray-900">
                    {{ optional($stats['last_updated_at'])->diffForHumans() ?? 'Chưa có dữ liệu' }}
                </p>
                <p class="mt-1 text-sm text-gray-500">Thời điểm chỉnh sửa danh mục cuối cùng.</p>
            </div>
        </div>

        <div
            class="bg-white rounded-xl border border-gray-100 shadow-sm px-5 py-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <form method="GET" class="flex w-full flex-col gap-3 md:flex-row md:items-center md:gap-4">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ $search }}"
                        class="w-full rounded-lg border border-gray-200 py-2.5 pl-10 pr-3 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        placeholder="Tìm theo tên hoặc slug danh mục...">
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <select name="state"
                        class="w-full rounded-lg border border-gray-200 py-2.5 pl-3 pr-8 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 sm:w-48">
                        @foreach($stateOptions as $value => $label)
                            <option value="{{ $value }}" @selected($state === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="flex items-center gap-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                            <i class="fas fa-filter mr-2"></i>
                            Lọc danh sách
                        </button>
                        @if($search || $state !== 'all')
                            <a href="{{ route('admin.categories.index') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-50">
                                Đặt lại
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:from-indigo-700 hover:to-indigo-800">
                <i class="fas fa-plus mr-2"></i>
                Thêm danh mục mới
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Danh mục sản phẩm</p>
                        <p class="text-xs text-gray-500">
                            Hiển thị {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} trên tổng
                            {{ number_format($categories->total()) }} danh mục.
                        </p>
                    </div>
                    <span
                        class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        Trang {{ $categories->currentPage() }}/{{ max($categories->lastPage(), 1) }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-6 py-4">Danh mục</th>
                                <th class="px-6 py-4">Slug</th>
                                <th class="px-6 py-4 text-center">Sản phẩm</th>
                                <th class="px-6 py-4">Cập nhật</th>
                                <th class="px-6 py-4 text-right">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($categories as $category)
                                <tr class="hover:bg-indigo-50/40">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-500">
                                                <i class="fas fa-layer-group"></i>
                                            </span>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                                                <p class="text-xs text-gray-500">#{{ $category->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-2 text-sm text-gray-600">
                                            <i class="fas fa-link text-gray-400"></i>
                                            {{ $category->slug ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center justify-center rounded-full px-3 py-1 text-xs font-semibold {{ ($category->products_count ?? 0) > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500' }}">
                                            <i class="fas fa-box-open mr-1"></i>
                                            {{ $category->products_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600">
                                            {{ optional($category->updated_at)->diffForHumans() ?? '—' }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ optional($category->updated_at)->format('d/m/Y H:i') ?? '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.categories.edit', $category) }}"
                                                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-600 transition hover:bg-gray-50">
                                                <i class="fas fa-pen"></i>
                                                Sửa
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
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
                                            <span
                                                class="mb-3 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-3xl text-gray-400">
                                                <i class="fas fa-folder-open"></i>
                                            </span>
                                            <p class="text-sm font-medium text-gray-600">Chưa có danh mục sản phẩm nào.</p>
                                            <p class="mt-1 text-sm text-gray-500">Hãy bắt đầu bằng cách tạo danh mục đầu tiên.
                                            </p>
                                            <a href="{{ route('admin.categories.create') }}"
                                                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                                <i class="fas fa-plus"></i>
                                                Tạo danh mục
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages())
                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                        {{ $categories->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                @if($topCategories->isNotEmpty())
                    <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-800">Danh mục nhiều sản phẩm</p>
                            <span class="text-xs text-gray-400">Top {{ $topCategories->count() }}</span>
                        </div>
                        <ul class="mt-4 space-y-4">
                            @foreach($topCategories as $topCategory)
                                <li class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $topCategory->name }}</p>
                                        <p class="text-xs text-gray-500">Cập nhật
                                            {{ optional($topCategory->updated_at)->diffForHumans() ?? '—' }}</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                                        <i class="fas fa-box"></i>
                                        {{ $topCategory->products_count }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Danh mục mới thêm gần đây</p>
                    <ul class="mt-4 space-y-3">
                        @forelse($recentCategories as $recentCategory)
                            <li class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $recentCategory->name }}</p>
                                    <p class="text-xs text-gray-500">Tạo
                                        {{ optional($recentCategory->created_at)->diffForHumans() ?? '—' }}</p>
                                </div>
                                <a href="{{ route('admin.categories.edit', $recentCategory) }}"
                                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Chỉnh sửa</a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Chưa có dữ liệu gần đây.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection