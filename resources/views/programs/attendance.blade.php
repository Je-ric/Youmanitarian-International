@extends('layouts.sidebar_final')

@php
    $volunteerId = auth()->user()?->volunteer?->id;

    $volunteerAttendance = \App\Models\VolunteerAttendance::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();

    $proofPath = $volunteerAttendance?->proof_image;
@endphp

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-4 sm:py-6">

        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">Volunteer Attendance - Clock In / Clock Out</h1>
                </div>
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    <x-button variant="secondary" class="w-full sm:w-auto" onclick="document.getElementById('uploadProofModal').showModal();">
                        <i class='bx bx-upload mr-1'></i> Upload Proof
                    </x-button>
                    <x-button variant="secondary" class="w-full sm:w-auto" onclick="document.getElementById('feedbackModal_{{ $program->id }}').showModal();">
                        <i class='bx bx-star mr-1'></i> Rate & Review
                    </x-button>
                </div>
            </div>
        </div>

        @include('programs.modals.feedbackModal', ['program' => $program, 'userFeedback' => $program->userFeedback])
        @include('programs.modals.proofModal', ['program' => $program, 'volunteerAttendance' => $volunteerAttendance,])

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">

            <section
                class="col-span-1 lg:col-span-2 w-full p-4 sm:p-5 bg-neutral-50 rounded-2xl outline outline-2 outline-offset-[-2px] outline-neutral-200 flex flex-col gap-4 sm:gap-7 shadow-lg">

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800 leading-tight sm:leading-[50px] tracking-tight">
                        {{ $program->title }}
                    </h2>
                    <x-status-indicator status="success" />
                    @php
                        $today = now();
                        if ($program->start_date > $today) {
                            $statusLabel = 'Incoming';
                            $statusClass = 'text-blue-500';
                        } elseif ($program->end_date && $program->end_date < $today) {
                            $statusLabel = 'Done';
                            $statusClass = 'text-gray-500';
                        } else {
                            $statusLabel = 'Ongoing';
                            $statusClass = 'text-green-500';
                        }
                    @endphp
                </div>

                <!-- Description -->
                <section>
                    <h3 class="text-black text-base font-medium tracking-tight mb-1">
                        Description
                    </h3>
                    <p class="text-gray-800 text-base sm:text-lg font-normal leading-relaxed sm:leading-loose">
                        {{ $program->description }}
                    </p>
                </section>

                <!-- Details -->
                <section class="flex flex-col gap-3 sm:gap-4">
                    <div class="flex flex-col sm:flex-row flex-wrap justify-between gap-3 sm:gap-4">
                        <!-- Date -->
                        <div class="flex items-center gap-2 min-w-[16rem]">
                            <i class='bx bx-calendar text-lg text-gray-700'></i>
                            <strong class="text-black text-sm sm:text-base font-medium tracking-tight">Date:</strong>
                            <span class="text-black text-sm sm:text-base font-normal tracking-tight">
                                {{ \Carbon\Carbon::parse($program->start_date)->format('F j, Y') }}
                                @if($program->end_date)
                                    - {{ \Carbon\Carbon::parse($program->end_date)->format('F j, Y') }}
                                @endif
                            </span>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center gap-2">
                            <i class='bx bx-map text-lg text-gray-700'></i>
                            <strong class="text-black text-sm sm:text-base font-medium tracking-tight">Location:</strong>
                            <span class="text-black text-sm sm:text-base font-normal tracking-tight">
                                {{ $program->location ?? 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row flex-wrap justify-between gap-3 sm:gap-4">
                        <!-- Time -->
                        @php
                            $startTime = \Carbon\Carbon::parse($program->start_time)->format('g:ia');
                            $endTime = $program->end_time ? \Carbon\Carbon::parse($program->end_time)->format('g:ia') : null;
                        @endphp
                        <div class="flex items-center gap-2 min-w-[16rem]">
                            <i class='bx bx-time text-lg text-gray-700'></i>
                            <strong class="text-black text-sm sm:text-base font-medium tracking-tight">Time:</strong>
                            <span class="text-black text-sm sm:text-base font-normal tracking-tight">
                                {{ $endTime ? "$startTime - $endTime" : $startTime }}
                            </span>
                        </div>

                        <!-- Coordinator -->
                        <div class="flex items-center gap-2 min-w-[12rem]">
                            <i class='bx bx-user text-lg text-gray-700'></i>
                            <strong class="text-black text-sm sm:text-base font-medium tracking-tight">Coordinator:</strong>
                            <span class="text-black text-sm sm:text-base font-normal tracking-tight">
                                {{ $program->creator->name }}
                            </span>
                        </div>
                    </div>
                </section>
            </section>

            {{-- Clock In/Out Card --}}
            <div class="col-span-1 card bg-base-100 shadow-lg rounded-2xl">
                <div class="card-body p-4 sm:p-6 space-y-3 sm:space-y-4">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#1a2235] mb-4 sm:mb-8">Your Attendance</h2>

                    {{-- Flash Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success shadow-lg text-sm sm:text-base">
                            <i class='bx bx-check-circle'></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-error shadow-lg text-sm sm:text-base">
                            <i class='bx bx-error-circle'></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    @php
                        $today = now()->setTimezone('Asia/Manila');
                        $isUpcoming = $program->start_date > $today;
                    @endphp

                    {{-- Attendance Status Header --}}
                    <p class="text-xs sm:text-sm font-semibold">Current Status:</p>

                    @if($attendance && $attendance->clock_in)
                        @php
                            $clockInTime = \Carbon\Carbon::parse($attendance->clock_in)->setTimezone('Asia/Manila');
                        @endphp
                        <h3 class="text-sm font-bold text-[#1a2235] mb-2 sm:mb-4">
                            <i class='bx bx-check-circle text-green-500'></i> Clocked In
                        </h3>
                        <div class="flex gap-2 text-sm sm:text-base">
                            <strong>Time In:</strong> <span>{{ $clockInTime->format('g:ia') }}</span>
                        </div>
                    @else
                        <h3 class="text-sm font-bold text-[#1a2235] mb-2 sm:mb-4">
                            <i class='bx bx-time text-yellow-500'></i> Not Yet Clocked In
                        </h3>
                        <div class="flex gap-2 text-sm sm:text-base"><strong>Time In:</strong> <span>--:--</span></div>
                    @endif

                    @if($attendance && $attendance->clock_out)
                        @php
                            $clockOutTime = \Carbon\Carbon::parse($attendance->clock_out)->setTimezone('Asia/Manila');
                            $duration = $clockInTime->diff($clockOutTime);
                            $formatted = sprintf('%02d hr %02d min %02d sec', $duration->h, $duration->i, $duration->s);
                        @endphp
                        <div class="flex gap-2 text-sm sm:text-base">
                            <strong>Time Out:</strong> <span>{{ $clockOutTime->format('g:ia') }}</span>
                        </div>
                        <div class="flex gap-2 text-sm sm:text-base">
                            <strong>Total Worked:</strong> <span>{{ $formatted }}</span>
                        </div>
                    @else
                        <div class="flex gap-2 text-sm sm:text-base"><strong>Time Out:</strong> <span>--:--</span></div>
                    @endif

                    {{-- Attendance Buttons --}}
                    @if($isUpcoming)
                        <div class="alert alert-warning mt-3 sm:mt-4 text-xs sm:text-sm">
                            <i class='bx bx-calendar-exclamation'></i>
                            <span>This program hasn't started yet. Clock-in will be available on
                                <strong>{{ \Carbon\Carbon::parse($program->start_date)->format('F j, Y') }}</strong> at
                                <strong>{{ \Carbon\Carbon::parse($program->start_time)->format('g:ia') }}</strong>.
                            </span>
                        </div>

                        <button class="btn btn-primary w-full mt-2 text-sm sm:text-base" disabled>
                            <i class='bx bx-log-in-circle'></i> Clock In (Unavailable)
                        </button>
                        <button class="btn btn-error w-full mt-2 text-sm sm:text-base" disabled>
                            <i class='bx bx-log-out-circle'></i> Clock Out (Unavailable)
                        </button>

                    @elseif($isAssigned)
                        @if($attendance && $attendance->clock_in && !$attendance->clock_out)
                            {{-- Clocked In Only --}}
                            <form action="{{ route('programs.clock-out', $program) }}" method="POST" class="mt-3 sm:mt-4">
                                @csrf
                                <button type="submit" class="btn btn-error w-full text-sm sm:text-base">
                                    <i class='bx bx-log-out-circle'></i> Clock Out
                                </button>
                            </form>

                            <button class="btn btn-primary w-full mt-2 text-sm sm:text-base" disabled>
                                <i class='bx bx-check-circle'></i> Clock In (Already Done)
                            </button>

                        @elseif($attendance && $attendance->clock_out)
                            {{-- Both Clocked In and Out --}}
                            <button class="btn btn-primary w-full mt-3 sm:mt-4 text-sm sm:text-base" disabled>
                                <i class='bx bx-check-circle'></i> Clock In (Completed)
                            </button>
                            <button class="btn btn-error w-full mt-2 text-sm sm:text-base" disabled>
                                <i class='bx bx-check-circle'></i> Clock Out (Completed)
                            </button>

                        @else
                            {{-- Not Yet Clocked In --}}
                            <form action="{{ route('programs.clock-in', $program) }}" method="POST" class="mt-3 sm:mt-4">
                                @csrf
                                <button type="submit" class="btn btn-primary w-full text-sm sm:text-base">
                                    <i class='bx bx-log-in-circle'></i> Clock In
                                </button>
                            </form>

                            <button class="btn btn-error w-full mt-2 text-sm sm:text-base" disabled>
                                <i class='bx bx-log-out-circle'></i> Clock Out (Clock In First)
                            </button>
                        @endif

                    @else
                        <div class="alert alert-info mt-3 sm:mt-4 text-xs sm:text-sm">
                            <i class='bx bx-info-circle'></i>
                            <span>You are not assigned to this program.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <section class="max-w-7xl mx-auto p-4 sm:p-6 bg-yellow-50 rounded-2xl border-2 border-amber-400 mt-4 sm:mt-6 flex flex-col gap-4 sm:gap-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <article class="w-full lg:w-1/2">
                    <h2 id="reminders-title" class="text-gray-800 text-base sm:text-lg font-bold leading-relaxed sm:leading-loose flex items-center">
                        <i class='bx bx-bell text-amber-500 mr-1'></i> Reminders:
                    </h2>
                    <p class="text-gray-800 text-sm sm:text-base lg:text-lg font-normal leading-relaxed sm:leading-loose">
                        Volunteers can only Clock In once and Clock Out once per program.<br>
                        Attendance will only be accessible once the program has started.<br>
                        After Clock In, Clock In button becomes disabled.<br>
                        After Clock Out, Clock Out button becomes disabled.
                    </p>
                </article>

                <article class="w-full lg:w-1/2">
                    <h2 class="text-gray-800 text-base sm:text-lg font-bold leading-relaxed sm:leading-loose flex items-center">
                        <i class='bx bx-error-circle text-amber-500 mr-1'></i> Missing Attendance:
                    </h2>
                    <p class="text-gray-800 text-sm sm:text-base lg:text-lg font-normal leading-relaxed sm:leading-loose">
                        If you missed Clocking In or Clocking Out, please contact your program coordinator.<br>
                        The coordinator can manually enter the missing attendance record for you.<br>
                        Be sure to provide a reason for the missed attendance when requesting manual entry.
                    </p>
                </article>
            </div>

            <p class="text-center text-gray-800 text-sm sm:text-base lg:text-lg leading-relaxed sm:leading-loose">
                <strong>Please be reminded that attendance is taken seriously.</strong>
                It serves as official documentation of your participation and will be used as one of the primary bases for
                recognizing your contribution to the program.
            </p>
            <p class="text-center text-gray-800 text-sm sm:text-base lg:text-lg leading-relaxed sm:leading-loose">
                <strong>Note:</strong> You must clock in first before you're allowed to upload attendance proof.
            </p>
        </section>
    </div>
@endsection
