@props([
    'count',
    'title',
    'icon',
    'type' => 'info', 
    'subtitle' => null,
])

@php
    $typeClasses = [
        'primary' => [
            'bg' => 'bg-[#F5F6FA]',
            'border' => 'border-[#1A2235]',
            'icon' => 'text-[#1A2235]',
        ],
        'secondary' => [
            'bg' => 'bg-[#FFF7E0]',
            'border' => 'border-[#FFB51B]',
            'icon' => 'text-[#FFB51B]',
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'icon' => 'text-green-600',
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'icon' => 'text-red-600',
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-200',
            'icon' => 'text-blue-600',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-200',
            'icon' => 'text-yellow-600',
        ],
        'neutral' => [
            'bg' => 'bg-gray-100',
            'border' => 'border-gray-200',
            'icon' => 'text-gray-500',
        ],
    ];
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<div class="{{ $classes['bg'] }} border {{ $classes['border'] }} rounded-lg shadow-sm px-4 py-3 flex items-center justify-between min-h-[80px]">
    <div>
        <h4 class="text-xs sm:text-sm font-semibold text-gray-700 mb-1">{{ $title }}</h4>
        <p class="text-2xl font-extrabold text-gray-900 leading-tight">{{ $count }}</p>
        @if($subtitle)
            <p class="text-xs text-gray-500 mt-1">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="flex items-center justify-center w-12 h-12 bg-white rounded-full shadow-inner border {{ $classes['border'] }}">
        <i class='bx {{ $icon }} text-2xl {{ $classes['icon'] }}'></i>
    </div>
</div>
