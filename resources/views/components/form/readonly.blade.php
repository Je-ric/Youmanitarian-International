@props(['class' => ''])

{{--
Readonly form field component for displaying non-editable data.

Usage: <x-form.readonly>Display text here</x-form.readonly>
       <x-form.readonly class="text-sm text-gray-700 font-semibold">Formatted text</x-form.readonly>

Used in:
- resources/views/programs/modals/attendanceStatusModal.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
- resources/views/finance/modals/addDonationModal.blade.php
--}}

<div class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 text-gray-500 italic cursor-not-allowed select-none {{ $class }}">
    {{ $slot }}
</div> 