<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - Lanvitura</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { display: flex; }
        .sidebar { width: 250px; background: #2d3748; color: white; height: 100vh; padding: 20px; }
        .sidebar a { display: block; color: white; padding: 10px; text-decoration: none; border-radius: 5px; }
        .sidebar a:hover { background: #4a5568; }
        .main-content { flex-grow: 1; padding: 20px; }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="sidebar">
        <h2>Lanvitura Admin</h2>
        <nav>
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.categories.index') }}">Quản lý Danh mục</a>
            <a href="{{ route('admin.products.index') }}">Quản lý Sản phẩm</a>
            <a href="{{ route('admin.orders.index') }}">Quản lý Đơn hàng</a>
            <a href="{{ route('admin.reviews.index') }}">Quản lý Đánh giá</a>
            <a href="{{ route('admin.users.index') }}">Quản lý thành viên</a>
            <a href="{{ route('admin.contacts.index') }}">Quản lý liên hệ</a>
            <a href="{{ route('admin.tags.index') }}">Quản lý từ khoá</a>
            <a href="{{ route('admin.post-categories.index') }}">Danh mục Bài viết</a>

            {{-- THÊM NÚT ĐĂNG XUẤT VÀO ĐÂY --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                            this.closest('form').submit();">
                    Đăng xuất
                </a>
            </form>
        </nav>
    </div>

    <main class="main-content">
        @yield('content')
    </main>
</body>
</html>