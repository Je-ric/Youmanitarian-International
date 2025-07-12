@props(['status', 'label' => null, 'icon' => null])

@php
$variant = [
    // General statuses
    'success' => 'bg-green-100 text-green-600',
    'neutral' => 'bg-indigo-50 text-gray-500',
    'info'    => 'bg-blue-50 text-blue-500',
    'warning' => 'bg-yellow-50 text-yellow-500',
    'danger'  => 'bg-red-50 text-red-500',
    // Program/Volunteer statuses
    'completed' => 'bg-green-100 text-green-700',
    'in_progress' => 'bg-blue-50 text-blue-700',
    'pending' => 'bg-yellow-50 text-yellow-700',
    'rejected' => 'bg-red-50 text-red-600',
    'approved' => 'bg-green-50 text-green-600',
    'role' => 'bg-[#1a2235] text-white',
    // Content Types
    'news' => 'bg-blue-100 text-blue-700',
    'program' => 'bg-green-100 text-green-700',
    'announcement' => 'bg-yellow-100 text-yellow-700',
    'event' => 'bg-purple-100 text-purple-700',
    'article' => 'bg-indigo-100 text-indigo-700',
    'blog' => 'bg-pink-100 text-pink-700',
    // Content Statuses
    'draft' => 'bg-gray-100 text-gray-700',
    'published' => 'bg-green-100 text-green-700',
    'archived' => 'bg-red-100 text-red-700',
    // Approval Statuses
    'needs_revision' => 'bg-orange-100 text-orange-700',
    // Role-based 
    'volunteer' => 'bg-blue-600 text-white',
    'admin' => 'bg-purple-700 text-white',
    'program-coordinator' => 'bg-green-700 text-white',
    'financial-coordinator' => 'bg-yellow-600 text-white',
    'content-manager' => 'bg-indigo-700 text-white',
    'member' => 'bg-orange-600 text-white',
    // Account Statuses
    'verified' => 'bg-emerald-100 text-emerald-800',
    'not_verified' => 'bg-red-100 text-red-800',
    'connected' => 'bg-blue-100 text-blue-800',
    'not_connected' => 'bg-gray-100 text-gray-600',
];

$icons = [
    // General statuses
    'success' => 'bx bx-check-circle',
    'neutral' => 'bx bx-minus-circle',
    'info' => 'bx bx-info-circle',
    'warning' => 'bx bx-time',
    'danger' => 'bx bx-x-circle',
    // Program/Volunteer statuses
    'completed' => 'bx bx-check-circle',
    'in_progress' => 'bx bx-time',
    'pending' => 'bx bx-hourglass',
    'rejected' => 'bx bx-x',
    'approved' => 'bx bx-check-double',
    'role' => 'bx bx-check-circle text-xs',
    // Content Types
    'news' => 'bx bx-news',
    'program' => 'bx bx-calendar-event',
    'announcement' => 'bx bx-megaphone',
    'event' => 'bx bx-calendar-star',
    'article' => 'bx bx-file-text',
    'blog' => 'bx bx-pencil',
    // Content Statuses
    'draft' => 'bx bx-edit',
    'published' => 'bx bx-check-circle',
    'archived' => 'bx bx-archive',
    // Approval Statuses
    'needs_revision' => 'bx bx-refresh',
    // Role-based icons
    'volunteer' => 'bx bx-user',
    'admin' => 'bx bx-crown',
    'program-coordinator' => 'bx bx-calendar-event',
    'financial-coordinator' => 'bx bx-wallet',
    'content-manager' => 'bx bx-edit-alt',
    'member' => 'bx bx-group',
    // Account Status icons
    'verified' => 'bx bx-check-circle',
    'not_verified' => 'bx bx-x-circle',
    'connected' => 'bx bxl-google',
    'not_connected' => 'bx bx-x',
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
Usage: <x-feedback-status.status-indicator status="success" />
       <x-feedback-status.status-indicator status="pending" label="Awaiting Approval" />
       <x-feedback-status.status-indicator status="published" icon="bx-check-circle" />

Supported Statuses:
- General: success, neutral, info, warning, danger
- Program/Volunteer: completed, in_progress, pending, rejected, approved, role
- Content Types: news, program, announcement, event, article, blog
- Content Status: draft, published, archived
- Approval Status: needs_revision

Used in:
- resources/views/roles/partials/assign_rolesModal.blade.php
- resources/views/programs_volunteers/partials/programTasks.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/programs/attendance.blade.php
- resources/views/dashboard.blade.php
- resources/views/content/index.blade.php
- resources/views/content_requests/requests-index.blade.php
--}}
