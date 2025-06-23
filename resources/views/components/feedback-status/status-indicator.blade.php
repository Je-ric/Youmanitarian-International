@props(['status', 'label' => null, 'icon' => null])

@php
$variant = [
    'success' => 'bg-green-100 text-green-600',
    'neutral' => 'bg-indigo-50 text-gray-500',
    'info'    => 'bg-blue-50 text-blue-500',
    'warning' => 'bg-yellow-50 text-yellow-500',
    'danger'  => 'bg-red-50 text-red-500',
    'completed' => 'bg-green-100 text-green-700',
    'in_progress' => 'bg-blue-50 text-blue-700',
    'pending' => 'bg-yellow-50 text-yellow-700',
    'rejected' => 'bg-red-50 text-red-600',
    'approved' => 'bg-green-50 text-green-600',
    'role' => 'bg-[#1a2235] text-white',
];
$icons = [
    'success' => 'bx bx-check-circle',
    'neutral' => 'bx bx-minus-circle',
    'info' => 'bx bx-info-circle',
    'warning' => 'bx bx-time',
    'danger' => 'bx bx-x-circle',
    'completed' => 'bx bx-check-circle',
    'in_progress' => 'bx bx-time',
    'pending' => 'bx bx-hourglass',
    'rejected' => 'bx bx-x',
    'approved' => 'bx bx-check-double',
    'role' => 'bx bx-check-circle text-xs',
];
$style = $variant[$status] ?? 'bg-gray-300 text-black';
$iconClass = $icon ?? ($icons[$status] ?? '');
@endphp

<span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full font-medium {{ $style }}">
    @if($iconClass)
        <i class="{{ $iconClass }}"></i>
    @endif
    {{ $label ?? ucfirst(str_replace('_', ' ', $status)) }}
</span>

{{--
Used in:
- resources/views/roles/partials/assign_rolesModal.blade.php
- resources/views/programs_volunteers/partials/programTasks.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/programs/attendance.blade.php
- resources/views/dashboard.blade.php
- resources/views/content/index.blade.php
- resources/views/content_requests/requests-index.blade.php
--}}
