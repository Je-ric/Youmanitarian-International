@props([
    'count',
    'title',
    'icon',
    'type' => 'info', 
    'subtitle' => null,
    'cardGradient' => null,
])

@php
    $typeClasses = [
        'primary' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-200',
            'icon' => 'text-blue-600',
            'iconBg' => 'bg-blue-100',
            'text' => 'text-blue-900',
            'countText' => 'text-blue-700',
        ],
        'secondary' => [
            'bg' => 'bg-amber-50',
            'border' => 'border-amber-200',
            'icon' => 'text-amber-600',
            'iconBg' => 'bg-amber-100',
            'text' => 'text-amber-900',
            'countText' => 'text-amber-700',
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'icon' => 'text-green-600',
            'iconBg' => 'bg-green-100',
            'text' => 'text-green-900',
            'countText' => 'text-green-700',
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'icon' => 'text-red-600',
            'iconBg' => 'bg-red-100',
            'text' => 'text-red-900',
            'countText' => 'text-red-700',
        ],
        'info' => [
            'bg' => 'bg-sky-50',
            'border' => 'border-sky-200',
            'icon' => 'text-sky-600',
            'iconBg' => 'bg-sky-100',
            'text' => 'text-sky-900',
            'countText' => 'text-sky-700',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-200',
            'icon' => 'text-yellow-600',
            'iconBg' => 'bg-yellow-100',
            'text' => 'text-yellow-900',
            'countText' => 'text-yellow-700',
        ],
        'neutral' => [
            'bg' => 'bg-gray-50',
            'border' => 'border-gray-200',
            'icon' => 'text-gray-600',
            'iconBg' => 'bg-gray-100',
            'text' => 'text-gray-900',
            'countText' => 'text-gray-700',
        ],
    ];
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<div class="relative block p-3 {{ $cardGradient ?? $classes['bg'] }} rounded-lg border {{ $classes['border'] }} hover:shadow-md transition-all duration-200 ease-in-out">
    <div class="flex items-center space-x-3">
        <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-lg {{ $classes['iconBg'] }} {{ $classes['icon'] }}">
            <i class="bx {{ $icon }} text-sm"></i>
        </div>
        <div class="flex-grow min-w-0">
    <div class="flex items-center justify-between">
                <p class="text-xs font-medium text-gray-600 truncate">{{ $title }}</p>
                <span class="text-sm font-bold {{ $classes['countText'] }}">{{ $count }}</span>
            </div>
            @if($subtitle)
                <p class="text-xs text-gray-500 mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</div>

{{--
Usage: <x-overview.count-alert count="1,234" title="Total Users" icon="bx-users" type="primary" />
       <x-overview.count-alert count="89%" title="Success Rate" icon="bx-check-circle" type="success" subtitle="Last 30 days" />
       <x-overview.count-alert count="12" title="Pending" icon="bx-time" type="warning" />
       
       With custom gradients:
       <x-overview.count-alert count="1,234" title="Total Users" icon="bx-users" cardGradient="bg-gradient-to-br from-purple-50 to-violet-100" />

Used in:
- resources/views/programs_volunteers/partials/programOverview.blade.php
- resources/views/dashboard.blade.php
- resources/views/finance/donations.blade.php
--}}
