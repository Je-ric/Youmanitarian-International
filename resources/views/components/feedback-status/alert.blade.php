@props([
    'type' => 'info', // success, error, info, warning
    'icon' => 'bx bx-info-circle',
    'message' => '',
    'variant' => 'default', // default, attendance, flexible, dark
    'bgColor' => '', // custom background color class for flexible variant
    'textColor' => '', // custom text color class for flexible variant
    'borderColor' => '', // custom border color class for flexible variant
    'iconColor' => '', // custom icon color class for flexible variant
])

@php
    $typeClasses = [
        'success' => 'text-green-600 font-medium bg-green-50 border-green-200',
        'error' => 'text-red-600 font-medium bg-red-50 border-red-200',
        'info' => 'text-blue-700 font-medium bg-blue-50 border-blue-200',
        'warning' => 'text-yellow-600 font-medium bg-yellow-50 border-yellow-200',
        'neutral' => 'text-gray-500 font-medium bg-gray-100 border-gray-200',
    ];
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
@endphp

@if($variant === 'attendance')
    <div class="bg-{{ $type === 'error' ? 'red' : ($type === 'success' ? 'green' : ($type === 'warning' ? 'yellow' : 'blue')) }}-50 border border-{{ $type === 'error' ? 'red' : ($type === 'success' ? 'green' : ($type === 'warning' ? 'yellow' : 'blue')) }}-200 rounded-lg p-4 mb-4">
        <div class="flex items-start gap-3">
            <i class="{{ $icon }} text-{{ $type === 'error' ? 'red' : ($type === 'success' ? 'green' : ($type === 'warning' ? 'yellow' : 'blue') ) }}-500 mt-0.5"></i>
            <div class="text-sm text-{{ $type === 'error' ? 'red' : ($type === 'success' ? 'green' : ($type === 'warning' ? 'yellow' : 'blue') ) }}-700">
                {!! $message !!}
            </div>
        </div>
    </div>
@elseif($variant === 'flexible')
    <div class="{{ $bgColor ?: 'bg-gray-50' }} border {{ $borderColor ?: 'border-gray-200' }} rounded-lg p-4 mb-4">
        <div class="flex items-start gap-3">
            <i class="{{ $icon }} {{ $iconColor ?: 'text-gray-500' }} mt-0.5"></i>
            <div class="text-sm {{ $textColor ?: 'text-gray-700' }}">
                {!! $message !!}
            </div>
        </div>
    </div>
@elseif($variant === 'dark')
    @php
        $darkBg = [
            'success' => 'bg-green-900 border-green-400',
            'error' => 'bg-red-900 border-red-400',
            'info' => 'bg-slate-800 border-blue-400',
            'warning' => 'bg-yellow-900 border-yellow-400',
            'neutral' => 'bg-gray-800 border-gray-500',
        ];
        $darkClasses = $darkBg[$type] ?? $darkBg['info'];
    @endphp
    <div class="{{ $darkClasses }} border rounded-lg p-4 mb-4">
        <div class="flex items-start gap-3">
            <i class="{{ $icon }} text-white mt-0.5"></i>
            <div class="text-sm text-white/90">
                {!! $message !!}
            </div>
        </div>
    </div>
@else
    <div class="text-sm flex items-center gap-2 justify-center py-3 px-4 border rounded-lg {{ $classes }}">
        <i class="{{ $icon }}"></i>
        {!! $message !!}
    </div>
@endif

{{--
Usage: 
<x-feedback-status.alert type="success" message="Operation completed successfully!" />
<x-feedback-status.alert type="error" message="Something went wrong!" />
<x-feedback-status.alert type="warning" message="Please review your input." variant="attendance" />

Flexible variant with custom colors:
<x-feedback-status.alert 
    variant="flexible" 
    message="Custom colored alert" 
    bgColor="bg-purple-50" 
    textColor="text-purple-700" 
    borderColor="border-purple-200" 
    iconColor="text-purple-500" 
/>

Dark variant for dark backgrounds:
<x-feedback-status.alert 
    variant="dark" 
    message="This is a dark alert!" 
    icon="bx bx-info-circle" 
/>

Used in:
- resources/views/roles/partials/assign_rolesModal.blade.php
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/programs/modals/program-modal.blade.php
- resources/views/dashboard.blade.php
--}} 