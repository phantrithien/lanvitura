@props(['product'])

<div
    class="bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group">
    <a href="{{ route('products.show', $product->slug) }}">
        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
            @if($product->images->isNotEmpty())
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}"
                    class="w-full h-full object-cover object-center group-hover:opacity-80 transition-opacity duration-300"
                    loading="lazy">
            @else
                {{-- Ảnh placeholder nếu không có ảnh --}}
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" ...></svg>
                </div>
            @endif
        </div>
    </a>
    <div class="p-4">
        <a href="{{ route('products.show', $product->slug) }}" class="hover:text-blue-600">
            <h3 class="text-lg font-semibold text-gray-800 truncate" title="{{ $product->name }}">
                {{ $product->name }}
            </h3>
        </a>
        <p class="text-xl font-bold text-gray-900 my-2">
            {{ number_format($product->price, 0, ',', '.') }} đ
        </p>

        <form action="{{ route('cart.add', $product->id) }}" method="POST
            @csrf
            <input type=" hidden" name="quantity" value="1">
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300 flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" ...>
                    <path ...></path>
                </svg>
                <span>Thêm vào giỏ</span>
            </button>
        </form>
    </div>
</div>