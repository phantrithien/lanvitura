@extends('layouts.frontend')
@section('title', 'Chỉnh sửa địa chỉ')
@section('content')
    <h1 class="text-3xl font-bold mb-8">Chỉnh sửa địa chỉ</h1>
    <form action="{{ route('addresses.update', $address->id) }}" method="POST" class="max-w-2xl">
        @csrf
        @method('PUT')
        @include('frontend.addresses.partials.form', ['address' => $address])
        <button type="submit" class="bg-black text-white py-2 px-6 uppercase tracking-wider font-semibold mt-6">Cập nhật</button>
    </form>
@endsection