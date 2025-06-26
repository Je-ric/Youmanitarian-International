@props([
    'class' => '',
    'hideOnSmall' => false,
    'align' => 'left',
    'numeric' => false,
])

@php
    $baseClasses = 'px-4 py-3 align-middle text-sm font-normal text-gray-700 bg-[#ebf3fe] group-hover:bg-[#fff8e8] transition-colors duration-150';
    if ($hideOnSmall) {
        $baseClasses .= ' hidden sm:table-cell';
    }
    $baseClasses .= ' text-' . $align;
    if ($numeric) {
        $baseClasses .= ' font-mono text-right';
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<td class="{{ $classes }}">
    {{ $slot }}
</td> 