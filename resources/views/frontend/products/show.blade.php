<x-frontend-layout>
    <div class="bg-white">
        <div class="pt-6">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2">
                        <li><a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-600">Sản phẩm</a></li>
                        <li><span class="text-sm text-gray-400">/</span></li>
                        <li><span class="text-sm font-medium text-gray-900">{{ $product->name }}</span></li>
                    </ol>
                </nav>

                <div class="mx-auto max-w-2xl pt-10 pb-16 lg:max-w-7xl lg:grid lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:pt-16 lg:pb-24">
                    <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center rounded-lg shadow-md">
                            {{-- TODO: Thêm gallery ảnh nhỏ ở đây nếu có nhiều ảnh --}}
                        @else
                            <div class="aspect-w-1 aspect-h-1 w-full rounded-lg bg-gray-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 lg:row-span-3 lg:mt-0">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $product->name }}</h1>
                        <h2 class="sr-only">Thông tin sản phẩm</h2>
                        <p class="text-3xl tracking-tight text-gray-900 mt-4">
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        </p>

                        @if (session('success'))
                            <div class="mt-4 rounded-md bg-green-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.06 0l4.06-5.576z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('cart.store', $product) }}" method="POST" class="mt-10">
                            @csrf

                            <div class="mt-10">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-gray-900">Số lượng</h3>
                                </div>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                       class="mt-2 block w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>

                            <button type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-blue-600 px-8 py-3 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>

                    <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pr-8 lg:pt-6">
                        <div>
                            <h3 class="sr-only">Mô tả</h3>
                            <div class="space-y-6 text-base text-gray-900">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>