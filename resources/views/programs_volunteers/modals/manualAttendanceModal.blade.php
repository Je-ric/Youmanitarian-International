<dialog id="manualAttendanceModal_{{ $selectedVolunteer->id }}" class="modal">
    <div class="modal-box w-full max-w-2xl p-0 overflow-hidden rounded-lg bg-white border border-gray-100 shadow-lg transition-all max-h-[90vh] flex flex-col mx-4 sm:mx-auto">
        
        <x-modal.header>
            <div>
                <h3 class="text-xl font-medium text-gray-900">
                    @if($attendance && $attendance->clock_in && !$attendance->clock_out)
                        Manual Clock Out
                        <p class="text-xs text-gray-500 mt-1">Enter clock out time for a volunteer who forgots to clock out.</p>
                    @else
                        Manual Attendance Entry
                        <p class="text-xs text-gray-500 mt-1">Enter attendance details for a volunteer who didn't clock in/out.</p>
                    @endif
                </h3>
            </div>
        </x-modal.header>

        <form method="POST" action="{{ route('attendance.manualEntry', $program->id) }}" class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" name="volunteer_id" value="{{ $selectedVolunteer->id }}">
            <input type="hidden" name="date" value="{{ \Carbon\Carbon::parse($program->date)->format('Y-m-d') }}">

            <div class="p-6 space-y-6">
                <div class="space-y-1.5">
                    <x-label><i class='bx bx-user text-blue-500'></i>Volunteer Name:</x-label>
                    <div class="flex items-center space-x-2 px-3 py-2 bg-gray-50 rounded-md border border-gray-200">
                        <span class="text-sm text-gray-900">{{ $selectedVolunteer->user->name ?? 'No Name' }}</span>
                    </div>
                </div>

                @php
                    $clockIn = $attendance?->clock_in ? \Carbon\Carbon::parse($attendance->clock_in) : null;
                    $clockOut = $attendance?->clock_out ? \Carbon\Carbon::parse($attendance->clock_out) : null;
                @endphp

                <!-- Time Inputs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <x-label><i class='bx bx-time-five mr-1 text-green-600'></i>Time In</x-label>
                        <div class="relative flex items-center">
                            {{-- <i class='bx bx-time-five absolute left-3 text-gray-400'></i> --}}
                            @if($clockIn)
                                <input type="text" readonly 
                                    class="w-full pl-10 pr-3 py-2 rounded-md border border-gray-200 bg-gray-100 text-gray-700 focus:outline-none" 
                                    value="{{ $clockIn->format('h:i a') }}">
                                <input type="hidden" name="clock_in" value="{{ $clockIn->format('H:i') }}">
                            @else
                                <x-time-picker
                                    id="clock_in"
                                    name="clock_in"
                                    :value="old('clock_in')"
                                    required="true"
                                />
                            @endif
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <x-label><i class='bx bx-time-five mr-1 text-red-600'></i>Time Out</x-label>
                        <div class="relative flex items-center">
                            {{-- <i class='bx bx-time-five absolute left-3 text-gray-400'></i> --}}
                            @if($clockOut)
                                <input type="text" readonly class="w-full pl-10 pr-3 py-2 rounded-md border border-gray-200 bg-gray-100 text-gray-700 focus:outline-none" value="{{ $clockOut->format('H:i') }}">
                            @else
                                <x-time-picker
                                    id="clock_out"
                                    name="clock_out"
                                    :value="old('clock_out')"
                                    required="true"
                                />
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reason -->
                <div class="space-y-1.5">
                    <x-textarea
                        name="notes"
                        :value="$attendance?->notes"
                        label="Reason for Manual Entry (optional):"
                        placeholder="Explain why manual entry is needed..."
                        rows="3"
                    />
                </div>
            </div>

            <x-modal.footer>
                <x-modal.close-button :modalId="'manualAttendanceModal_' . $selectedVolunteer->id" text="Cancel" variant="cancel" />
                <x-button type="submit" variant="save-entry">
                    <i class='bx bx-time-five'></i>
                    Save Attendance
                </x-button>
            </x-modal.footer>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop bg-black/40 backdrop-blur-sm fixed inset-0 z-[-1]"></form>
</dialog>