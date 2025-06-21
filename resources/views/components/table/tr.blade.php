@props([
    'class' => '',
    'hover' => true,
    'selectable' => false,
])

@php
    $baseClasses = 'border-b border-gray-100';
    if ($hover) {
        $baseClasses .= ' hover:bg-[#D1D3D7] transition-colors duration-150';
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<tr class="{{ $classes }}">
    {{ $slot }}
</tr> 