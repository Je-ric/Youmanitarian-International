@props([
    'name' => 'search',
    'id' => null,
    'value' => '',
    'placeholder' => 'Search...',
    'class' => '',
])

{{--
Usage: <x-form.search-input name="search" placeholder="Search users..." />
--}}

@php
    $inputId = $id ?? $name;
@endphp
<div class="relative w-full">
    <input
        type="search"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors ' . $class]) }}
    />
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <i class='bx bx-search text-xl text-gray-400'></i>
    </span>
</div> 