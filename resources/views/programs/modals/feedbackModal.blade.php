@php
    $volunteerId = auth()->user()?->volunteer?->id;

    $userFeedback = \App\Models\ProgramFeedback::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();
@endphp

<dialog id="feedbackModal_{{ $program->id }}" class="modal">
    <form method="POST" action="{{ route('programs.feedback.submit', $program->id) }}"
        class="modal-box w-[95%] max-w-xl sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl p-6 sm:p-8"
        onsubmit="return {{ $userFeedback ? 'false' : 'true' }};">
        @csrf

        <h3 class="font-bold text-xl sm:text-2xl mb-4">Rate & Review Program</h3>

        <label class="block mb-2 font-semibold text-sm sm:text-base">Rating</label>
        <select name="rating" {{ $userFeedback ? 'disabled' : '' }} required class="select select-bordered w-full mb-4">
            <option value="">Choose Rating</option>
            @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ $userFeedback && $userFeedback->rating == $i ? 'selected' : '' }}>
                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                </option>
            @endfor
        </select>

        <label class="block mb-2 font-semibold text-sm sm:text-base">Your Feedback</label>
        <textarea name="feedback" rows="4"
            class="textarea textarea-bordered w-full mb-4 resize-none text-sm sm:text-base" {{ $userFeedback ? 'readonly' : '' }}
            placeholder="Share your thoughts...">{{ $userFeedback ? $userFeedback->feedback : '' }}</textarea>

        @if($userFeedback)
            <input type="hidden" name="rating" value="{{ $userFeedback->rating }}">
            <input type="hidden" name="feedback" value="{{ $userFeedback->feedback }}">
        @endif

        <div class="modal-action flex flex-col sm:flex-row gap-2 sm:gap-4 justify-end">
            @if(!$userFeedback)
                <button type="submit" class="btn btn-primary w-full sm:w-auto">Submit</button>
            @else
                <button type="button" class="btn btn-disabled w-full sm:w-auto" disabled>Feedback Submitted</button>
            @endif
            <button type="button" onclick="document.getElementById('feedbackModal_{{ $program->id }}').close();"
                class="btn w-full sm:w-auto">Close</button>
        </div>
    </form>
</dialog>