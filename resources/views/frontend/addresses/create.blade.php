@extends('layouts.frontend')
@section('title', 'Thêm địa chỉ mới')
@section('content')
    <h1 class="text-3xl font-bold mb-8">Thêm địa chỉ mới</h1>
    <form action="{{ route('addresses.store') }}" method="POST" class="max-w-2xl">
        @csrf
        @include('frontend.addresses.partials.form')
        <button type="submit" class="bg-black text-white py-2 px-6 uppercase tracking-wider font-semibold mt-6">Thêm địa chỉ</button>
    </form>
@endsection