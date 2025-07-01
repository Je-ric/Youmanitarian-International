@props([
    'for' => null,
    'class' => '',
])

<label
    @if($for) for="{{ $for }}" @endif
    class="flex items-center text-sm font-medium sm:gap-2 text-[#1a2235] mb-2 {{ $class }}"
>
    {{ $slot }} {{-- for icon --}}
</label>

{{--
Used in:
- resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php
- resources/views/programs_volunteers/partials/programDetails.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/programs/create.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
--}} 