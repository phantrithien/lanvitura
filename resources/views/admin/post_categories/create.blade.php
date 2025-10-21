<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Thêm Danh mục Bài viết mới</h2>
                <form action="{{ route('admin.post-categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên danh mục</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>