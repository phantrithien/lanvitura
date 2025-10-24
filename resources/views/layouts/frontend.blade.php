<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lanvitura') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine.js đã được import qua app.js --}}
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">
    
    {{-- Khởi tạo Alpine.js cho menu mobile --}}
    <div x-data="{ openMenu: false }" class="min-h-screen">

        <header class="bg-white shadow-md sticky top-0 z-50">
            <nav class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    
                    <div class="flex items-center">
                        <button @click="openMenu = !openMenu" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-900 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': openMenu, 'inline-flex': !openMenu }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !openMenu, 'inline-flex': openMenu }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <a href="{{ route('home') }}" class="ml-3 md:ml-0 flex-shrink-0 flex items-center">
                            <span class="text-2xl font-bold text-blue-600">Lanvitura</span> 
                        </a>
                    </div>

                    <div class="hidden md:flex md:items-center md:space-x-6">
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition">Trang chủ</a>
                        <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition">Sản phẩm</a>
                        <a href="{{ route('blog.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition">Bài viết</a>
                        <a href="{{ route('about') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition">Về chúng tôi</a>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="hidden md:flex">
                            <form action="{{ route('products.index') }}" method="GET" class="relative">
                                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}"
                                    class="border-gray-300 rounded-full pl-10 pr-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                            </form>
                        </div>

                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" ...><path ...></path></svg>
                            
                            @php
                                $cartCount = session('cart') ? count(session('cart')) : 0;
                            @endphp
                            
                            @if($cartCount > 0)
                            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center transform translate-x-1/2 -translate-y-1/2">
                                {{ $cartCount }}
                            </span>
                            @endif
                        </a>
                    </div>
                </div>

                <div :class="{'block': openMenu, 'hidden': !openMenu}" class="hidden md:hidden absolute top-16 left-0 w-full bg-white shadow-lg z-40"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-4">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Trang chủ</a>
                        <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Sản phẩm</a>
                        <a href="{{ route('blog.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Bài viết</a>
                        <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50">Về chúng tôi</a>
                    </div>
                    <div class="p-4 border-t border-gray-200">
                        <form action="{{ route('products.index') }}" method="GET" class="relative">
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}"
                                class="w-full border-gray-300 rounded-full pl-10 pr-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                        </form>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            {{ $slot }}
        </main>

        <footer class="bg-gray-800 text-gray-300">
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h4 class="text-xl font-bold text-white mb-4">Lanvitura</h4>
                        <p class="text-sm">Chuyên cung cấp các sản phẩm chất lượng cao, mang lại trải nghiệm tốt nhất cho khách hàng.</p>
                        <div class="flex space-x-4 mt-4">
                            <a href="#" class="text-gray-400 hover:text-white transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">...</svg></a> {{-- Facebook icon --}}
                            <a href="#" class="text-gray-400 hover:text-white transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">...</svg></a> {{-- Instagram icon --}}
                            <a href="#" class="text-gray-400 hover:text-white transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">...</svg></a> {{-- Twitter icon --}}
                        </div>
                    </div>

                    <div>
                        <h5 class="text-lg font-semibold text-white mb-4">Liên kết nhanh</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition">Về chúng tôi</a></li>
                            <li><a href="#" class="hover:text-white transition">Chính sách bảo mật</a></li>
                            <li><a href="#" class="hover:text-white transition">Điều khoản sử dụng</a></li>
                            <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        </ul>
                    </div>

                    <div>
                        <h5 class="text-lg font-semibold text-white mb-4">Chăm sóc khách hàng</h5>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition">Hướng dẫn mua hàng</a></li>
                            <li><a href="#" class="hover:text-white transition">Chính sách đổi trả</a></li>
                            <li><a href="#" class="hover:text-white transition">Theo dõi đơn hàng</a></li>
                        </ul>
                    </div>

                    <div>
                        <h5 class="text-lg font-semibold text-white mb-4">Liên hệ</h5>
                        <ul class="space-y-2 text-sm">
                            <li>Địa chỉ: 123 Đường ABC, Quận 1, TP. HCM</li>
                            <li>Điện thoại: (028) 1234 5678</li>
                            <li>Email: support@lanvitura.com</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
                    &copy; {{ date('Y') }} Lanvitura. Đã đăng ký bản quyền.
                </div>
            </div>
        </footer>

    </div>
</body>
</html>