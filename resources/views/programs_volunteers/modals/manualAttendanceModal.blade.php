<dialog id="manualAttendanceModal_{{ $selectedVolunteer->id }}" class="modal">
    <div class="modal-box w-full max-w-2xl p-0 overflow-hidden rounded-lg bg-white border border-gray-100 shadow-lg transition-all max-h-[90vh] flex flex-col mx-4 sm:mx-auto">
        <header class="px-6 py-4 border-b border-gray-100 flex-shrink-0 flex items-center justify-between">
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
            <x-x-button></x-x-button>
        </header>

        <form method="POST" action="{{ route('attendance.manualEntry', $program->id) }}" class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" name="volunteer_id" value="{{ $selectedVolunteer->id }}">
            <input type="hidden" name="date" value="{{ \Carbon\Carbon::parse($program->date)->format('Y-m-d') }}">

            <div class="p-6 space-y-6">
                <!-- Volunteer Info -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-bold text-gray-700">Volunteer Name:</label>
                    <div class="flex items-center space-x-2 px-3 py-2 bg-gray-50 rounded-md border border-gray-200">
                        <i class='bx bx-user text-gray-500'></i>
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
                        <label class="block text-sm font-medium text-gray-700">Time In</label>
                        <div class="relative flex items-center">
                            <i class='bx bx-time-five absolute left-3 text-gray-400'></i>
                            @if($clockIn)
                                <input type="text" readonly class="w-full pl-10 pr-3 py-2 rounded-md border border-gray-200 bg-gray-100 text-gray-700 focus:outline-none" value="{{ $clockIn->format('g:i A') }}">
                            @else
                                <input type="time" name="clock_in" class="w-full pl-10 pr-3 py-2 rounded-md border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors" required>
                            @endif
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-gray-700">Time Out</label>
                        <div class="relative flex items-center">
                            <i class='bx bx-time-five absolute left-3 text-gray-400'></i>
                            @if($clockOut)
                                <input type="text" readonly class="w-full pl-10 pr-3 py-2 rounded-md border border-gray-200 bg-gray-100 text-gray-700 focus:outline-none" value="{{ $clockOut->format('g:i A') }}">
                            @else
                                <input type="time" name="clock_out" class="w-full pl-10 pr-3 py-2 rounded-md border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reason -->
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Reason for Manual Entry (optional): <span class="text-gray-500 text-xs">(optional)</span></label>
                    <textarea 
                        name="notes" 
                        class="w-full px-3 py-2 rounded-md border border-gray-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors resize-none"
                        rows="3"
                        placeholder="Explain why manual entry is needed..."
                    >{{ $attendance?->notes }}</textarea>
                </div>
            </div>

            <footer class="flex flex-col sm:flex-row justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100">
                <button 
                    type="button" 
                    class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors border border-gray-300 rounded-md bg-white"
                    onclick="document.getElementById('manualAttendanceModal_{{ $selectedVolunteer->id }}').close()"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors"
                >
                    Save Attendance
                </button>
            </footer>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop bg-black/40 backdrop-blur-sm fixed inset-0 z-[-1]"></form>
</dialog>