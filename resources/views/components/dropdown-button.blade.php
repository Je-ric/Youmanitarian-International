@props([
    'id' => null,
    'class' => '',
    'buttonClass' => 'bg-gray-100 hover:bg-gray-200 border-2 border-gray-300 hover:border-[#FFB51B] text-gray-700 px-3 py-2 rounded-lg text-sm transition-all duration-200',
    'dropdownClass' => 'absolute right-0 mt-2 w-48 bg-white rounded-lg border-2 border-gray-200 z-10',
    'align' => 'right', // left, right, center
])

@php
    $alignmentClasses = [
        'left' => 'left-0',
        'right' => 'right-0',
        'center' => 'left-1/2 transform -translate-x-1/2',
    ];

    $alignmentClass = $alignmentClasses[$align] ?? $alignmentClasses['right'];
    $uniqueId = $id ?? 'dropdown-' . uniqid();
@endphp

<div class="relative" x-data="{ open: false }" {{ $attributes }}>
    <button @click="open = !open" class="{{ $buttonClass }} {{ $class }}">
        <i class='bx bx-dots-vertical'></i>
    </button>

    <div x-show="open"
         @click.away="open = false"
         class="{{ $dropdownClass }} {{ $alignmentClass }}"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95">
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>

{{--
Usage:
<x-dropdown-button>
    <button onclick="action1()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
        <i class='bx bx-check mr-2 text-green-500'></i>Action 1
    </button>
    <button onclick="action2()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
        <i class='bx bx-edit mr-2 text-blue-500'></i>Action 2
    </button>
    <hr class="my-1">
    <a href="/some-url" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
        <i class='bx bx-link mr-2 text-purple-500'></i>Link Action
    </a>
</x-dropdown-button>

With custom styling:
<x-dropdown-button
    :buttonClass="'bg-blue-100 hover:bg-blue-200 text-blue-700'"
    :dropdownClass="'w-56 bg-blue-50 border-blue-200'"
    align="left">
    <!-- dropdown content -->
</x-dropdown-button>

--}}
