@props([
    'class' => '',
    'hideOnSmall' => false,
    'align' => 'left',
])

@php
    $baseClasses = 'px-4 py-3 text-left font-bold uppercase tracking-wider text-xs';
    if ($hideOnSmall) {
        $baseClasses .= ' hidden sm:table-cell';
    }
    if ($align !== 'left') {
        $baseClasses = str_replace('text-left', 'text-' . $align, $baseClasses);
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<th class="{{ $classes }}">
    {{ $slot }}
</th> 