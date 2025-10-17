@php
    use Darryldecode\Cart\Facades\CartFacade as Cart;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Lanvitura')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-800">LANVITURA</a>
            <div>
                <a href="{{ route('products.index') }}" class="mx-2 text-gray-800 hover:text-gray-600">Sản phẩm</a>
                <a href="#" class="mx-2 text-gray-800 hover:text-gray-600">Bài viết</a>
                <a href="{{ route('cart.index') }}" class="mx-2 text-gray-800 hover:text-gray-600">
                    Giỏ hàng ({{ Cart::getTotalQuantity() }})
                </a>
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <footer class="bg-white mt-8 py-4">
        <div class="container mx-auto px-6 text-center text-gray-600">
            &copy; 2025 Phan Tri Thien. All Rights Reserved.
        </div>
    </footer>
</body>
</html>