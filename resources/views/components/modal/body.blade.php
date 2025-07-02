@props([
    'class' => '',
    'padded' => true,
])

@php
    $paddingClass = $padded ? 'p-6' : '';
@endphp

<div {{ $attributes->merge([
    'class' => "flex-1 min-h-0 overflow-y-auto space-y-6 max-h-[60vh] sm:max-h-[70vh] custom-scrollbar-gold $paddingClass $class"
]) }}>
    {{ $slot }}
</div>

{{--
Usage:
<x-modal.body>
    ...content...
</x-modal.body>
<x-modal.body :padded="false">
    ...content without padding...
</x-modal.body>

Used in:
- resources/views/finance/modals/addPaymentModal.blade.php
- resources/views/finance/modals/addDonationModal.blade.php
- resources/views/finance/modals/paymentReminderModal.blade.php
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/programs/modals/proofModal.blade.php
- resources/views/programs/modals/program-modal.blade.php
- resources/views/programs/modals/deleteProgramModal.blade.php
- resources/views/volunteers/modals/invitationModal.blade.php
- resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/roles/partials/assign_rolesModal.blade.php
--}}