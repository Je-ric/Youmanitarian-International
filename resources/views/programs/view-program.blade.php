@extends('layouts.sidebar_final')

@section('content')
    <div class="container mx-auto p-6">

        @php
            $volunteerId = auth()->user()?->volunteer?->id;

            $userFeedback = \App\Models\ProgramFeedback::where('program_id', $program->id)
                ->where('volunteer_id', $volunteerId)
                ->first();
        @endphp

        <x-header-with-button title="Any Title" description="">
            <x-button variant="secondary" onclick="document.getElementById('uploadProofModal').showModal();">
                Upload Proof
            </x-button>
            <x-button variant="secondary"
                onclick="document.getElementById('feedbackModal_{{ $program->id }}').showModal();">Rate & Review</x-button>
        </x-header-with-button>

        <dialog id="feedbackModal_{{ $program->id }}" class="modal">
            <form method="POST" action="{{ route('programs.feedback.submit', $program->id) }}" class="modal-box"
                onsubmit="return {{ $userFeedback ? 'false' : 'true' }};">
                @csrf
                <h3 class="font-bold text-lg mb-4">Rate & Review Program</h3>

                <label class="block mb-2 font-semibold">Rating</label>
                <select name="rating" {{ $userFeedback ? 'disabled' : '' }} required
                    class="select select-bordered w-full mb-4">
                    <option value="">Choose Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ $userFeedback && $userFeedback->rating == $i ? 'selected' : '' }}>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                    @endfor
                </select>

                <label class="block mb-2 font-semibold">Your Feedback</label>
                <textarea name="feedback" rows="4" class="textarea textarea-bordered w-full mb-4" {{ $userFeedback ? 'readonly' : '' }}
                    placeholder="Share your thoughts...">{{ $userFeedback ? $userFeedback->feedback : '' }}</textarea>

                @if($userFeedback)
                    <input type="hidden" name="rating" value="{{ $userFeedback->rating }}">
                    <input type="hidden" name="feedback" value="{{ $userFeedback->feedback }}">
                @endif

                <div class="modal-action">
                    @if(!$userFeedback)
                        <button type="submit" class="btn btn-primary">Submit</button>
                    @else
                        <button type="button" class="btn btn-disabled" disabled>Feedback Submitted</button>
                    @endif
                    <button type="button" onclick="document.getElementById('feedbackModal_{{ $program->id }}').close();"
                        class="btn">Close</button>
                </div>
            </form>
        </dialog>



        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="card bg-base-100 shadow-lg">
                <div class="card-body space-y-3">
                    <div class="flex justify-between">
                        <h2 class="card-title text-xl">{{ $program->title }}</h2>

                        <x-status-indicator status="success" />
                    </div>

                    <p><span class="font-semibold">Description:</span> {{ $program->description }}</p>
                    <p><span class="font-semibold">Organizer:</span> {{ $program->creator->name }}</p>

                    <p>
                        <span class="font-semibold">Date:</span>
                        {{ \Carbon\Carbon::parse($program->start_date)->format('F j, Y') }}
                        @if($program->end_date)
                            - {{ \Carbon\Carbon::parse($program->end_date)->format('F j, Y') }}
                        @endif
                    </p>

                    <p>
                        <span class="font-semibold">Time:</span>
                        @php
                            $startTime = \Carbon\Carbon::parse($program->start_time)->format('g:ia');
                            $endTime = $program->end_time ? \Carbon\Carbon::parse($program->end_time)->format('g:ia') : null;
                        @endphp
                        {{ $endTime ? "$startTime - $endTime" : $startTime }}
                    </p>

                    <p><span class="font-semibold">Location:</span> {{ $program->location ?? 'N/A' }}</p>
                    <p><span class="font-semibold">Volunteers:</span> {{ $program->volunteers->count() }}</p>

                    <div class="flex items-center gap-2">
                        <span class="font-semibold">Status:</span>
                        @php
                            $today = now();
                            if ($program->start_date > $today) {
                                echo '<span class="text-blue-500">Incoming</span>';
                            } elseif ($program->end_date && $program->end_date < $today) {
                                echo '<span class="text-gray-500">Done</span>';
                            } else {
                                echo '<span class="text-green-500">Ongoing</span>';
                            }
                        @endphp
                    </div>
                </div>
            </div>

            {{-- Clock In/Out Card --}}
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body space-y-4">
                    <h2 class="text-4xl font-bold text-[#1a2235] mb-8">Your Attendance</h2>

                    {{-- Flash Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success shadow-lg">
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-error shadow-lg">
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @php
                        $today = now()->setTimezone('Asia/Manila');
                        $isUpcoming = $program->start_date > $today;
                    @endphp

                    {{-- Attendance Status Header --}}
                    <p class="text-sm font-semibold">Current Status:</p>

                    @if($attendance && $attendance->clock_in)
                        @php
                            $clockInTime = \Carbon\Carbon::parse($attendance->clock_in)->setTimezone('Asia/Manila');
                        @endphp
                        <h3 class="text-sm font-bold text-[#1a2235] mb-4">Clocked In</h3>
                        <div class="flex gap-2"><strong>Time In:</strong> <span>{{ $clockInTime->format('g:ia') }}</span></div>
                    @else
                        <h3 class="text-sm font-bold text-[#1a2235] mb-4">Not Yet Clocked In</h3>
                        <div class="flex gap-2"><strong>Time In:</strong> <span>--:--</span></div>
                    @endif

                    @if($attendance && $attendance->clock_out)
                        @php
                            $clockOutTime = \Carbon\Carbon::parse($attendance->clock_out)->setTimezone('Asia/Manila');
                            $duration = $clockInTime->diff($clockOutTime);
                            $formatted = sprintf('%02d hr %02d min %02d sec', $duration->h, $duration->i, $duration->s);
                        @endphp
                        <div class="flex gap-2"><strong>Time Out:</strong> <span>{{ $clockOutTime->format('g:ia') }}</span>
                        </div>
                        <div class="flex gap-2"><strong>Total Worked:</strong> <span>{{ $formatted }}</span></div>
                    @else
                        <div class="flex gap-2"><strong>Time Out:</strong> <span>--:--</span></div>
                    @endif

                    {{-- Attendance Buttons --}}
                    @if($isUpcoming)
                        <div class="alert alert-warning mt-4">
                            <span>This program hasn’t started yet. Clock-in will be available on
                                <strong>{{ \Carbon\Carbon::parse($program->start_date)->format('F j, Y') }}</strong> at
                                <strong>{{ \Carbon\Carbon::parse($program->start_time)->format('g:ia') }}</strong>.
                            </span>
                        </div>

                        <button class="btn btn-primary w-full mt-2" disabled>Clock In (Unavailable)</button>
                        <button class="btn btn-error w-full mt-2" disabled>Clock Out (Unavailable)</button>

                    @elseif($isAssigned)
                        @if($attendance && $attendance->clock_in && !$attendance->clock_out)
                            {{-- Clocked In Only --}}
                            <form action="{{ route('programs.clock-out', $program) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="btn btn-error w-full">Clock Out</button>
                            </form>

                            <button class="btn btn-primary w-full mt-2" disabled>Clock In (Already Done)</button>

                        @elseif($attendance && $attendance->clock_out)
                            {{-- Both Clocked In and Out --}}
                            <button class="btn btn-primary w-full mt-4" disabled>Clock In (Completed)</button>
                            <button class="btn btn-error w-full mt-2" disabled>Clock Out (Completed)</button>

                        @else
                            {{-- Not Yet Clocked In --}}
                            <form action="{{ route('programs.clock-in', $program) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="btn btn-primary w-full">Clock In</button>
                            </form>

                            <button class="btn btn-error w-full mt-2" disabled>Clock Out (Clock In First)</button>
                        @endif

                    @else
                        <div class="alert alert-info mt-4">
                            <span>You are not assigned to this program.</span>
                        </div>
                    @endif


                </div>
            </div>
        </div>

        <section class="max-w-7xl mx-auto p-6 bg-yellow-50 rounded-2xl border-2 border-amber-400 mt-6 flex flex-col gap-8">
            <div class="flex justify-between items-center">
                <article>
                    <h2 id="reminders-title" class="text-gray-800 text-lg font-bold leading-loose">Reminders:
                    </h2>
                    <p class="text-gray-800 text-lg font-normal leading-loose">
                        Volunteers can only Clock In once and Clock Out once per program.<br>
                        Attendance will only be accessible once the program has started.<br>
                        After Clock In, Clock In button becomes disabled.<br>
                        After Clock Out, Clock Out button becomes disabled.
                    </p>
                </article>

                <article>
                    <h2 class="text-gray-800 text-lg font-bold leading-loose">Missing Attendance:</h2>
                    <p class="text-gray-800 text-lg font-normal leading-loose">
                        If you missed Clocking In or Clocking Out, please contact your program coordinator.<br>
                        The coordinator can manually enter the missing attendance record for you.<br>
                        Be sure to provide a reason for the missed attendance when requesting manual entry.
                    </p>
                </article>
            </div>

            <p class="text-center text-gray-800 text-lg leading-loose">
                <strong>Please be reminded that attendance is taken seriously.</strong>
                It serves as official documentation of your participation and will be used as one of the primary bases for
                recognizing your contribution to the program.
            </p>
            <p>Remember that you have to take an clock in first before making the upload of proof possible?</p>
        </section>

    </div>

    @php
        $volunteerId = auth()->user()?->volunteer?->id;

        // Get current volunteer's attendance record for this program
        $volunteerAttendance = \App\Models\VolunteerAttendance::where('program_id', $program->id)
            ->where('volunteer_id', $volunteerId)
            ->first();

        $proofPath = $volunteerAttendance?->proof_image;
    @endphp

    <dialog id="uploadProofModal" class="modal">
        <form method="POST" action="{{ route('attendance.uploadProof', $program->id) }}" enctype="multipart/form-data"
            class="modal-box max-w-lg p-6 rounded-lg bg-white">
            @csrf

            <h3 class="text-xl font-bold mb-4">Upload Proof of Attendance</h3>

            @if ($proofPath)
                <div class="mb-4">
                    <p class="mb-2 text-sm text-gray-600 font-semibold font-['Poppins']">Your uploaded proof:</p>

                    <img src="{{ asset('storage/' . $proofPath) }}" alt="Proof of Attendance"
                        class="w-full max-w-xs rounded shadow border mb-2">

                    <a href="{{ asset('storage/' . $proofPath) }}" target="_blank"
                        class="text-blue-600 hover:text-blue-800 underline font-['Poppins'] text-sm">
                        View Full Size
                    </a>
                </div>
            @else
                <div class="mb-4">
                    <label for="proof_image" class="block text-sm font-semibold text-gray-700 mb-2">Upload Image:</label>
                    <input type="file" name="proof_image" id="proof_image" accept="image/*" required
                        class="file-input file-input-bordered w-full">
                    @error('proof_image')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="modal-action flex justify-end gap-3">
                @if (!$proofPath)
                    <button type="submit" class="btn btn-primary">Upload</button>
                @endif
                <button type="button" onclick="document.getElementById('uploadProofModal').close();" class="btn">
                    {{ $proofPath ? 'Close' : 'Cancel' }}
                </button>
            </div>
        </form>
    </dialog>



@endsection