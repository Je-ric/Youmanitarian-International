@props([
    'icon' => null, 
    'title',
    'desc' => null, 
    'class' => '',
])

<div class="w-full bg-[#f4f5f7] flex flex-col md:flex-row justify-between items-start md:items-center gap-4 px-4 sm:px-6 py-4 border-y border-gray-200 {{ $class }}">

    <div class="flex items-start md:items-center gap-3 sm:gap-4">
        @if($icon)
            <span class="flex-shrink-0 inline-flex items-center justify-center shadow-lg rounded-lg bg-[#313849] text-[#ffb51b] w-10 h-10 sm:w-12 sm:h-12 text-xl sm:text-2xl">
                <i class="bx {{ $icon }}"></i>
            </span>
        @endif
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-[#1a2235]">{{ $title }}</h1>
            @if($desc)
                <p class="text-sm text-gray-500 mt-1">{{ $desc }}</p>
            @endif
        </div>
    </div>
    
    <div class="flex-shrink-0 w-full md:w-auto flex flex-row md:justify-end gap-2 mt-2 md:mt-0">
        {{ $slot }}
    </div>
</div>

{{--
Usage: <x-page-header icon="bx-calendar-event" title="Programs" desc="View and manage all programs.">
            <x-button href="/programs/create" variant="primary">Create Program</x-button>
        </x-page-header>
       <x-page-header title="Volunteers">
            <x-button href="/volunteers/invite" variant="secondary">Invite Volunteers</x-button>
        </x-page-header>

Used in:
- resources/views/volunteers/index.blade.php
- resources/views/programs_volunteers/program-volunteers.blade.php
- resources/views/roles/index.blade.php
- resources/views/programs/index.blade.php
- resources/views/programs/attendance.blade.php
- resources/views/member/index.blade.php
- resources/views/finance/donations.blade.php
- resources/views/finance/membership_payments.blade.php
- resources/views/components/showcase.blade.php
- resources/views/content/content_create.blade.php
--}} 