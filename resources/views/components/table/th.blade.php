@props([
    'class' => '',
    'hideOnSmall' => false,
    'align' => 'left',
])

@php
    $baseClasses = 'px-6 py-3 text-left font-medium tracking-wider text-xs';
    if ($hideOnSmall) {
        $baseClasses .= ' hidden sm:table-cell';
    }
    if ($align !== 'left') {
        $baseClasses = str_replace('text-left', 'text-' . $align, $baseClasses);
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<th scope="col" class="{{ $classes }}">
    {{ $slot }}
</th> 