{{-- @php
    $volunteerId = auth()->user()?->volunteer?->id;
    $userFeedback = \App\Models\ProgramFeedback::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();
@endphp

<dialog id="feedbackModal_{{ $program->id }}" class="modal">
    <div class="modal-box relative w-[95%] max-w-xl sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl p-6 sm:p-8">
        <x-x-button></x-x-button>

        <h2 class="text-2xl font-bold mb-1">Program Feedback</h2>
        <p class="mb-4 text-sm text-gray-500">Please rate your experience and share your feedback.</p>
        <div class="border-b border-gray-300 mb-4"></div>

        @if($userFeedback)
            <div class="alert alert-success alert-dash text-sm mb-6">
                💛 <span>Thank you for your feedback! We truly appreciate your contribution.</span>
            </div>
        @endif

        <form method="POST" action="{{ route('programs.feedback.submit', $program->id) }}"
            onsubmit="return {{ $userFeedback ? 'false' : 'true' }};">
            @csrf

            <label class="block mb-2 font-semibold text-sm sm:text-base text-center">Rating</label>
            <div class="rating mb-6 flex justify-center">
                @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" name="rating" value="{{ $i }}" class="mask mask-star bg-yellow-400"
                        {{ $userFeedback ? 'disabled' : '' }}
                        {{ ($userFeedback && $userFeedback->rating == $i) ? 'checked' : '' }} required />
                @endfor
            </div>

            <label class="block mb-2 font-semibold text-sm sm:text-base">Your Feedback</label>
            <textarea name="feedback" rows="4"
                class="textarea textarea-bordered w-full mb-6 resize-none text-sm sm:text-base"
                placeholder="Share your thoughts about this program..." {{ $userFeedback ? 'readonly' : '' }}>{{ $userFeedback ? $userFeedback->feedback : '' }}</textarea>

            @if($userFeedback)
                <input type="hidden" name="rating" value="{{ $userFeedback->rating }}">
                <input type="hidden" name="feedback" value="{{ $userFeedback->feedback }}">
            @endif

            <div class="border-t border-gray-300 mt-6 pt-4 modal-action flex justify-between items-center">
                <button type="button" onclick="document.getElementById('feedbackModal_{{ $program->id }}').close();"
                    class="btn">Cancel</button>

                @if(!$userFeedback)
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                @else
                    <button type="button" class="btn btn-disabled" disabled>Feedback Submitted</button>
                @endif
            </div>
        </form>
    </div>
</dialog> --}}

@php
    $volunteerId = auth()->user()?->volunteer?->id;
    $userFeedback = \App\Models\ProgramFeedback::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();
@endphp

<dialog id="feedbackModal_{{ $program->id }}" class="modal p-0">
    <div class="modal-box max-w-xl p-0 overflow-hidden rounded-xl bg-white border border-slate-200 transition-all max-h-[90vh] flex flex-col mx-4 sm:mx-auto">
        
        <!-- Header -->
        <header class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Program Feedback</h2>
                    <p class="text-sm text-slate-600 mt-1">Please rate your experience and share your feedback.</p>
                </div>
                <button onclick="document.getElementById('feedbackModal_{{ $program->id }}').close()" 
                        class="p-2 hover:bg-slate-200 rounded-lg transition-colors duration-200">
                    <i class='bx bx-x text-slate-500 text-xl'></i>
                </button>
            </div>
        </header>

        <!-- Main Content - Scrollable -->
        <form method="POST" action="{{ route('programs.feedback.submit', $program->id) }}"
              onsubmit="return {{ $userFeedback ? 'false' : 'true' }};" class="flex flex-col flex-1 min-h-0">
            @csrf
            
            <div class="p-6 space-y-6 overflow-y-auto flex-1">
                
                @if($userFeedback)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center gap-2 text-green-700">
                            <i class='bx bx-check-circle text-green-500'></i>
                            <span class="font-medium text-sm">Thank you for your feedback! We truly appreciate your contribution.</span>
                        </div>
                    </div>
                @endif

                <!-- Rating Section -->
                <div class="space-y-4">
                    <div class="border-b border-slate-200 pb-4">
                        <label class="block font-semibold text-slate-900 text-center">Rating</label>
                    </div>
                    
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-6">
                        <div class="rating flex justify-center gap-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" 
                                       class="mask mask-star bg-yellow-400 w-8 h-8"
                                       {{ $userFeedback ? 'disabled' : '' }}
                                       {{ ($userFeedback && $userFeedback->rating == $i) ? 'checked' : '' }} 
                                       required />
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Feedback Section -->
                <div class="space-y-4">
                    <div class="border-b border-slate-200 pb-4">
                        <label class="block font-semibold text-slate-900">Your Feedback</label>
                    </div>
                    
                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <textarea name="feedback" rows="4"
                                  class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                  placeholder="Share your thoughts about this program..." 
                                  {{ $userFeedback ? 'readonly' : '' }}>{{ $userFeedback ? $userFeedback->feedback : '' }}</textarea>
                    </div>
                </div>

                @if($userFeedback)
                    <input type="hidden" name="rating" value="{{ $userFeedback->rating }}">
                    <input type="hidden" name="feedback" value="{{ $userFeedback->feedback }}">
                @endif
            </div>

            <!-- Footer - Always Visible -->
            <footer class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex justify-between items-center flex-shrink-0">
                <button type="button" onclick="document.getElementById('feedbackModal_{{ $program->id }}').close();"
                        class="px-6 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Cancel
                </button>

                @if(!$userFeedback)
                    <button type="submit" 
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class='bx bx-send'></i>
                        Submit Feedback
                    </button>
                @else
                    <button type="button" 
                            class="px-6 py-2 text-sm font-medium text-slate-400 bg-slate-100 border border-slate-300 rounded-lg cursor-not-allowed" 
                            disabled>
                        <i class='bx bx-check'></i>
                        Feedback Submitted
                    </button>
                @endif
            </footer>
        </form>
    </div>
</dialog>

<style>
/* Custom rating styles */
.rating input[type="radio"]:checked {
    background-color: #fbbf24 !important;
}

.rating input[type="radio"]:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Responsive adjustments for feedback modal */
@media (max-width: 768px) {
    #feedbackModal_{{ $program->id }} .modal-box {
        max-width: 95vw;
        margin: 1rem;
        max-height: 95vh;
    }
}

@media (max-width: 480px) {
    #feedbackModal_{{ $program->id }} .modal-box {
        max-width: 100vw;
        margin: 0.5rem;
        max-height: 98vh;
    }
    
    #feedbackModal_{{ $program->id }} header .px-6,
    #feedbackModal_{{ $program->id }} .p-6,
    #feedbackModal_{{ $program->id }} footer .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    #feedbackModal_{{ $program->id }} footer {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    #feedbackModal_{{ $program->id }} footer button {
        width: 100%;
        justify-content: center;
    }
}
</style>