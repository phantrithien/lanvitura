<x-frontend-layout>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Kết quả tìm kiếm cho: "{{ $query }}"
            </h2>

            @if($products->count() > 0)
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach ($products as $product)
                        <div class="group relative">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                                <img src="{{ asset('storage/' . ($product->images->first()->image_path ?? '')) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            <span aria-hidden="true" class="absolute inset-0"></span>
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                </div>
                                <p class="text-sm font-medium text-gray-900">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                 <div class="mt-8">
                    {{-- Giữ lại query string khi chuyển trang --}}
                    {{ $products->appends(['query' => $query])->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-xl text-gray-600">Không tìm thấy sản phẩm nào phù hợp.</p>
                </div>
            @endif
        </div>
    </div>
</x-frontend-layout>
