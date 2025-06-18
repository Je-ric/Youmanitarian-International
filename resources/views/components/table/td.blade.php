@props([
    'class' => '',
    'hideOnSmall' => false,
])

@php
    $baseClasses = 'px-4 py-2 align-middle text-sm font-normal';
    if ($hideOnSmall) {
        $baseClasses .= ' hidden sm:table-cell';
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<td class="{{ $classes }}">
    {{ $slot }}
</td> 