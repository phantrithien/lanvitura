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
            <div class="flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="mx-2 text-gray-800 hover:text-gray-600">Sản phẩm</a>
                <a href="{{ route('cart.index') }}" class="mx-2 inline-flex items-center gap-2 text-gray-800 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6.4A1 1 0 007 21h10a1 1 0 00.98-.804L19 13M7 13H5.4" />
                    </svg>
                    <span class="hidden sm:inline">Giỏ hàng</span>
                    <span id="cart-badge-count" class="inline-block bg-red-600 text-white text-xs font-semibold rounded-full px-2 py-0.5">{{ \Cart::getContent()->count() ?? 0 }}</span>
                </a>

                <form action="{{ route('products.search') }}" method="GET" class="flex">
                    <input type="text"
                           name="query"
                           required
                           class="rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-2 py-1"
                           placeholder="Tìm kiếm sản phẩm..."
                           value="{{ request('query') ?? '' }}">
                    <button type="submit" class="inline-flex items-center justify-center rounded-r-md border border-transparent bg-indigo-600 px-3 py-1 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                             <x-dropdown-link :href="route('user.orders.index')">
                                {{ __('Đơn hàng của tôi') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Profile
                    </a>
                @endauth
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
    <script>
        (function(){
            const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1] || null;

            const flashMessage = (text, isError) => {
                const el = document.createElement('div');
                el.textContent = text;
                el.className = `fixed top-6 right-6 px-4 py-2 rounded shadow ${isError ? 'bg-red-600' : 'bg-green-600'} text-white`;
                document.body.appendChild(el);
                setTimeout(() => el.remove(), 3000);
            };

            document.addEventListener('submit', (e) => {
                const form = e.target.closest('form.ajax-add-to-cart');
                if (!form) return;
                e.preventDefault();

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: new FormData(form)
                })
                .then(res => res.json())
                .then(json => {
                    const badge = document.getElementById('cart-badge-count');
                    if (json?.success) {
                        if (badge) badge.textContent = json.count ?? badge.textContent;
                        flashMessage(json.message || 'Đã thêm vào giỏ hàng');
                    } else {
                        flashMessage(json?.message || 'Không thể thêm sản phẩm', true);
                    }
                })
                .catch(() => flashMessage('Lỗi mạng, vui lòng thử lại', true));
            });
        })();
    </script>
</body>
</html>