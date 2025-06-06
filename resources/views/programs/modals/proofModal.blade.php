{{-- @php
    $volunteerId = auth()->user()?->volunteer?->id;

    $volunteerAttendance = \App\Models\VolunteerAttendance::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();

    $proofPath = $volunteerAttendance?->proof_image;
@endphp

<dialog id="uploadProofModal" class="modal p-0">
    <x-x-button></x-x-button>
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
</dialog> --}}

@php
    $volunteerId = auth()->user()?->volunteer?->id;

    $volunteerAttendance = \App\Models\VolunteerAttendance::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();

    $proofPath = $volunteerAttendance?->proof_image;
@endphp

<dialog id="uploadProofModal" class="modal p-0">
    <div class="modal-box max-w-lg p-0 overflow-hidden rounded-xl bg-white border border-slate-200 transition-all max-h-[90vh] flex flex-col mx-4 sm:mx-auto">
        
        <!-- Header -->
        <header class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex-shrink-0">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Upload Proof of Attendance</h3>
                <button onclick="document.getElementById('uploadProofModal').close()" 
                        class="p-2 hover:bg-slate-200 rounded-lg transition-colors duration-200">
                    <i class='bx bx-x text-slate-500 text-xl'></i>
                </button>
            </div>
        </header>

        <!-- Main Content - Scrollable -->
        <form method="POST" action="{{ route('attendance.uploadProof', $program->id) }}" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
            @csrf
            
            <div class="p-6 space-y-6 overflow-y-auto flex-1">
                @if ($proofPath)
                    <div class="space-y-4">
                        <div class="border-b border-slate-200 pb-4">
                            <p class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                                <i class='bx bx-check-circle text-green-500'></i>
                                Your uploaded proof:
                            </p>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                            <img src="{{ asset('storage/' . $proofPath) }}" alt="Proof of Attendance"
                                class="w-full max-w-sm rounded-lg border border-slate-300 mb-4 object-contain mx-auto">

                            <div class="text-center">
                                <a href="{{ asset('storage/' . $proofPath) }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors duration-200">
                                    <i class='bx bx-external-link'></i>
                                    View Full Size
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="space-y-4">
                        <div class="border-b border-slate-200 pb-4">
                            <p class="text-sm text-slate-600">Please upload an image as proof of your attendance at this program.</p>
                        </div>

                        <div class="space-y-3">
                            <label for="proof_image" class="block text-sm font-semibold text-slate-700">
                                Upload Image:
                            </label>
                            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                <input type="file" name="proof_image" id="proof_image" accept="image/*" required
                                    class="w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:transition-colors file:duration-200">
                            </div>
                            {{-- @error('proof_image')
                                <p class="text-red-600 mt-2 text-sm flex items-center gap-1">
                                    <i class='bx bx-error-circle'></i>
                                    {{ $message }}
                                </p>
                            @enderror --}}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer - Always Visible -->
            <footer class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex justify-end gap-3 flex-shrink-0">
                @if (!$proofPath)
                    <button type="submit" 
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class='bx bx-upload'></i>
                        Upload
                    </button>
                @endif

                <button type="button" onclick="document.getElementById('uploadProofModal').close();"
                        class="px-6 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    {{ $proofPath ? 'Close' : 'Cancel' }}
                </button>
            </footer>
        </form>
    </div>
</dialog>

<style>
/* Responsive adjustments for upload modal */
@media (max-width: 768px) {
    #uploadProofModal .modal-box {
        max-width: 95vw;
        margin: 1rem;
        max-height: 95vh;
    }
}

@media (max-width: 480px) {
    #uploadProofModal .modal-box {
        max-width: 100vw;
        margin: 0.5rem;
        max-height: 98vh;
    }
    
    #uploadProofModal header .px-6,
    #uploadProofModal .p-6,
    #uploadProofModal footer .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>