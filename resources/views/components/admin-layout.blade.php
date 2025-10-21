<div class="min-h-screen bg-gray-100">
    <!-- Admin Navigation -->
    <nav class="bg-gray-800 text-white py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <a href="/admin" class="text-lg font-bold">Admin Dashboard</a>
            <div class="flex items-center gap-4">
                <a href="/admin/orders" class="hover:underline">Orders</a>
                <a href="/admin/products" class="hover:underline">Products</a>
                <a href="/admin/categories" class="hover:underline">Categories</a>
                <a href="/logout" class="hover:underline">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        {{ $slot }}
    </main>
</div>