@php
    $volunteerId = auth()->user()?->volunteer?->id;
    $userFeedback = \App\Models\ProgramFeedback::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();
@endphp

<dialog id="feedbackModal_{{ $program->id }}" class="modal">
    <div class="modal-box relative w-[95%] max-w-xl sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl p-6 sm:p-8">
        {{-- <button type="button" onclick="document.getElementById('feedbackModal_{{ $program->id }}').close();"
            class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4">
            ✕
        </button> --}}
        <x-x-button>
            
        </x-x-button>

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
</dialog>
