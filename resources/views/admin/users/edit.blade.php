<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Chỉnh sửa Thành viên</h2>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                     <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700">Vai trò</label>
                        <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="user" @selected($user->role == 'user')>User</option>
                            <option value="admin" @selected($user->role == 'admin')>Admin</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Cập nhật</button>
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 ml-2">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>