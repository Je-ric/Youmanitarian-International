<button type="button" onclick="this.closest('dialog')?.close()"
    class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-gray-500 hover:text-red-500 transition-all duration-200 focus:outline-none z-50">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
              d="M10 8.586l4.95-4.95a1 1 0 011.414 1.414L11.414 10l4.95 4.95a1 1 0 01-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 01-1.414-1.414L8.586 10l-4.95-4.95a1 1 0 011.414-1.414L10 8.586z"
              clip-rule="evenodd" />
    </svg>
</button>

{{--
Usage: <x-modal.x-button />
       Note: This component is automatically included in x-modal.header

Used in:
- Automatically included in x-modal.header component
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/programs/modals/proofModal.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
- resources/views/finance/modals/paymentReminderModal.blade.php
- resources/views/volunteers/modals/invitationModal.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php
- resources/views/roles/partials/assign_rolesModal.blade.php
--}}
