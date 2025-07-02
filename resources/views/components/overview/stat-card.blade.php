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
    'note' => null,
])

<a href="{{ $href }}"
   class="relative block p-3 sm:p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg hover:border-primary transition-all duration-300 ease-in-out">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs sm:text-sm text-gray-600">{{ $title }}</p>
            <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $value }}</h3>
            @if ($note)
                <p class="text-xs text-gray-500 mt-1">
                    {{ $note }}
                </p>
            @endif
        </div>
        <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full {{ $bgColor }} {{ $iconColor }}">
            <i class="bx {{ $icon }} text-xl sm:text-2xl"></i>
        </div>
    </div>
    @if($percentage)
        <div class="mt-4 flex items-center space-x-2 text-sm">
            @if($percentage_type === 'increase')
                <span class="flex items-center text-green-600 font-semibold">
                    <i class='bx bx-up-arrow-alt'></i>
                    <span>{{ $percentage }}</span>
                </span>
            @else
                <span class="flex items-center text-red-600 font-semibold">
                    <i class='bx bx-down-arrow-alt'></i>
                    <span>{{ $percentage }}</span>
                </span>
            @endif
            @if($period)
                <span class="text-gray-500">{{ $period }}</span>
            @endif
        </div>
    @endif
</a>

{{--
Usage: <x-overview.stat-card icon="bx-users" title="Total Users" value="1,234" href="/users" />
       <x-overview.stat-card icon="bx-dollar" title="Revenue" value="$12,345" percentage="12%" period="vs last month" />
       <x-overview.stat-card icon="bx-chart" title="Growth" value="23%" percentage="5%" percentage_type="decrease" note="From last week" />

Used in:
- resources/views/dashboard.blade.php
- resources/views/finance/donations.blade.php
- resources/views/finance/membership_payments.blade.php
- resources/views/programs/index.blade.php
- resources/views/volunteers/index.blade.php
- resources/views/member/index.blade.php
--}} 