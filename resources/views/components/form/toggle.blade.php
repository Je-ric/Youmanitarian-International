@props([
    'name',
    'checked' => false,
    'label' => '',
    'id' => null,
])
@php
    $id = $id ?? $name . '_' . uniqid();
@endphp
<label for="{{ $id }}" class="flex items-center cursor-pointer select-none gap-2">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $checked ? 'checked' : '' }}
        class="toggle toggle-warning"
    >
    @if($label)
        <span class="text-sm text-gray-700">{{ $label }}</span>
    @endif
</label>