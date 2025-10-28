{{-- resources/views/admin/tags/partials/form.blade.php --}}

@csrf

<div class="space-y-6">
    <div>
        <x-input-label for="name" :value="__('Tên từ khoá')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" maxlength="255"
            :value="old('name', $tag->name ?? '')" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="slug" :value="__('Slug (tuỳ chọn)')" />
        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" maxlength="255"
            :value="old('slug', $tag->slug ?? '')" />
        <p class="mt-1 text-xs text-gray-500">Để trống nếu muốn hệ thống tự tạo slug từ tên tag.</p>
        <x-input-error class="mt-2" :messages="$errors->get('slug')" />
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const nameInput = document.getElementById('name');
                const slugInput = document.getElementById('slug');

                if (!nameInput || !slugInput) {
                    return;
                }

                const slugify = (value) => value
                    .toString()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/-{2,}/g, '-')
                    .replace(/^-|-$/g, '');

                if (slugInput.value.trim().length) {
                    slugInput.dataset.autoslugTouched = 'true';
                }

                nameInput.addEventListener('input', () => {
                    if (slugInput.dataset.autoslugTouched === 'true') {
                        return;
                    }

                    slugInput.value = slugify(nameInput.value);
                });

                slugInput.addEventListener('input', () => {
                    slugInput.dataset.autoslugTouched = slugInput.value.trim().length ? 'true' : 'false';
                });
            });
        </script>
    @endpush
@endonce
