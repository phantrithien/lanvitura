<x-frontend-layout>
    <div class="container mx-auto mt-20 text-center p-4">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
             <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-2">Đặt hàng thành công!</h1>
            <p class="text-gray-600 mb-6">Cảm ơn bạn đã mua hàng. Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng sớm nhất.</p>
            <a href="{{ route('home') }}" class="inline-block bg-indigo-500 text-white font-semibold py-2 px-6 rounded hover:bg-indigo-600">
                Tiếp tục mua sắm
            </a>
        </div>
    </div>
</x-frontend-layout>
