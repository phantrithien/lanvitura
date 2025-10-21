<x-frontend-layout>

    <div class="relative bg-gray-900">
        <div aria-hidden="true" class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?q=80&w=1964&auto=format&fit=crop" alt="Background Image" class="h-full w-full object-cover object-center">
        </div>
        <div aria-hidden="true" class="absolute inset-0 bg-gray-900 opacity-50"></div>

        <div class="relative mx-auto flex max-w-3xl flex-col items-center px-6 py-32 text-center sm:py-64 lg:px-0">
            <a href="{{ route('products.index') }}" class="mt-8 inline-block rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700">Xem sản phẩm</a>
        </div>
    </div>


    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Sản phẩm mới nhất</h2>

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @forelse ($products as $product)
                    <div class="group relative">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
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
                            <p class="text-sm font-medium text-gray-900">{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                        </div>
                    </div>
                @empty
                    <p class="col-span-4 text-center text-gray-500">Hiện chưa có sản phẩm nào.</p>
                @endforelse
            </div>

            <div class="mt-12 text-center">
                 <a href="{{ route('products.index') }}" class="text-indigo-600 font-semibold hover:text-indigo-500">
                    Xem tất cả sản phẩm<span aria-hidden="true"> &rarr;</span>
                </a>
            </div>
        </div>
    </div>

</x-frontend-layout>