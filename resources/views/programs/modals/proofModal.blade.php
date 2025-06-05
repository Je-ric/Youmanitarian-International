@php
    $volunteerId = auth()->user()?->volunteer?->id;

    $volunteerAttendance = \App\Models\VolunteerAttendance::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();

    $proofPath = $volunteerAttendance?->proof_image;
@endphp

<dialog id="uploadProofModal" class="modal p-0">
    <form method="POST" action="{{ route('attendance.uploadProof', $program->id) }}" enctype="multipart/form-data"
        class="modal-box max-w-md sm:max-w-lg lg:max-w-xl p-6 rounded-lg bg-white mx-4 sm:mx-auto">
        @csrf

        <h3 class="text-2xl font-bold mb-6 text-gray-900">Upload Proof of Attendance</h3>

        @if ($proofPath)
            <div class="mb-6">
                <p class="mb-3 text-sm font-semibold text-gray-700 font-['Poppins']">Your uploaded proof:</p>

                <img src="{{ asset('storage/' . $proofPath) }}" alt="Proof of Attendance"
                    class="w-full max-w-xs sm:max-w-sm md:max-w-md rounded-lg shadow-md border border-gray-300 mb-3 object-contain mx-auto">

                <a href="{{ asset('storage/' . $proofPath) }}" target="_blank"
                    class="block text-center text-blue-600 hover:text-blue-800 underline font-['Poppins'] text-sm sm:text-base">
                    View Full Size
                </a>
            </div>
        @else
            <div class="mb-6">
                <label for="proof_image" class="block text-sm font-semibold text-gray-700 mb-2">Upload Image:</label>
                <input type="file" name="proof_image" id="proof_image" accept="image/*" required
                    class="file-input file-input-bordered w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                @error('proof_image')
                    <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                @enderror
            </div>
        @endif

        <div class="modal-action flex justify-end gap-4 flex-wrap">
            @if (!$proofPath)
                <button type="submit" class="btn btn-primary px-6 py-2 rounded-md shadow-md hover:bg-blue-700 transition w-full sm:w-auto">
                    Upload
                </button>
            @endif

            <button type="button" onclick="document.getElementById('uploadProofModal').close();"
                class="btn btn-outline px-6 py-2 rounded-md shadow-sm hover:bg-gray-100 transition w-full sm:w-auto">
                {{ $proofPath ? 'Close' : 'Cancel' }}
            </button>
        </div>
    </form>
</dialog>