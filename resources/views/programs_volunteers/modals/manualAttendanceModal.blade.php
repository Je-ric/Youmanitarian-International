{{-- filepath: resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php --}}
<dialog id="manualAttendanceModal_{{ $selectedVolunteer->id }}" class="modal">
    <div class="modal-box max-w-lg p-0 overflow-hidden rounded-xl bg-white border border-slate-200 transition-all max-h-[90vh] flex flex-col mx-4 sm:mx-auto">
        <header class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex-shrink-0 flex items-center justify-between">
            <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Manual Attendance Entry</h3>
            <button type="button" onclick="document.getElementById('manualAttendanceModal_{{ $selectedVolunteer->id }}').close()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </header>
        <form method="POST" action="{{ route('attendance.manualEntry', $program->id) }}" class="flex flex-col flex-1 min-h-0 p-6">
            @csrf
            <input type="hidden" name="volunteer_id" value="{{ $selectedVolunteer->id }}">
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">Volunteer</label>
                <div class="px-4 py-2 bg-gray-100 rounded text-gray-800 font-medium">
                    {{ $selectedVolunteer->user->name ?? 'No Name' }}
                </div>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">Date</label>
                <div class="px-4 py-2 bg-gray-100 rounded text-gray-800 font-medium">
                    {{ \Carbon\Carbon::parse($program->date)->format('F d, Y') }}
                </div>
                <input type="hidden" name="date" value="{{ \Carbon\Carbon::parse($program->date)->format('Y-m-d') }}">
            </div>
            @php
                $clockIn = $attendance?->clock_in ? \Carbon\Carbon::parse($attendance->clock_in) : null;
                $clockOut = $attendance?->clock_out ? \Carbon\Carbon::parse($attendance->clock_out) : null;
            @endphp
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">Clock In Time</label>
                <input
                    type="time"
                    name="clock_in"
                    class="input input-bordered w-full"
                    required
                    value="{{ $clockIn ? $clockIn->format('H:i') : '' }}"
                >
                @if($clockIn)
                    <div class="text-xs text-green-600 mt-1">Current: {{ $clockIn->format('g:i A') }}</div>
                @endif
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">Clock Out Time (optional)</label>
                <input
                    type="time"
                    name="clock_out"
                    class="input input-bordered w-full"
                    value="{{ $clockOut ? $clockOut->format('H:i') : '' }}"
                >
                @if($clockOut)
                    <div class="text-xs text-green-600 mt-1">Current: {{ $clockOut->format('g:i A') }}</div>
                @endif
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">Reason / Notes <span class="text-red-500">*</span></label>
                <textarea name="notes" class="textarea textarea-bordered w-full" rows="3" required placeholder="Enter reason or notes (e.g. forgot to clock out, late arrival, etc.)">{{ $attendance?->notes }}</textarea>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('manualAttendanceModal_{{ $selectedVolunteer->id }}').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Attendance</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop bg-black/40 backdrop-blur-sm fixed inset-0 z-[-1]"></form>
</dialog>