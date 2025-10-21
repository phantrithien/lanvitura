<x-frontend-layout>
    <div class="container mx-auto mt-10 p-4">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold mb-6 text-center">Liên hệ với chúng tôi</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Họ và Tên</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                 <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                 <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700">Chủ đề</label>
                    <input type="text" name="subject" id="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                 <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700">Nội dung</label>
                    <textarea name="message" id="message" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Gửi tin nhắn</button>
                </div>
            </form>
        </div>
    </div>
</x-frontend-layout>