@props(['class' => '', 'striped' => true])

@php
    $baseClasses = 'divide-y divide-gray-100';
    if ($striped) {
        $baseClasses .= ' [&>tr:nth-child(odd)]:bg-white';
        $baseClasses .= ' [&>tr:nth-child(even)]:bg-gray-50';
    }
    $classes = trim($baseClasses . ' ' . $class);
@endphp

<tbody class="{{ $classes }}">
    {{ $slot }}
</tbody> 