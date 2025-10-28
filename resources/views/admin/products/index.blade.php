@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')
@section('header', 'Quản lý Sản phẩm')

@section('content')
    @php
        $stockOptions = [
            'all' => 'Tất cả trạng thái',
            'in_stock' => 'Tồn kho tốt (>10)',
            'low_stock' => 'Sắp hết hàng (1-10)',
            'out_of_stock' => 'Hết hàng',
        ];

        $sortOptions = [
            'newest' => 'Mới nhất',
            'oldest' => 'Cũ nhất',
            'price_asc' => 'Giá tăng dần',
            'price_desc' => 'Giá giảm dần',
            'stock_desc' => 'Tồn kho nhiều',
            'stock_asc' => 'Tồn kho ít',
            'top_selling' => 'Bán chạy',
        ];
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tổng sản phẩm</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                        <i class="fas fa-box"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Số lượng sản phẩm đang hiển thị trên cửa hàng.</p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tồn kho tốt</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                        <i class="fas fa-warehouse"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['in_stock']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Sản phẩm đang có nhiều hơn 10 đơn vị tồn kho.</p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Sắp hết hàng</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 text-amber-600">
                        <i class="fas fa-battery-quarter"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ number_format($stats['low_stock']) }}</p>
                <p class="mt-1 text-sm text-gray-500">Cần theo dõi để bổ sung hàng kịp thời.</p>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Giá trung bình</span>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-sky-50 text-sky-600">
                        <i class="fas fa-coins"></i>
                    </span>
                </div>
                <p class="mt-3 text-3xl font-semibold text-gray-900">@currency($stats['avg_price'] ?? 0)</p>
                <p class="mt-1 text-sm text-gray-500">Dựa trên toàn bộ danh sách sản phẩm hiện có.</p>
            </div>
        </div>

        <div class="rounded-xl border border-gray-100 bg-white px-5 py-4 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <form method="GET" class="grid w-full grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="col-span-1">
                        <label for="search" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tìm kiếm</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="search" name="search" value="{{ $filters['search'] }}" placeholder="Tên, slug hoặc thương hiệu"
                                class="w-full rounded-lg border border-gray-200 py-2.5 pl-10 pr-3 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <label for="category_id" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Danh mục</label>
                        <select id="category_id" name="category_id"
                            class="mt-1 w-full rounded-lg border border-gray-200 py-2.5 pl-3 pr-8 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                            <option value="">Tất cả danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected($filters['category_id'] == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="stock" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tồn kho</label>
                        <select id="stock" name="stock"
                            class="mt-1 w-full rounded-lg border border-gray-200 py-2.5 pl-3 pr-8 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                            @foreach($stockOptions as $value => $label)
                                <option value="{{ $value }}" @selected($filters['stock'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="sort" class="text-xs font-semibold uppercase tracking-wide text-gray-500">Sắp xếp</label>
                        <select id="sort" name="sort"
                            class="mt-1 w-full rounded-lg border border-gray-200 py-2.5 pl-3 pr-8 text-sm text-gray-700 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                            @foreach($sortOptions as $value => $label)
                                <option value="{{ $value }}" @selected($filters['sort'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 flex items-center gap-3 md:col-span-2 xl:col-span-4">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                            <i class="fas fa-filter"></i>
                            Áp dụng lọc
                        </button>
                        @if($filters['search'] || $filters['category_id'] || $filters['stock'] !== 'all' || $filters['sort'] !== 'newest')
                            <a href="{{ route('admin.products.index') }}"
                                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                                <i class="fas fa-rotate-left"></i>
                                Đặt lại
                            </a>
                        @endif
                    </div>
                </form>

                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:from-indigo-700 hover:to-indigo-800">
                    <i class="fas fa-plus"></i>
                    Thêm sản phẩm mới
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[2fr_1fr]">
            <div class="rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Danh sách sản phẩm</p>
                        <p class="text-xs text-gray-500">Hiển thị {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} trên tổng {{ number_format($products->total()) }} sản phẩm.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        Trang {{ $products->currentPage() }}/{{ max($products->lastPage(), 1) }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr>
                                <th class="px-6 py-4">Sản phẩm</th>
                                <th class="px-6 py-4">Danh mục</th>
                                <th class="px-6 py-4 text-right">Giá</th>
                                <th class="px-6 py-4 text-center">Tồn kho</th>
                                <th class="px-6 py-4 text-center">Đã bán</th>
                                <th class="px-6 py-4 text-right">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($products as $product)
                                <tr class="hover:bg-indigo-50/40">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $product->images->first() ? Storage::url($product->images->first()->image_path) : 'https://placehold.co/100x100' }}"
                                                alt="{{ $product->name }}" class="h-14 w-14 flex-shrink-0 rounded-lg object-cover shadow-sm" loading="lazy" decoding="async">
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">#{{ $product->id }}</span>
                                                </div>
                                                <p class="mt-1 text-xs text-gray-500 line-clamp-2">{{ Str::limit($product->description, 90) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-xs font-medium text-purple-700">
                                            {{ $product->category->name ?? 'Không xác định' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="text-sm font-semibold text-gray-900">@currency($product->price)</div>
                                        <div class="text-xs text-gray-400">Cập nhật {{ optional($product->updated_at)->diffForHumans() ?? '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $stockQuantity = $product->stock_quantity ?? 0;
                                            $stockClass = 'bg-gray-100 text-gray-600';
                                            if ($stockQuantity > 10) {
                                                $stockClass = 'bg-emerald-50 text-emerald-600';
                                            } elseif ($stockQuantity > 0) {
                                                $stockClass = 'bg-amber-50 text-amber-600';
                                            } elseif ($stockQuantity <= 0) {
                                                $stockClass = 'bg-red-50 text-red-600';
                                            }
                                        @endphp
                                        <span class="inline-flex items-center justify-center rounded-full px-3 py-1 text-xs font-semibold {{ $stockClass }}">
                                            <i class="fas fa-box-open mr-1"></i>
                                            {{ $stockQuantity }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            <i class="fas fa-shopping-bag mr-1"></i>
                                            {{ number_format($product->total_sold ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-600 transition hover:bg-gray-50">
                                                <i class="fas fa-pen"></i>
                                                Sửa
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
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
                                    <td colspan="6" class="px-6 py-12">
                                        <div class="flex flex-col items-center justify-center text-center">
                                            <span class="mb-3 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-3xl text-gray-400">
                                                <i class="fas fa-box-open"></i>
                                            </span>
                                            <p class="text-sm font-medium text-gray-600">Chưa có sản phẩm nào.</p>
                                            <p class="mt-1 text-sm text-gray-500">Hãy bắt đầu bằng cách tạo sản phẩm đầu tiên.</p>
                                            <a href="{{ route('admin.products.create') }}"
                                                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                                <i class="fas fa-plus"></i>
                                                Tạo sản phẩm
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($products->hasPages())
                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                @if($topSellingProducts->isNotEmpty())
                    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-800">Top sản phẩm bán chạy</p>
                            <span class="text-xs text-gray-400">Top {{ $topSellingProducts->count() }}</span>
                        </div>
                        <ul class="mt-4 space-y-4">
                            @foreach($topSellingProducts as $item)
                                <li class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->category->name ?? '—' }}</p>
                                    </div>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                                        <i class="fas fa-shopping-bag"></i>
                                        {{ number_format($item->total_sold ?? 0) }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Cảnh báo tồn kho thấp</p>
                    <ul class="mt-4 space-y-3 text-sm text-gray-600">
                        @forelse($lowStockProducts as $item)
                            <li class="flex items-center justify-between rounded-lg bg-amber-50/60 px-3 py-2">
                                <span class="truncate font-medium text-amber-700">{{ $item->name }}</span>
                                <span class="inline-flex items-center gap-1 rounded-full bg-white px-2 py-0.5 text-xs font-semibold text-amber-600">
                                    <i class="fas fa-box-open"></i>
                                    {{ $item->stock_quantity ?? 0 }}
                                </span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Không có sản phẩm nào sắp hết hàng.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="rounded-xl border border-dashed border-gray-200 bg-white p-5 text-center shadow-sm">
                    <p class="text-sm font-semibold text-gray-800">Cần thêm nhóm sản phẩm mới?</p>
                    <p class="mt-2 text-sm text-gray-500">Sử dụng chức năng danh mục để phân loại và sắp xếp sản phẩm dễ dàng hơn.</p>
                    <a href="{{ route('admin.categories.index') }}"
                        class="mt-4 inline-flex items-center gap-2 rounded-lg border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50">
                        Quản lý danh mục
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection