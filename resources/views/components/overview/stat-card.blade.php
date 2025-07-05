@props([
    'icon',
    'title',
    'value',
    'percentage' => null,
    'percentage_type' => 'increase',
    'period' => null,
    'href' => '#',
    'bgColor' => 'bg-accent/10',
    'iconColor' => 'text-accent',
    'cardColor' => 'bg-white',
    'cardGradient' => null,
    'gradientVariant' => null,
    'note' => null,
])

@php
    $gradientVariants = [
        'emerald' => 'bg-gradient-to-br from-emerald-50 via-emerald-100 to-white',
        'rose' => 'bg-gradient-to-br from-red-50 via-rose-100 to-white',
        'indigo' => 'bg-gradient-to-br from-indigo-50 via-indigo-100 to-white',
        'sky' => 'bg-gradient-to-br from-sky-50 via-sky-100 to-white',
        'amber' => 'bg-gradient-to-br from-amber-50 via-amber-100 to-white',
        'lime' => 'bg-gradient-to-br from-lime-50 via-lime-100 to-white',
        'purple' => 'bg-gradient-to-br from-purple-50 via-purple-100 to-white',
        'fuchsia' => 'bg-gradient-to-br from-fuchsia-50 via-fuchsia-100 to-white',
        'brand' => 'bg-gradient-to-br from-[#1a2235] to-[#ffb51b]',
        'slate' => 'bg-gradient-to-br from-slate-700 to-slate-500',
        'deep-rose' => 'bg-gradient-to-br from-red-800 to-rose-600',
        'teal' => 'bg-gradient-to-br from-teal-50 via-teal-100 to-white',
        'glassmorphism' => 'bg-white/60 backdrop-blur-lg ring-1 ring-black/5',
        'sunset' => 'bg-gradient-to-br from-orange-600 to-amber-400',
        'cyan' => 'bg-gradient-to-br from-cyan-50 via-cyan-100 to-white',
        
        'aqua' => 'bg-gradient-to-br from-cyan-400 via-blue-200 to-emerald-100',
        'peach' => 'bg-gradient-to-br from-amber-200 via-orange-100 to-pink-100',
        'midnight' => 'bg-gradient-to-br from-gray-900 via-slate-800 to-indigo-900',
        'sunrise' => 'bg-gradient-to-br from-pink-200 via-yellow-100 to-amber-200',
        'mint' => 'bg-gradient-to-br from-green-200 via-teal-100 to-cyan-100',
        'lavender' => 'bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100',
        'fire' => 'bg-gradient-to-br from-red-500 via-orange-400 to-yellow-300',
    ];
    
    $selectedGradient = $cardGradient ?? ($gradientVariant ? ($gradientVariants[$gradientVariant] ?? null) : null);
    
    // Dark variants that need white text
    $darkVariants = ['brand', 'slate', 'deep-rose', 'sunset'];
    $isDarkVariant = in_array($gradientVariant, $darkVariants);
@endphp

<a href="{{ $href }}"
   class="relative block p-3 sm:p-4 {{ $selectedGradient ?? $cardColor }} rounded-lg shadow-lg hover:shadow-sm hover:border-primary transition-all duration-300 ease-in-out {{ $isDarkVariant ? 'text-white' : '' }}">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs sm:text-sm {{ $isDarkVariant ? 'text-white/80' : 'text-gray-600' }}">{{ $title }}</p>
            <h3 class="text-lg sm:text-2xl font-bold {{ $isDarkVariant ? 'text-white' : 'text-[#1a2235]' }}">{{ $value }}</h3>
            @if ($note)
                <p class="text-xs {{ $isDarkVariant ? 'text-white/80' : 'text-gray-500' }} mt-1">
                    {{ $note }}
                </p>
            @endif
        </div>
        <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full {{ $isDarkVariant ? 'bg-white/10 text-white' : $bgColor . ' ' . $iconColor }}">
            <i class="bx {{ $icon }} text-xl sm:text-2xl"></i>
        </div>
    </div>
    @if($percentage)
        <div class="mt-4 flex items-center space-x-2 text-sm">
            @if($percentage_type === 'increase')
                <span class="flex items-center {{ $isDarkVariant ? 'text-white' : 'text-green-600' }} font-semibold">
                    <i class='bx bx-up-arrow-alt'></i>
                    <span>{{ $percentage }}</span>
                </span>
            @else
                <span class="flex items-center {{ $isDarkVariant ? 'text-white' : 'text-red-600' }} font-semibold">
                    <i class='bx bx-down-arrow-alt'></i>
                    <span>{{ $percentage }}</span>
                </span>
            @endif
            @if($period)
                <span class="{{ $isDarkVariant ? 'text-white/80' : 'text-gray-500' }}">{{ $period }}</span>
            @endif
        </div>
    @endif
