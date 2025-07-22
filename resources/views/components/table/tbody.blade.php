@props(['class' => '', 'striped' => true])

@php
    $baseClasses = '';
    if ($striped) {
        // $baseClasses .= ' [&>tr:nth-child(odd)>td]:bg-white';
        // $baseClasses .= ' [&>tr:nth-child(even)>td]:bg-gray-100';
        $baseClasses .= 'bg-white';
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<tbody class="{{ $classes }}">
    {{ $slot }}
</tbody>
