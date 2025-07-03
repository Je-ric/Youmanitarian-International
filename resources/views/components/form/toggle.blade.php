@props([
    'name',
    'checked' => false,
    'label' => '',
    'id' => null,
])

{{--
Usage: <x-form.toggle name="notifications" label="Enable Notifications" checked="{{ old('notifications') }}" />
       <x-form.toggle name="public_profile" checked="true" />

Used in:
- resources/views/profile/show.blade.php
- resources/views/programs/modals/feedbackModal.blade.php
--}}

@php
    $id = $id ?? $name . '_' . uniqid();
@endphp
<label for="{{ $id }}" class="flex items-center cursor-pointer select-none gap-2">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id }}"
        value="1"
        {{ $checked ? 'checked' : '' }}
        class="w-10 h-5 rounded-full border-2 border-gray-300 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] checked:bg-[#ffb51b] transition-colors"
    >
    @if($label)
        <span class="text-sm text-gray-700">{{ $label }}</span>
    @endif
</label> 