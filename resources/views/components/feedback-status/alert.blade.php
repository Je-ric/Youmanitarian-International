@props([
    'type' => 'info', // success, error, info, warning
    'icon' => 'bx bx-info-circle',
    'message' => '',
    'variant' => 'default', // default or attendance
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
@else
    <div class="text-sm flex items-center gap-2 justify-center py-3 px-4 border rounded-lg {{ $classes }}">
        <i class="{{ $icon }}"></i>
        {!! $message !!}
    </div>
@endif

{{--
Usage: <x-feedback-status.alert type="success" message="Operation completed successfully!" />
       <x-feedback-status.alert type="error" message="Something went wrong!" />
       <x-feedback-status.alert type="warning" message="Please review your input." variant="attendance" />

Used in:
- resources/views/roles/partials/assign_rolesModal.blade.php
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/programs/modals/program-modal.blade.php
- resources/views/dashboard.blade.php
--}} 