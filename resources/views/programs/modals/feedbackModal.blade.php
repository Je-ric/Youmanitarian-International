@php
    $volunteerId = auth()->user()?->volunteer?->id;
    $userFeedback = \App\Models\ProgramFeedback::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();
@endphp

<dialog id="feedbackModal_{{ $program->id }}" class="modal p-0">
    <div
        class="modal-box max-w-xl p-0 overflow-hidden rounded-xl bg-white border border-slate-200 transition-all max-h-[90vh] flex flex-col mx-4 sm:mx-auto">

        <x-modal.header>
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Program Feedback</h2>
                <p class="text-sm text-slate-600 mt-1">Please rate your experience and share your feedback.</p>
            </div>
        </x-modal.header>

        {{-- Main Content - Scrollable --}}
        <div class="flex flex-col flex-1 min-h-0">
            <form method="POST" action="{{ route('programs.feedback.submit', $program->id) }}"
                onsubmit="return {{ $userFeedback ? 'false' : 'true' }};" class="flex flex-col flex-1 min-h-0">
                @csrf

                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    @if($userFeedback)
                        <x-feedback-status.alert
                            type="success"
                            icon="bx bx-check-circle"
                            message="Thank you for your feedback! We truly appreciate your contribution."
                        />
                    @endif

                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <x-form.label>Rating</x-form.label>
                        </div>

                        <div class="bg-slate-50 border rounded-lg p-6">
                            <div class="rating flex justify-center gap-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $isChecked = $userFeedback && $userFeedback->rating == $i;
                                        $isFilled = $userFeedback && $userFeedback->rating >= $i;
                                        $colorClass = $isFilled ? 'bg-yellow-400' : 'bg-gray-300';
                                    @endphp
                                    <input type="radio" name="rating" value="{{ $i }}"
                                        class="mask mask-star {{ $colorClass }} w-8 h-8" {{ $userFeedback ? 'disabled' : '' }}
                                        {{ $isChecked ? 'checked' : '' }} required />
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="border-b border-slate-200 pb-4">
                            <x-form.label>Your Feedback</x-form.label>
                        </div>

                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                            <x-form.textarea
                                name="feedback"
                                :value="$userFeedback ? $userFeedback->feedback : ''"
                                :disabled="$userFeedback"
                                rows="4"
                                placeholder="Share your thoughts about this program..."
                            />
                        </div>
                    </div>

                    @if($userFeedback)
                        <input type="hidden" name="rating" value="{{ $userFeedback->rating }}">
                        <input type="hidden" name="feedback" value="{{ $userFeedback->feedback }}">
                    @endif
                </div>

                <x-modal.footer>
                    <x-modal.close-button :modalId="'feedbackModal_' . $program->id" text="Cancel" variant="cancel" />
                    @if(!$userFeedback)
                        <x-button type="submit" variant="save-entry" class="px-6 py-2 text-sm font-medium flex items-center gap-2">
                            <i class='bx bx-send'></i>
                            Submit Feedback
                        </x-button>
                    @else
                        <x-button type="button"
                            variant="disabled"
                            disabled>
                            <i class='bx bx-check'></i>
                            Feedback Submitted
                        </x-button>
                    @endif
                </x-modal.footer>
            </form>
        </div>
    </div>
</dialog>

<style>
    .rating input[type="radio"]:checked {
        background-color: #fbbf24 !important;
    }

    .rating input[type="radio"]:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

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