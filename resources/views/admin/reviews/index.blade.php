@extends('layouts.admin')
@section('title', 'Quản lý Đánh giá')
@section('content')
    <h1 class="text-2xl font-semibold">Quản lý Đánh giá</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative my-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6 bg-white shadow-md rounded-lg p-6">
        <table class="min-w-full">
            <thead>
                <tr class="border-b">
                    <th class="p-2 text-left">Người dùng</th>
                    <th class="p-2 text-left">Sản phẩm</th>
                    <th class="p-2 text-left">Đánh giá</th>
                    <th class="p-2 text-center">Rating</th>
                    <th class="p-2 text-center">Trạng thái</th>
                    <th class="p-2 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    <tr class="border-b">
                        <td class="p-2">{{ $review->user->name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $review->product->name ?? 'N/A' }}</td>
                        <td class="p-2">{{ $review->comment }}</td>
                        <td class="p-2 text-center text-yellow-500">{{ $review->rating }} &#9733;</td>
                        <td class="p-2 text-center">{{ $review->status }}</td>
                        <td class="p-2 text-center">
                            @if ($review->status == 'pending')
                                {{-- Form Approve --}}
                                <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="text-green-500 hover:text-green-700">Duyệt</button>
                                </form>
                                |
                                {{-- Form Reject --}}
                                <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800">Từ chối</button>
                                </form>
                                |
                            @endif
                            {{-- Form Delete --}}
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đánh giá này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center p-4">Chưa có đánh giá nào.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $reviews->links() }}</div>
    </div>
@endsection