<div class="grid grid-cols-2 gap-4">
    <div><label for="first_name">Tên*</label><input type="text" name="first_name" id="first_name" value="{{ old('first_name', $address->first_name ?? '') }}" class="w-full border p-2 mt-1" required></div>
    <div><label for="last_name">Họ*</label><input type="text" name="last_name" id="last_name" value="{{ old('last_name', $address->last_name ?? '') }}" class="w-full border p-2 mt-1" required></div>
    <div class="col-span-2"><label for="phone">Số điện thoại*</label><input type="text" name="phone" id="phone" value="{{ old('phone', $address->phone ?? '') }}" class="w-full border p-2 mt-1" required></div>
    <div class="col-span-2"><label for="address">Địa chỉ*</label><input type="text" name="address" id="address" value="{{ old('address', $address->address ?? '') }}" class="w-full border p-2 mt-1" required></div>
    <div><label for="city">Thành phố*</label><input type="text" name="city" id="city" value="{{ old('city', $address->city ?? '') }}" class="w-full border p-2 mt-1" required></div>
    <div><label for="country">Quốc gia*</label><input type="text" name="country" id="country" value="{{ old('country', $address->country ?? 'Vietnam') }}" class="w-full border p-2 mt-1" required></div>
</div>