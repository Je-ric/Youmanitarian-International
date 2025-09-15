@props([
    'title' => 'Accordion Title',
    'variant' => 'dark',
])

@php
    $variants = [
        'dark' => [
            'container' => 'border border-[#FFB51B] bg-transparent',
            'title' => 'text-white',
            'content' => 'text-white',
        ],
        'light' => [
            'container' => 'border border-[#FFB51B] bg-white',
            'title' => 'text-[#1A2235]',
            'content' => 'text-gray-700',
        ],
    ];

    $config = $variants[$variant] ?? $variants['dark'];
@endphp

<div tabindex="0" class="collapse collapse-plus {{ $config['container'] }} rounded-box">
    <div class="collapse-title text-lg font-semibold {{ $config['title'] }}">
        {{ $title }}
    </div>
    <div class="collapse-content leading-relaxed {{ $config['content'] }}">
        {{ $slot }}
    </div>
</div>

{{-- <x-accordion title="Dark Accordion">
    This is a dark accordion with white text and yellow border.
</x-accordion>

<x-accordion title="Light Accordion" variant="light">
    This is a light accordion with dark text and yellow border.
</x-accordion> --}}
