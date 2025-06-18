@props([
    'class' => '',
    'hover' => true,
    'selectable' => false,
])

@php
    $baseClasses = 'border-b border-gray-200';
    if ($hover) {
        $baseClasses .= ' hover:bg-gray-50 transition-colors duration-150';
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<tr class="{{ $classes }}">
    {{ $slot }}
</tr> 