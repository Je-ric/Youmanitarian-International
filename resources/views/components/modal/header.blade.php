@props([
    'class' => '',
])

@php
    $baseClasses = 'px-6 py-4 border-b border-slate-200 bg-slate-50 flex-shrink-0';
    $finalClasses = $class ? "{$baseClasses} {$class}" : $baseClasses;
@endphp

<header {{ $attributes->merge(['class' => $finalClasses]) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            {{ $slot }}
        </div>
        <x-modal.x-button />
    </div>
</header>

{{--
Usage: <x-modal.header>Modal Title</x-modal.header>
       <x-modal.header class="bg-blue-50">
            <h3 class="text-lg font-semibold">Edit User</h3>
        </x-modal.header>

Used in:
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/programs/modals/proofModal.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
- resources/views/finance/modals/paymentReminderModal.blade.php
- resources/views/volunteers/modals/invitationModal.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php
- resources/views/roles/partials/assign_rolesModal.blade.php
--}} 