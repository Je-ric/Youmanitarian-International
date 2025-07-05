@props([
    'cardGradient' => null,
    'cardColor' => 'bg-white',
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'iconColor' => 'text-gray-600',
    'iconBg' => 'bg-gray-100',
    'padding' => 'p-4 sm:p-6',
    'headerPadding' => 'pb-4',
])

<div class="relative block {{ $cardGradient ?? $cardColor }} rounded-xl border border-gray-200/50 shadow-lg hover:shadow-md transition-all duration-300 ease-in-out overflow-hidden">
    @if($title || $icon)
        <div class="flex items-center justify-between {{ $padding }} {{ $headerPadding }} border-b border-gray-200 bg-gradient-to-br from-indigo-50 via-indigo-100 to-white">
            <div class="flex-grow">
                @if($title)
                    <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] leading-tight">{{ $title }}</h3>
                    @if($subtitle)
                        <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
                    @endif
                @endif
            </div>
            @if($icon)
                <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-lg {{ $iconBg }} {{ $iconColor }}">
                    <i class="bx {{ $icon }} text-lg"></i>
                </div>
            @endif
        </div>
    @endif
    
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>

{{--
Usage: 
Basic:
<x-overview.main-card>
    <p>Card content goes here</p>
</x-overview.main-card>

With title:
<x-overview.main-card title="Card Title">
    <p>Card content goes here</p>
</x-overview.main-card>

With title and subtitle:
<x-overview.main-card title="Card Title" subtitle="Card subtitle">
    <p>Card content goes here</p>
</x-overview.main-card>

With icon:
<x-overview.main-card title="Card Title" icon="bx-chart" iconColor="text-blue-600" iconBg="bg-blue-100">
    <p>Card content goes here</p>
</x-overview.main-card>

With gradients:
<x-overview.main-card title="Card Title" cardGradient="bg-gradient-to-br from-blue-50 to-indigo-100">
    <p>Card content goes here</p>
</x-overview.main-card>

Custom padding:
<x-overview.main-card title="Card Title" padding="p-6">
    <p>Card content goes here</p>
</x-overview.main-card>

Used in:
- resources/views/programs_volunteers/partials/programOverview.blade.php
--}}