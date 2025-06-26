@props([
    'class' => '',
    'hover' => true,
    'selectable' => false,
])

@php
    $baseClasses = 'group border border-gray-200';
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<tr class="{{ $classes }}">
    {{ $slot }}
</tr> 