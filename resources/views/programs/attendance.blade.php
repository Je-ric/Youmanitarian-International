@extends('layouts.sidebar_final')

@php
    $volunteerId = auth()->user()?->volunteer?->id;

    $volunteerAttendance = \App\Models\VolunteerAttendance::where('program_id', $program->id)
        ->where('volunteer_id', $volunteerId)
        ->first();

    $proofPath = $volunteerAttendance?->proof_image;
@endphp

@section('content')

    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif

    <div class="container mx-auto px-4 sm:px-6 py-4 sm:py-6">

        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                        Volunteer Attendance - Clock In / Clock Out
                    </h1>
                </div>
                <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                    {{-- Pag nag clock in, tsaka palang makakapag upload --}}
                    @if($attendance && $attendance->clock_in)
                        <x-button variant="secondary" class="w-full sm:w-auto"
                            onclick="document.getElementById('uploadProofModal').showModal();">
                            <i class='bx bx-upload mr-1'></i> Upload Proof
                        </x-button>
                    @endif
                    {{-- Pag tapos complete attendance, tsaka palang makakapag rate and review --}}
                    @if($attendance && $attendance->clock_in && $attendance->clock_out)
                        <x-button variant="secondary" class="w-full sm:w-auto"
                            onclick="document.getElementById('feedbackModal_{{ $program->id }}').showModal();">
                            <i class='bx bx-star mr-1'></i> Rate & Review
                        </x-button>
                    @endif
                </div>
            </div>
        </div>

        @include('programs.modals.feedbackModal', ['program' => $program, 'userFeedback' => $program->userFeedback])
        @include('programs.modals.proofModal', ['program' => $program, 'volunteerAttendance' => $volunteerAttendance,])

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">

            <section
                class="col-span-1 lg:col-span-2 w-full p-4 sm:p-5 bg-neutral-50 rounded-2xl outline outline-2 outline-offset-[-2px] outline-neutral-200 flex flex-col gap-4 sm:gap-7">

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-800 leading-tight sm:leading-[50px] tracking-tight">
                        {{ $program->title }}
                    </h2>
                    {{-- component --}}
                    <x-programProgress :program="$program" />
                </div>

                <!-- Description -->
                <section>
                    <h3 class="text-black text-base font-medium tracking-tight mb-1">
                        Description
                    </h3>
                    <p
                        class="text-gray-800 text-xs sm:text-base font-normal leading-relaxed sm:leading-loose text-justify indent-6">
                        {{ $program->description }}
                    </p>

                </section>

                <section class="flex flex-col gap-3 sm:gap-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-x-8 gap-y-4">
                        <!-- Date -->
                        <div class="flex items-center gap-2 min-w-[16rem]">
                            <i class='bx bx-calendar text-lg text-gray-700'></i>
                            <strong class="text-black text-sm sm:text-base font-medium tracking-tight">Date:</strong>
                            <span class="text-black text-sm sm:text-base font-normal tracking-tight">
                                {{ \Carbon\Carbon::parse($program->date)->format('F j, Y') }}
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

                        <!-- Time -->
                        <div class="flex items-center gap-2 min-w-[16rem]">
                            <i class='bx bx-time text-lg text-gray-700'></i>
                            <strong class="text-black text-sm sm:text-base font-medium tracking-tight">Time:</strong>
                            <span class="text-black text-sm sm:text-base font-normal tracking-tight">
                                {{ $program->end_time
        ? \Carbon\Carbon::parse($program->start_time)->format('g:ia') . ' - ' . \Carbon\Carbon::parse($program->end_time)->format('g:ia')
        : \Carbon\Carbon::parse($program->start_time)->format('g:ia') }}
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

            <div
                class="col-span-1 card bg-base-100 bg-neutral-50 rounded-2xl outline outline-2 outline-offset-[-2px] outline-neutral-200">
                <div class="card-body p-4 sm:p-6 space-y-3 sm:space-y-4">
                    
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-[#1a2235] mb-2">
                            Your Attendance
                        </h2>

                        <!-- Status Indicator -->
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-sm text-gray-600">Status:</span>
                            <div class="flex items-center gap-2">
                                @if($clockInTime && $clockOutTime && $status === 'done')
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm font-medium text-green-700">Complete</span>
                                @elseif($clockInTime && !$clockOutTime && $status === 'done')
                                    <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                                    <span class="text-sm font-medium text-orange-700">Missed Clock Out</span>
                                @elseif(!$clockInTime && !$clockOutTime && $status === 'done')
                                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                    <span class="text-sm font-medium text-red-700">No Record</span>
                                @elseif($clockInTime)
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span class="text-sm font-medium text-blue-700">Clocked In</span>
                                @else
                                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-600">Not Started</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Time Information -->
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Time In</span>
                            <span class="font-medium text-[#1a2235]">
                                {{ $clockInTime ? $clockInTime->format('g:ia') : '--:--' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Time Out</span>
                            <span class="font-medium text-[#1a2235]">
                                {{ $clockOutTime ? $clockOutTime->format('g:ia') : '--:--' }}
                            </span>
                        </div>

                        @if($formattedWorkedTime)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">Total Worked</span>
                                <span class="font-medium text-[#ffb51b]">
                                    {{ $formattedWorkedTime }}
                                </span>
                            </div>
                        @endif
                    </div>
                    

                    @if($status === 'upcoming')
                        <div class="alert alert-warning mt-3 sm:mt-4 text-xs sm:text-sm">
                            <i class='bx bx-calendar-exclamation'></i>
                            <span>
                                This program hasn't started yet. Clock-in will be available on
                                <strong>{{ \Carbon\Carbon::parse($program->start_date)->format('F j, Y') }}</strong> at
                                <strong>{{ \Carbon\Carbon::parse($program->start_time)->format('g:ia') }}</strong>.
                            </span>
                        </div>

                        <x-button variant="disabled" disabled>
                            <i class='bx bx-log-in-circle'></i> Clock In (Unavailable)
                        </x-button>

                        <x-button variant="disabled" disabled>
                            <i class='bx bx-log-out-circle'></i> Clock Out (Unavailable)
                        </x-button>

                    @elseif($status === 'done')
                        <div class="alert alert-warning mt-3 sm:mt-4 text-xs sm:text-sm">
                            <i class='bx bx-calendar-exclamation'></i>
                            <span>This program concluded on
                                <strong>{{ $program->date->format('F j, Y') }}</strong>. Attendance is no longer
                                available.</span>
                        </div>

                        <x-button variant="disabled" disabled>
                            <i class='bx bx-log-in-circle'></i> Clock In (Completed)
                        </x-button>

                        <x-button variant="disabled" disabled>
                            <i class='bx bx-log-out-circle'></i> Clock Out (Completed)
                        </x-button>

                    @elseif($isAssigned)
                        @if($canClockIn)
                            <form action="{{ route('programs.clock-in', $program) }}" method="POST" class="mt-3 sm:mt-4">
                                @csrf
                                <x-button type="submit" variant="clock_in">
                                    <i class='bx bx-log-in-circle'></i> Clock In
                                </x-button>
                            </form>

                            <x-button variant="disabled" disabled>
                                <i class='bx bx-log-out-circle'></i> Clock Out (Clock In First)
                            </x-button>

                        @elseif($canClockOut)
                            <form action="{{ route('programs.clock-out', $program) }}" method="POST" class="mt-3 sm:mt-4">
                                @csrf
                                <x-button type="submit" variant="clock_in" class="w-full text-sm sm:text-base">
                                    <i class='bx bx-log-out-circle'></i> Clock Out
                                </x-button>
                            </form>

                            <x-button variant="disabled" disabled>
                                <i class='bx bx-check-circle'></i> Clock In (Already Done)
                            </x-button>

                        @else
                            <x-button variant="disabled" disabled>
                                <i class='bx bx-check-circle'></i> Clock In (Completed)
                            </x-button>
                            <x-button variant="disabled" disabled>
                                <i class='bx bx-check-circle'></i> Clock Out (Completed)
                            </x-button>
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

        {{-- Partial --}}
        @include('programs.partials.attendanceReminders')

    </div>

@endsection