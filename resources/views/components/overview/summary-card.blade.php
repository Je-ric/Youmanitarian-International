@props([
    'title',
    'maxHeight' => 'none',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg border border-gray-200 p-4 sm:p-6 shadow-sm flex flex-col']) }}>
    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">{{ $title }}</h3>
    <div 
        class="flex-grow space-y-4"
        @if($maxHeight !== 'none')
            style="max-height: {{ $maxHeight }};"
        @endif
    >
        {{ $slot }}
    </div>
</div>

{{--
Usage: <x-overview.summary-card title="Recent Activities">
            <x-overview.summary-list-item title="New user registered" subtitle="2 minutes ago" />
            <x-overview.summary-list-item title="Payment received" subtitle="1 hour ago" />
        </x-overview.summary-card>
       <x-overview.summary-card title="User List" maxHeight="300px">
            <div class="overflow-y-auto">Content here</div>
        </x-overview.summary-card>

Used in:
- resources/views/dashboard.blade.php
- resources/views/member/index.blade.php
- resources/views/volunteers/index.blade.php
- resources/views/programs_volunteers/program-volunteers.blade.php
--}} 