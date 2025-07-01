@props([
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'class' => '',
    'label' => null,
    'pattern' => null,
])

@php
    $inputId = $id ?? $name;
    $inputType = $type === 'name' ? 'text' : $type;
    $inputPattern = $pattern;
    if ($type === 'name' && !$pattern) {
        $inputPattern = '[A-Za-z\s]+';
    }
@endphp

@if($label)
    <label for="{{ $inputId }}" class="block text-sm font-semibold text-[#1a2235] mb-2">{{ $label }}</label>
@endif
<input
    name="{{ $name }}"
    id="{{ $inputId }}"
    type="{{ $inputType }}"
    value="{{ old($name, $value) }}"
    placeholder="{{ $placeholder }}"
    @if($required) required @endif
    @if($inputPattern) pattern="{{ $inputPattern }}" @endif
    {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg ring-1 ring-gray-200 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] focus:ring-offset-0 transition ' . $class]) }}
/>
@error($name)
    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
@enderror 