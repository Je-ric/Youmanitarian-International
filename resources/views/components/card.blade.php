@props([
    'title' => null,
    'icon' => null,
    'variant' => 'default', // default, gradient, minimal, elevated, bordered
    'size' => 'default', // small, default, large
    'headerColor' => null,
    'bodyColor' => null,
    'borderColor' => null,
    'shadow' => null,
    'rounded' => null,
    'headerClass' => '',
    'bodyClass' => '',
])

@php
    // Define 5 different card variants
    $variants = [
        'default' => [
            'container' => 'bg-white border border-gray-200 shadow-lg hover:shadow-xl',
            'header' => 'bg-gradient-to-r from-[#1a2235] to-[#2a3441] text-white',
            'body' => 'bg-white',
            'iconBg' => 'bg-white/20 backdrop-blur-sm',
            'iconColor' => 'text-white',
            'rounded' => 'rounded-xl',
        ],
        'gradient' => [
            'container' => 'bg-gradient-to-br from-white via-slate-50 to-gray-100 border border-gray-200/50 shadow-lg hover:shadow-2xl',
            'header' => 'bg-gradient-to-r from-[#ffb51b] via-[#f0a500] to-[#e6a017] text-[#1a2235]',
            'body' => 'bg-gradient-to-b from-white to-slate-50/50',
            'iconBg' => 'bg-[#1a2235]/10 backdrop-blur-sm',
            'iconColor' => 'text-[#1a2235]',
            'rounded' => 'rounded-2xl',
        ],
        'minimal' => [
            'container' => 'bg-white border-l-4 border-l-[#ffb51b] shadow-sm hover:shadow-md',
            'header' => 'bg-slate-50/80 text-[#1a2235] border-b border-gray-100',
            'body' => 'bg-white',
            'iconBg' => 'bg-[#ffb51b]/10',
            'iconColor' => 'text-[#ffb51b]',
            'rounded' => 'rounded-lg',
        ],
        'elevated' => [
            'container' => 'bg-white shadow-2xl hover:shadow-3xl border border-gray-100',
            'header' => 'bg-gradient-to-r from-[#1a2235] via-[#243447] to-[#1a2235] text-white relative overflow-hidden',
            'body' => 'bg-gradient-to-b from-white to-slate-50/30',
            'iconBg' => 'bg-gradient-to-br from-[#ffb51b] to-[#f0a500] shadow-lg',
            'iconColor' => 'text-white',
            'rounded' => 'rounded-2xl',
        ],
        'bordered' => [
            'container' => 'bg-white border-2 border-[#1a2235]/20 hover:border-[#ffb51b]/50 shadow-md hover:shadow-lg',
            'header' => 'bg-gradient-to-r from-[#1a2235]/5 to-[#ffb51b]/5 text-[#1a2235] border-b-2 border-[#ffb51b]/20',
            'body' => 'bg-white',
            'iconBg' => 'bg-gradient-to-br from-[#1a2235] to-[#2a3441]',
            'iconColor' => 'text-white',
            'rounded' => 'rounded-xl',
        ],
    ];

    // Size configurations
    $sizes = [
        'small' => [
            'headerPadding' => 'px-4 py-3',
            'bodyPadding' => 'p-4',
            'iconSize' => 'w-6 h-6',
            'iconText' => 'text-sm',
            'titleText' => 'text-base font-medium',
        ],
        'default' => [
            'headerPadding' => 'px-6 py-4',
            'bodyPadding' => 'p-6',
            'iconSize' => 'w-8 h-8',
            'iconText' => 'text-lg',
            'titleText' => 'text-lg font-semibold',
        ],
        'large' => [
            'headerPadding' => 'px-8 py-6',
            'bodyPadding' => 'p-8',
            'iconSize' => 'w-10 h-10',
            'iconText' => 'text-xl',
            'titleText' => 'text-xl font-bold',
        ],
    ];

    $config = $variants[$variant] ?? $variants['default'];
    $sizeConfig = $sizes[$size] ?? $sizes['default'];

    // Override with custom props if provided
    $containerClass = $config['container'];
    $headerClass = $headerColor ?? $config['header'];
    $bodyClass = $bodyColor ?? $config['body'];
    $roundedClass = $rounded ?? $config['rounded'];
@endphp

<div class="w-full {{ $containerClass }} {{ $roundedClass }} overflow-hidden transition-all duration-300 group">
    @if($title || $icon)
        <div class="flex items-center gap-3 {{ $sizeConfig['headerPadding'] }} {{ $headerClass }} {{ $headerClass }} relative">
            
            @if($variant === 'elevated')
                <!-- Decorative background pattern for elevated variant -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                </div>
            @endif

            @if($icon)
                <span class="relative inline-flex items-center justify-center {{ $sizeConfig['iconSize'] }} {{ $config['iconBg'] }} {{ $config['rounded'] }} transition-transform duration-300 group-hover:scale-110">
                    <i class="bx {{ $icon }} {{ $sizeConfig['iconText'] }} {{ $config['iconColor'] }}"></i>
                </span>
            @endif
            
            @if($title)
                <h3 class="relative {{ $sizeConfig['titleText'] }} tracking-tight flex-1">
                    {{ $title }}
                </h3>
            @endif

            @if($variant === 'gradient')
                <!-- Decorative accent for gradient variant -->
                <div class="absolute top-0 right-0 w-2 h-full bg-gradient-to-b from-[#1a2235] to-transparent opacity-20"></div>
            @endif
        </div>
    @endif
    
    <div class="{{ $sizeConfig['bodyPadding'] }} {{ $bodyClass }} {{ $bodyClass }} relative">
        @if($variant === 'minimal')
            <!-- Subtle accent line for minimal variant -->
            <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-[#ffb51b]/30 via-[#ffb51b]/10 to-transparent"></div>
        @endif
        
        {{ $slot }}
    </div>
</div>

{{--
Usage Examples:

<!-- Default Professional Card -->
<x-card title="Basic Information" icon="bx-info-circle">
    <p>Your content here...</p>
</x-card>

<!-- Gradient Accent Card -->
<x-card title="Schedule" icon="bx-calendar" variant="gradient">
    <p>Your content here...</p>
</x-card>

<!-- Minimal Clean Card -->
<x-card title="Statistics" icon="bx-bar-chart" variant="minimal" size="small">
    <p>Your content here...</p>
</x-card>

<!-- Elevated Premium Card -->
<x-card title="Important Notice" icon="bx-bell" variant="elevated" size="large">
    <p>Your content here...</p>
</x-card>

<!-- Bordered Formal Card -->
<x-card title="Documents" icon="bx-file" variant="bordered">
    <p>Your content here...</p>
</x-card>

<!-- Custom Colors -->
<x-card 
    title="Custom Card" 
    icon="bx-star" 
    variant="default"
    headerColor="bg-gradient-to-r from-emerald-600 to-teal-600 text-white"
    bodyColor="bg-emerald-50"
>
    <p>Your content here...</p>
</x-card>
--}}
