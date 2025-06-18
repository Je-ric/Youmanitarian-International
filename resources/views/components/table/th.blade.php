@props([
    'class' => '',
    'hideOnSmall' => false,
])

@php
    $baseClasses = 'px-4 py-2 text-left font-bold uppercase tracking-wider text-xs';
    if ($hideOnSmall) {
        $baseClasses .= ' hidden sm:table-cell';
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<th class="{{ $classes }}">
    {{ $slot }}
</th> 