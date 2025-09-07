@php
    $canAccept = method_exists($program, 'canAcceptFeedback') ? $program->canAcceptFeedback() : false;
    $alreadySubmitted = session('guest_feedback_submitted_'.$program->id) ?? false;
@endphp

<x-modal.dialog id="guestFeedbackModal_{{ $program->id }}" maxWidth="max-w-xl" width="w-11/12" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <div>
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Program Feedback</h2>
            <p class="text-sm text-slate-600 mt-1">Share your feedback for “{{ $program->title }}”.</p>
        </div>
    </x-modal.header>

    <div class="flex flex-col flex-1 min-h-0">
        <form method="POST" action="{{ route('programs.feedback.guest.submit', $program->id) }}" class="flex flex-col flex-1 min-h-0">
            @csrf

            <x-modal.body>
                @if($alreadySubmitted)
                    <x-feedback-status.alert
                        type="success"
                        icon="bx bx-check-circle"
                        message="Thank you! Your feedback was submitted."
                    />
                @elseif(!$canAccept)
                    <x-feedback-status.alert
                        type="info"
                        icon="bx bx-info-circle"
                        message="Feedback is available only after the program ends and up to 7 days."
                    />
                @endif

                <div class="space-y-6">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <x-form.label>Name</x-form.label>
                            <x-form.input
                                type="text"
                                name="guest_name"
                                :value="old('guest_name')"
                                required
                                :disabled="$alreadySubmitted || !$canAccept"
                            />
                        </div>
                        <div>
                            <x-form.label>Email (optional)</x-form.label>
                            <x-form.input
                                type="email"
                                name="guest_email"
                                :value="old('guest_email')"
                                :disabled="$alreadySubmitted || !$canAccept"
                            />
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="border-b pb-3">
                            <x-form.label variant="rating">Rating</x-form.label>
                        </div>
                        <div class="bg-slate-50 border rounded-lg p-6">
                            <div class="rating flex justify-center gap-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input
                                        type="radio"
                                        name="rating"
                                        value="{{ $i }}"
                                        class="mask mask-star bg-gray-300 w-8 h-8"
                                        {{ old('rating') == $i ? 'checked' : '' }}
                                        {{ ($alreadySubmitted || !$canAccept) ? 'disabled' : '' }}
                                        required
                                    />
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="border-b border-slate-200 pb-3">
                            <x-form.label variant="your-feedback">Your Feedback</x-form.label>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                            <x-form.textarea
                                name="feedback"
                                rows="4"
                                placeholder="Share your experience..."
                                :disabled="$alreadySubmitted || !$canAccept"
                            >{{ old('feedback') }}</x-form.textarea>
                        </div>
                    </div>
                </div>
            </x-modal.body>

            <x-modal.footer>
                <x-modal.close-button :modalId="'guestFeedbackModal_' . $program->id" text="Cancel" variant="cancel" />
                @if(!$alreadySubmitted && $canAccept)
                    <x-button type="submit" variant="save-entry" class="px-6 py-2 text-sm font-medium flex items-center gap-2">
                        <i class='bx bx-send'></i>
                        Submit Feedback
                    </x-button>
                @else
                    <x-button type="button" variant="disabled" disabled>
                        <i class='bx bx-check'></i>
                        {{ $alreadySubmitted ? 'Feedback Submitted' : 'Not Accepting Feedback' }}
                    </x-button>
                @endif
            </x-modal.footer>
        </form>
    </div>
</x-modal.dialog>

<style>
    #guestFeedbackModal_{{ $program->id }} .rating input[type="radio"]:checked {
        background-color: #fbbf24 !important;
    }

    #guestFeedbackModal_{{ $program->id }} .rating input[type="radio"]:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        #guestFeedbackModal_{{ $program->id }} .modal-box {
            max-width: 95vw;
            margin: 1rem;
            max-height: 95vh;
        }
    }

    @media (max-width: 480px) {
        #guestFeedbackModal_{{ $program->id }} .modal-box {
            max-width: 100vw;
            margin: 0.5rem;
            max-height: 98vh;
        }

        #guestFeedbackModal_{{ $program->id }} header .px-6,
        #guestFeedbackModal_{{ $program->id }} .p-6,
        #guestFeedbackModal_{{ $program->id }} footer .px-6 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        #guestFeedbackModal_{{ $program->id }} footer {
            flex-direction: column;
            gap: 0.75rem;
        }

        #guestFeedbackModal_{{ $program->id }} footer button {
            width: 100%;
            justify-content: center;
        }
    }
</style>
