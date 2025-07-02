@props([
    'modalId' => null,
    'text' => 'Close',
    'class' => '',
    'variant' => 'close', // 'close' or 'cancel'
])

@php
    $baseClasses = 'px-6 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 hover:text-slate-900 active:bg-slate-100 active:border-slate-400 transition-all duration-200';
    $finalClasses = $class ? "{$baseClasses} {$class}" : $baseClasses;
@endphp

@if($variant === 'cancel')
    <button 
        type="button"
        onclick="document.getElementById('{{ $modalId }}').close()"
        {{ $attributes->merge(['class' => $finalClasses]) }}
    >
        {{ $text }}
    </button>
@else
    <button 
        onclick="document.getElementById('{{ $modalId }}').close()"
        {{ $attributes->merge(['class' => $finalClasses]) }}
    >
        {{ $text }}
    </button>
@endif

{{--
Usage: <x-modal.close-button :modalId="'myModal'" text="Cancel" variant="cancel" />
       <x-modal.close-button :modalId="'myModal'" text="Close" class="bg-red-500 text-white" />

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