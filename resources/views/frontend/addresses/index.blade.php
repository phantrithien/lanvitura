@extends('layouts.frontend')
@section('title', 'Sổ địa chỉ')
@section('content')
    <h1 class="text-3xl font-bold mb-4">Sổ địa chỉ</h1>
    <a href="{{ route('addresses.create') }}" class="inline-block bg-black text-white py-2 px-4 uppercase tracking-wider font-semibold mb-8">Thêm địa chỉ mới</a>

    @if(session('success'))<div class="bg-green-100 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>@endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($addresses as $address)
            <div class="border p-6">
                <p class="font-bold">{{ $address->first_name }} {{ $address->last_name }}</p>
                <p>{{ $address->address }}</p>
                <p>{{ $address->city }}, {{ $address->country }}</p>
                <p>SĐT: {{ $address->phone }}</p>
                <div class="mt-4">
                    <a href="{{ route('addresses.edit', $address->id) }}" class="text-blue-600 underline">Chỉnh sửa</a>
                    <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('Bạn có chắc muốn xóa địa chỉ này?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 underline">Xóa</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-full">Bạn chưa có địa chỉ nào được lưu.</p>
        @endforelse
    </div>
@endsection