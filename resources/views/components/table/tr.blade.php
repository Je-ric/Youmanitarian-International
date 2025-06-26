@props([
    'class' => '',
    'hover' => true,
])

@php
    $baseClasses = 'group [&>td]:border-y [&>td:first-child]:border-l [&>td:last-child]:border-r [&>td:first-child]:rounded-l-lg [&>td:last-child]:rounded-r-lg';
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<tr class="{{ $classes }}">
    {{ $slot }}
</tr> 