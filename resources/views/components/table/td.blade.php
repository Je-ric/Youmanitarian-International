@props([
    'class' => '',
    'hideOnSmall' => false,
    'align' => 'left',
])

@php
    $baseClasses = 'px-4 py-3 align-middle text-sm font-normal text-gray-700';
    if ($hideOnSmall) {
        $baseClasses .= ' hidden sm:table-cell';
    }
    $baseClasses .= ' text-' . $align;
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<td class="{{ $classes }}">
    {{ $slot }}
</td> 