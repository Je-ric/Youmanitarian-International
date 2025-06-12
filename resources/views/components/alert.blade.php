@props([
    'type' => 'info', // success, error, info, warning
    'icon' => 'bx bx-info-circle',
    'message' => '',
])

@php
    $typeClasses = [
        'success' => 'text-green-600 font-medium bg-green-50 border-green-200',
        'error' => 'text-red-600 font-medium bg-red-50 border-red-200',
        'info' => 'text-gray-500 bg-gray-100 border-gray-200',
        'warning' => 'text-yellow-600 font-medium bg-yellow-50 border-yellow-200',
    ];
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

<div class="text-sm flex items-center gap-2 justify-center py-3 px-4 border rounded-lg {{ $classes }}">
    <i class="{{ $icon }}"></i>
    {{ $message }}
</div> 