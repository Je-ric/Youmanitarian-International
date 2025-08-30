<x-modal.dialog id="manualAttendanceModal_{{ $selectedVolunteer->id }}" maxWidth="max-w-2xl" width="w-full"
    maxHeight="max-h-[90vh]">
@php
    $programStart = \Carbon\Carbon::parse($program->start_time)->format('H:i');
    $programEnd = \Carbon\Carbon::parse($program->end_time)->format('H:i');
@endphp
    <x-modal.header>
        <div>
            <h3 class="text-xl font-medium text-gray-900">
                @if($attendance && $attendance->clock_in && !$attendance->clock_out)
                    Manual Clock Out
                    <p class="text-xs text-gray-500 mt-1">Enter clock out time for a volunteer who forgots to clock out.</p>
                @else
                    Manual Attendance Entry
                    <p class="text-xs text-gray-500 mt-1">Enter attendance details for a volunteer who didn't clock in/out.
                    </p>
                @endif
            </h3>
        </div>
    </x-modal.header>

    <form method="POST" action="{{ route('attendance.manualEntry', $program->id) }}"
        class="flex flex-col flex-1 min-h-0">
        @csrf

        <x-modal.body :padded="false">
            <input type="hidden" name="volunteer_id" value="{{ $selectedVolunteer->id }}">
            <input type="hidden" name="date" value="{{ \Carbon\Carbon::parse($program->date)->format('Y-m-d') }}">

            <div class="p-6 space-y-6">
                <div class="space-y-1.5">
                    <x-form.label variant="volunteer-name">Volunteer Name:</x-form.label>
                    <div class="flex items-center space-x-2 px-3 py-2 bg-gray-50 rounded-md border border-gray-200">
                        <span class="text-sm text-gray-900">{{ $selectedVolunteer->user->name ?? 'No Name' }}</span>
                    </div>
                </div>

                @php
                    $clockIn = $attendance?->clock_in ? \Carbon\Carbon::parse($attendance->clock_in) : null;
                    $clockOut = $attendance?->clock_out ? \Carbon\Carbon::parse($attendance->clock_out) : null;
                @endphp


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <x-form.label for="clock_in" variant="time-in">Time In</x-form.label>
                        <div class="relative flex items-center">
                            @if($clockIn)
                                <input type="text" readonly
                                    class="w-full pl-10 pr-3 py-2 rounded-md border border-gray-200 bg-gray-100 text-gray-700 focus:outline-none"
                                    value="{{ $clockIn->format('h:i a') }}">
                                <input type="hidden" name="clock_in" value="{{ $clockIn->format('H:i') }}">
                            @else
                                <x-form.time-picker id="clock_in" name="clock_in"
                                                    :value="old('clock_in')"
                                                    :min="$programStart"
                                                    :max="$programEnd"
                                                    required="true" />
                            @endif
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <x-form.label for="clock_out" variant="time-out">Time Out</x-form.label>
                        <div class="relative flex items-center">
                            @if($clockOut)
                                <input type="text" readonly
                                    class="w-full pl-10 pr-3 py-2 rounded-md border border-gray-200 bg-gray-100 text-gray-700 focus:outline-none"
                                    value="{{ $clockOut->format('h:i a') }}">
                            @else
                                <x-form.time-picker id="clock_out" name="clock_out"
                                                    :value="old('clock_out')"
                                                    :min="$programStart"
                                                    :max="$programEnd"
                                                    required="true" />
                            @endif
                        </div>
                    </div>
                </div>


                <div class="space-y-1.5">
                    <x-form.textarea name="notes" :value="$attendance?->notes"
                        label="Reason for Manual Entry (optional):"
                        placeholder="Explain why manual entry is needed..."
                        rows="3" />
                </div>
            </div>
        </x-modal.body>

        <x-modal.footer>
            <x-modal.close-button :modalId="'manualAttendanceModal_' . $selectedVolunteer->id" text="Cancel"
                variant="cancel" />
            <x-button type="submit" variant="save-entry">
                <i class='bx bx-time-five'></i>
                Save Attendance
            </x-button>
        </x-modal.footer>
    </form>
</x-modal.dialog>
