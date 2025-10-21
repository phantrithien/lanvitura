<x-admin-layout>
    <div class="py-12 w-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Quản lý Thành viên</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">ID</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Tên</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Email</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Vai trò</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Ngày tham gia</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Địa chỉ</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Số điện thoại</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($users as $user)
                            <tr class="border-b">
                                <td class="py-3 px-4 text-center">{{ $user->id }}</td>
                                <td class="py-3 px-4">{{ $user->name }}</td>
                                <td class="py-3 px-4">{{ $user->email }}</td>
                                <td class="py-3 px-4 text-center">{{ ucfirst($user->role) }}</td>
                                <td class="py-3 px-4 text-center">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4 text-center">{{ $user->address }}</td>
                                <td class="py-3 px-4 text-center">{{ $user->phone }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex item-center justify-center">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" /></svg>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thành viên này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>