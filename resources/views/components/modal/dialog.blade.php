@props([
    'id',
    'maxWidth' => 'max-w-2xl',
    'width' => 'w-11/12',
    'maxHeight' => 'max-h-[90vh]',
    'class' => '',
])

<dialog id="{{ $id }}" class="modal" {{ $attributes }}>
    <div class="modal-box {{ $width }} {{ $maxWidth }} {{ $maxHeight }} p-0 overflow-hidden rounded-xl bg-white border border-slate-200 shadow-xl flex flex-col {{ $class }}">
        {{ $slot }}
    </div>
</dialog>

{{--
Usage: <x-modal.dialog id="myModal" maxWidth="max-w-lg">
            <x-modal.header>Modal Title</x-modal.header>
            <div class="p-6">Modal content here</div>
            <x-modal.footer>
                <x-modal.close-button :modalId="'myModal'" text="Cancel" />
                <button type="submit">Save</button>
            </x-modal.footer>
        </x-modal.dialog>

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