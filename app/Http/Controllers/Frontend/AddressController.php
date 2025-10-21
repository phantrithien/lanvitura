<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses;
        return view('frontend.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('frontend.addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required', 'last_name' => 'required',
            'phone' => 'required', 'address' => 'required',
            'city' => 'required', 'country' => 'required',
        ]);
        Auth::user()->addresses()->create($request->all());
        return redirect()->route('addresses.index')->with('success', 'Thêm địa chỉ mới thành công.');
    }

    public function edit(CustomerAddress $address)
    {
        // Đảm bảo người dùng chỉ có thể sửa địa chỉ của chính họ
        abort_if($address->user_id !== Auth::id(), 403);
        return view('frontend.addresses.edit', compact('address'));
    }

    public function update(Request $request, CustomerAddress $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);
        $request->validate([
            'first_name' => 'required', 'last_name' => 'required',
            'phone' => 'required', 'address' => 'required',
            'city' => 'required', 'country' => 'required',
        ]);
        $address->update($request->all());
        return redirect()->route('addresses.index')->with('success', 'Cập nhật địa chỉ thành công.');
    }

    public function destroy(CustomerAddress $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);
        $address->delete();
        return redirect()->route('addresses.index')->with('success', 'Xóa địa chỉ thành công.');
    }
}