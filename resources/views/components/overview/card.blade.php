@props([
    'title' => null,
    'icon' => null,
    'variant' => 'default',
    'headerColor' => null,
    'bodyColor' => null,
    'borderColor' => null,
    'headerClass' => '',
    'bodyClass' => '',
])

@php
    $variants = [
        'default' => [
            'container' => 'bg-white border border-gray-200',
            'shadow' => 'shadow-lg',
            'header' => 'bg-gradient-to-r from-[#1a2235] to-[#2a3441] text-white',
            'body' => 'bg-white',
            'iconBg' => 'bg-white/20 backdrop-blur-sm',
            'iconColor' => 'text-white',
        ],
        'gradient' => [
            'container' => 'bg-gradient-to-br from-white via-slate-50 to-gray-100 border border-gray-200/50',
            'shadow' => 'shadow-lg',
            'header' => 'bg-gradient-to-r from-[#ffb51b] via-[#f0a500] to-[#e6a017] text-[#1a2235]',
            'body' => 'bg-gradient-to-b from-white to-slate-50/50',
            'iconBg' => 'bg-[#1a2235]/10 backdrop-blur-sm',
            'iconColor' => 'text-[#1a2235]',
        ],
        'minimal' => [
            'container' => 'bg-slate-50 border border-gray-200',
            'shadow' => 'shadow',
            'header' => 'bg-white text-[#1a2235] border-b border-gray-100',
            'body' => 'bg-slate-50',
            'iconBg' => 'bg-[#1a2235]/5',
            'iconColor' => 'text-[#1a2235]',
        ],
        'elevated' => [
            'container' => 'bg-white border border-gray-100',
            'shadow' => 'shadow-lg',
            'header' => 'bg-gradient-to-r from-[#1a2235] via-[#2a3441] to-[#1a2235] text-white relative overflow-hidden',
            'body' => 'bg-gradient-to-b from-white to-slate-50/30',
            'iconBg' => 'bg-gradient-to-br from-[#ffb51b] to-[#f0a500]',
            'iconColor' => 'text-white',
        ],
        'bordered' => [
            'container' => 'bg-white border-2 border-[#1a2235]/20 hover:border-[#ffb51b]/50',
            'shadow' => 'shadow-lg',
            'header' => 'bg-gradient-to-r from-[#1a2235]/5 to-[#ffb51b]/5 text-[#1a2235] border-b-2 border-[#ffb51b]/20',
            'body' => 'bg-white',
            'iconBg' => 'bg-gradient-to-br from-[#1a2235] to-[#2a3441]',
            'iconColor' => 'text-white',
        ],
        'midnight-header' => [
            'container' => 'bg-white border border-gray-200',
            'shadow' => 'shadow-lg',
            'header' => 'bg-gradient-to-r from-gray-900 via-slate-800 to-indigo-900 text-white',
            'body' => 'bg-white',
            'iconBg' => 'bg-white/20 backdrop-blur-sm',
            'iconColor' => 'text-[#ffb51b]',
        ],
    ];

    $config = $variants[$variant] ?? $variants['default'];

    $containerClass = $config['container'];
    $shadowClass = $config['shadow'];
    $headerClass = $headerColor ?? $config['header'];
    $bodyClass = $bodyColor ?? $config['body'];
@endphp

<div class="w-full {{ $containerClass }} {{ $shadowClass }} rounded-xl overflow-hidden transition-all duration-300 group">
    @if($title || $icon)
        <div class="flex items-center gap-3 px-6 py-4 {{ $headerClass }} {{ $headerClass }} relative">
            
            @if($variant === 'elevated')
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                </div>
            @endif

            @if($icon)
                <span class="relative inline-flex items-center justify-center w-8 h-8 {{ $config['iconBg'] }} rounded-xl transition-transform duration-300 group-hover:scale-110">
                    <i class="bx {{ $icon }} text-lg {{ $config['iconColor'] }}"></i>
                </span>
            @endif
            
            @if($title)
                <h3 class="relative text-lg font-semibold tracking-tight flex-1">
                    {{ $title }}
                </h3>
            @endif

            @if($variant === 'gradient')
                <!-- Decorative accent for gradient variant -->
                <div class="absolute top-0 right-0 w-2 h-full bg-gradient-to-b from-[#1a2235] to-transparent opacity-20"></div>
            @endif
        </div>
    @endif
    
    <div class="p-6 {{ $bodyClass }} {{ $bodyClass }} relative">
        {{ $slot }}
    </div>
</div>

{{--
Usage Examples:

<!-- Default Professional Card -->
<x-overview.card title="Basic Information" icon="bx-info-circle">
    <p>Your content here...</p>
</x-overview.card>

<!-- Gradient Accent Card -->
<x-overview.card title="Schedule" icon="bx-calendar" variant="gradient">
    <p>Your content here...</p>
</x-overview.card>

<!-- Minimal Clean Card -->
<x-overview.card title="Statistics" icon="bx-bar-chart" variant="minimal">
    <p>Your content here...</p>
</x-overview.card>

<!-- Elevated Premium Card -->
<x-overview.card title="Important Notice" icon="bx-bell" variant="elevated">
    <p>Your content here...</p>
</x-overview.card>

<!-- Bordered Formal Card -->
<x-overview.card title="Documents" icon="bx-file" variant="bordered">
    <p>Your content here...</p>
</x-overview.card>

<!-- Custom Colors -->
<x-overview.card 
    title="Custom Card" 
    icon="bx-star" 
    variant="default"
    headerColor="bg-gradient-to-r from-emerald-600 to-teal-600 text-white"
    bodyColor="bg-emerald-50"
>
    <p>Your content here...</p>
</x-overview.card>

Used in:
- resources/views/member/partials/membersOverview.blade.php
- resources/views/programs_volunteers/partials/programOverview.blade.php
- resources/views/components/showcase.blade.php
--}} 