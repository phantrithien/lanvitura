<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold">Danh mục Bài viết</h2>
                    <a href="{{ route('admin.post-categories.create') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Thêm mới</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                         <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Tên</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Slug</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($postCategories as $category)
                            <tr class="border-b">
                                <td class="py-3 px-4">{{ $category->name }}</td>
                                <td class="py-3 px-4">{{ $category->slug }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('admin.post-categories.edit', $category->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.post-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>