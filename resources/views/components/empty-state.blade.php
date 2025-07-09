@props([
    'icon' => 'bx bx-info-circle',
    'title' => 'Nothing Here',
    'description' => 'There is no information to display.',
    'size' => 'default', // 'default' or 'small'
])

@php
    $isSmall = $size === 'small';
@endphp

<div class="w-full flex flex-col items-center justify-center {{ $isSmall ? 'py-4 px-2' : 'py-10 px-3' }} text-center">
    <div class="{{ $isSmall ? 'w-8 h-8 mb-2' : 'w-14 h-14 mb-3' }} rounded-full flex items-center justify-center bg-gray-100">
        <i class="{{ $icon }} {{ $isSmall ? 'text-lg' : 'text-2xl' }} text-gray-400"></i>
    </div>
    <h3 class="{{ $isSmall ? 'text-xs font-medium mb-0.5' : 'text-base md:text-lg font-medium mb-1' }} text-gray-700">{{ $title }}</h3>
    <p class="{{ $isSmall ? 'text-xs' : 'text-sm md:text-base' }} text-gray-400 mx-auto leading-normal font-normal">{{ $description }}</p>
</div>

<style>
@media (max-width: 640px) {
    .max-w-xs { max-width: 16rem; }
    .text-base { font-size: 1rem; }
    .text-xs { font-size: 0.85rem; }
}
@media (max-width: 480px) {
    .max-w-xs { max-width: 12rem; }
    .text-base { font-size: 0.95rem; }
    .text-xs { font-size: 0.8rem; }
}
</style>

{{--
Usage:
<x-empty-state icon="bx bx-calendar-check" title="No Attendance Records" description="Nothing to show here." />
<x-empty-state icon="bx bx-image" title="No Proof" description="No proof image uploaded" size="small" />
--}}