</a>

{{--
Usage: 
Basic:
<x-overview.stat-card icon="bx-users" title="Total Users" value="1,234" href="/users" />

With percentage:
<x-overview.stat-card icon="bx-dollar" title="Revenue" value="$12,345" percentage="12%" period="vs last month" />

With note:
<x-overview.stat-card icon="bx-chart" title="Growth" value="23%" percentage="5%" percentage_type="decrease" note="From last week" />

With gradient variants:
<x-overview.stat-card icon="bx-users" title="Total Users" value="1,234" gradientVariant="emerald" />
<x-overview.stat-card icon="bx-dollar" title="Revenue" value="$12,345" gradientVariant="rose" />
<x-overview.stat-card icon="bx-chart" title="Growth" value="23%" gradientVariant="indigo" />
<x-overview.stat-card icon="bx-activity" title="Active Sessions" value="867" gradientVariant="sky" />
<x-overview.stat-card icon="bx-trending-up" title="Conversion" value="2.4%" gradientVariant="amber" />
<x-overview.stat-card icon="bx-clock" title="Response Time" value="320ms" gradientVariant="lime" />
<x-overview.stat-card icon="bx-bar-chart" title="MRR Growth" value="6.7%" gradientVariant="purple" />
<x-overview.stat-card icon="bx-check-circle" title="Tickets Resolved" value="324" gradientVariant="fuchsia" />

Brand gradient:
<x-overview.stat-card icon="bx-user-plus" title="New Signups" value="157" gradientVariant="brand" />

New gradient variants:
<x-overview.stat-card icon="bx-file-text" title="Open Invoices" value="24" gradientVariant="slate" />
<x-overview.stat-card icon="bx-bug" title="Error Rate" value="0.7%" gradientVariant="deep-rose" />
<x-overview.stat-card icon="bx-eye" title="Daily Visitors" value="4,560" gradientVariant="teal" />
<x-overview.stat-card icon="bx-database" title="Storage Used" value="68%" gradientVariant="glassmorphism" />
<x-overview.stat-card icon="bx-shopping-cart" title="Pending Orders" value="73" gradientVariant="sunset" />
<x-overview.stat-card icon="bx-rotate-ccw" title="Refund Rate" value="1.2%" gradientVariant="cyan" />

Custom gradients:
<x-overview.stat-card icon="bx-users" title="Total Users" value="1,234" cardGradient="bg-gradient-to-br from-blue-50 to-indigo-100" />
<x-overview.stat-card icon="bx-dollar" title="Revenue" value="$12,345" cardGradient="bg-gradient-to-br from-green-50 to-emerald-100" />
<x-overview.stat-card icon="bx-chart" title="Growth" value="23%" cardGradient="bg-gradient-to-br from-purple-50 to-violet-100" />

Used in:
- resources/views/dashboard.blade.php
- resources/views/finance/donations.blade.php
- resources/views/finance/membership_payments.blade.php
- resources/views/programs/index.blade.php
- resources/views/volunteers/index.blade.php
- resources/views/member/index.blade.php
--}} 