@props([
    'class' => '',
    'hideOnSmall' => false,
    'align' => 'left',
    'numeric' => false,
])

@php
    $baseClasses = 'px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 group-hover:bg-[#fff8e8]';
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