@props([
    'type' => 'info',
    'message'
])

@php
    $toastStyles = [
        'success' => [
            'container' => 'bg-green-100 text-green-800 border-green-400',
            'icon_bg' => 'bg-green-500',
            'icon' => 'bx-check',
            'title' => 'Success!'
        ],
        'error' => [
            'container' => 'bg-red-100 text-red-800 border-red-400',
            'icon_bg' => 'bg-red-500',
            'icon' => 'bx-x',
            'title' => 'Reminder!'
        ],
        'info' => [
            'container' => 'bg-blue-100 text-blue-800 border-blue-400',
            'icon_bg' => 'bg-blue-500',
            'icon' => 'bx-info',
            'title' => 'Information'
        ],
        'warning' => [
            'container' => 'bg-yellow-100 text-yellow-800 border-yellow-400',
            'icon_bg' => 'bg-yellow-500',
            'icon' => 'bx-error',
            'title' => 'Attention!'
        ]
    ];

    $toast = $toastStyles[$type] ?? [
        'container' => 'bg-gray-100 text-gray-800 border-gray-400',
        'icon_bg' => 'bg-gray-500',
        'icon' => 'bx-info-circle',
        'title' => 'Notification'
    ];
@endphp

<div x-data="{ show: false }" x-init="show = true; setTimeout(() => show = false, 3500)" 
        x-show="show" 
        x-transition:enter="transition ease-out duration-300 transform opacity-0 translate-y-2" 
        x-transition:enter-start="opacity-0 translate-x-5"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform opacity-100 translate-y-0"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-5"
        class="fixed top-5 right-5 z-50 p-4 rounded-lg shadow-xl backdrop-blur-sm border flex items-center space-x-3 max-w-xs sm:max-w-sm md:max-w-md {{ $toast['container'] }}">
    
    <span class="w-10 h-10 flex items-center justify-center rounded-full {{ $toast['icon_bg'] }}">
        <i class="bx {{ $toast['icon'] }} text-white text-xl"></i> 
    </span>

    <div class="flex flex-col">
        <h3 class="font-semibold text-lg">{{ $toast['title'] }}</h3>
        <p class="text-sm">{{ $message }}</p>
    </div>

    <button @click="show = false" class="ml-auto text-xl font-bold text-gray-600 hover:text-gray-800" aria-label="Close notification">
        &times;
    </button>
</div>

{{--
Usage: <x-feedback-status.toast type="success" message="Your action was completed successfully!" />
       <x-feedback-status.toast type="error" message="An error occurred. Please try again." />
       <x-feedback-status.toast type="warning" message="Please review your input before proceeding." />

Note: Toast automatically disappears after 3.5 seconds and can be manually closed

Used in:
- resources/views/layouts/sidebar_final.blade.php
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/auth/login.blade.php
--}}
