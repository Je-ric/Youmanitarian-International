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
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">Volunteer</label>
                <select name="volunteer_id" class="select select-bordered w-full" required>
                    <option value="">Select Volunteer</option>
                    @foreach($volunteers as $vol)
                        <option value="{{ $vol->id }}" {{ $selectedVolunteer->id == $vol->id ? 'selected' : '' }}>
                            {{ $vol->user->name ?? 'No Name' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">Clock In</label>
                <input type="datetime-local" name="clock_in" class="input input-bordered w-full" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1 text-gray-700">Clock Out (optional)</label>
                <input type="datetime-local" name="clock_out" class="input input-bordered w-full">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('manualAttendanceModal_{{ $selectedVolunteer->id }}').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Attendance</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop bg-black/40 backdrop-blur-sm fixed inset-0 z-[-1]"></form>
</dialog>