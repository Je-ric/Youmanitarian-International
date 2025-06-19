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
        <x-modal.header>
            <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Upload Proof of Attendance</h3>
        </x-modal.header>

        <!-- Main Content - Scrollable -->
        @if ($proofPath)
            <div class="p-6 space-y-6 overflow-y-auto flex-1">
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
            </div>

            <!-- Footer - Always Visible -->
            <x-modal.footer>
                <x-modal.close-button :modalId="'uploadProofModal'" text="Close" />
            </x-modal.footer>
        @else
            <form method="POST" action="{{ route('attendance.uploadProof', $program->id) }}" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
                @csrf
                
                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    <div class="space-y-4">
                        <div class="border-b border-slate-200 pb-4">
                            <p class="text-sm text-slate-600">Please upload an image as proof of your attendance at this program.</p>
                        </div>

                        <div class="space-y-3">
                            <label for="proof_image" class="block text-sm font-semibold text-slate-700">
                                Upload Image:
                            </label>
                            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                <x-input-upload name="proof_image" id="proof_image" accept="image/*" required>
                                    PNG, JPG up to 10MB
                                </x-input-upload>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer - Always Visible -->
                <x-modal.footer>
                    <x-modal.close-button :modalId="'uploadProofModal'" text="Cancel" variant="cancel" />
                    
                    <x-button type="submit" variant="save-entry">
                        <i class='bx bx-upload'></i>
                        Upload
                    </x-button>
                </x-modal.footer>
            </form>
        @endif
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