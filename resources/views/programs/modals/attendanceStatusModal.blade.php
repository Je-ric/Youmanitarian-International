<x-modal.dialog id="attendanceStatusModal">
    <x-modal.header>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Attendance Approval Status</h2>
    </x-modal.header>

    <x-modal.body>
        <div class="space-y-3">
            <div class="flex flex-row">
                <x-form.label class="text-gray-600 font-medium mb-1">
                    <i class="bx bx-badge-check text-indigo-600 mr-1"></i>
                    Approval Status:
                </x-form.label>
                    <x-feedback-status.status-indicator 
                        :status="$attendance->approval_status" 
                        :label="ucfirst($attendance->approval_status)" 
                    />
            </div>
            <div class="border-t border-slate-100 pt-2">
                <x-form.label class="text-gray-600 font-medium mb-1">
                    <i class="bx bx-user-check text-indigo-600 mr-1"></i>
                    {{ ucfirst($attendance->approval_status) }} by
                </x-form.label>
                <x-form.readonly class="text-sm text-gray-700 font-semibold">
                    {{ $attendance->approver->name ?? 'Not yet approved' }}
                </x-form.readonly>
            </div>
            @if($attendance->notes)
                <div class="border-t border-slate-100 pt-2">
                    <x-form.label class="text-gray-600 font-medium mb-1">
                        <i class="bx bx-message-dots text-indigo-600 mr-1"></i>
                        Notes / Reason
                    </x-form.label>
                    <x-form.readonly class="text-sm text-gray-700">
                        {{ $attendance->notes }}
                    </x-form.readonly>
                </div>
            @endif
        </div>
    </x-modal.body>

    <x-modal.footer align="end">
        <x-modal.close-button :modalId="'attendanceStatusModal'" text="Close" />
    </x-modal.footer>
</x-modal.dialog>