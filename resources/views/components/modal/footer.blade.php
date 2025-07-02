@props([
    'align' => 'end', // start, center, end
    'class' => '',
])

@php
    $alignmentClasses = [
        'start' => 'justify-start',
        'center' => 'justify-center',
        'end' => 'justify-end',
    ];
    
    $baseClasses = 'border-t border-slate-200 px-6 py-4 bg-slate-50 flex gap-3 flex-shrink-0';
    $alignmentClass = $alignmentClasses[$align] ?? $alignmentClasses['end'];
@endphp

<footer {{ $attributes->merge(['class' => "{$baseClasses} {$alignmentClass} {$class}"]) }}>
    {{ $slot }}
</footer>

{{--
Usage: <x-modal.footer align="end">
            <x-modal.close-button :modalId="'myModal'" text="Cancel" />
            <button type="submit" class="btn btn-primary">Save</button>
        </x-modal.footer>
       <x-modal.footer align="center">
            <button type="button">OK</button>
        </x-modal.footer>

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