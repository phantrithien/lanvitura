<x-frontend-layout>
    <div class="container mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">
            {{ request('search') ? 'Kết quả tìm kiếm' : 'Tất cả sản phẩm' }}
        </h1>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Filter Sidebar -->
            <aside class="md:col-span-1">
                <form action="{{ route('products.index') }}" method="GET" class="bg-white p-6 rounded-lg shadow-md sticky top-24">
                    <h2 class="text-xl font-semibold mb-4">Lọc sản phẩm</h2>
                    
                    {{-- Giữ lại từ khóa tìm kiếm nếu có --}}
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <!-- Lọc theo danh mục -->
                    <div class="mb-6">
                        <label for="category" class="block font-medium text-gray-900 mb-2">Danh mục</label>
                        <select name="category" id="category" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Tất cả</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lọc theo giá -->
                    <div class="mb-6 border-t border-gray-200 pt-6">
                        <h3 class="font-medium text-gray-900 mb-2">Khoảng giá</h3>
                        <div class="flex items-center space-x-2">
                            <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <span>-</span>
                            <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Áp dụng
                    </button>
                    @if(request()->hasAny(['category', 'min_price', 'max_price', 'search']))
                        <a href="{{ route('products.index') }}" class="w-full block text-center mt-2 text-sm text-gray-600 hover:text-blue-600">
                            Xóa bộ lọc
                        </a>
                    @endif
                </form>
            </aside>

            <!-- Product Grid -->
            <main class="md:col-span-3">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{-- withQueryString() để giữ các tham số filter khi chuyển trang --}}
                        {{ $products->withQueryString()->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <h3 class="text-xl font-semibold">Không tìm thấy sản phẩm nào</h3>
                        <p class="text-gray-500 mt-2">Vui lòng thử lại với từ khóa hoặc bộ lọc khác.</p>
                        <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Xem tất cả sản phẩm
                        </a>
                    </div>
                @endif
            </main>
        </div>
        
    </div>
</x-frontend-layout>