@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-credit-card" title="Volunteer Attendance - Clock In / Clock Out"
        desc="View and manage the members membership type, status, and payment activity.">

        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
            {{-- Pag nag clock in, tsaka palang makakapag upload --}}
            @if($latestAttendance && $latestAttendance->clock_in)
                <x-button variant="secondary" class="w-full sm:w-auto"
                    onclick="document.getElementById('uploadProofModal').showModal();">
                    <i class='bx bx-upload mr-1'></i> Upload Proof
                </x-button>
            @endif
            {{-- Pag tapos complete attendance, tsaka palang makakapag rate and review --}}
            @if($latestAttendance && $latestAttendance->clock_in && $latestAttendance->clock_out)
                <x-button variant="secondary" class="w-full sm:w-auto"
                    onclick="document.getElementById('feedbackModal_{{ $program->id }}').showModal();">
                    <i class='bx bx-star mr-1'></i> Rate & Review
                </x-button>
            @endif
        </div>
    </x-page-header>

    @include('programs.modals.feedbackModal', ['program' => $program, 'userFeedback' => $userFeedback])
    @include('programs.modals.proofModal', ['program' => $program, 'volunteerAttendance' => $anyAttendance,])
    @include('programs.modals.attendanceStatusModal', ['attendance' => $latestAttendance])
    
    <div class="mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 items-start">
            <!-- Program Details -->
            <section class="col-span-1 lg:col-span-2 w-full p-6 sm:p-8 bg-slate-50 flex flex-col gap-6 rounded-2xl">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 mb-2">
                    <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="bx bx-calendar-event w-6 h-6 text-indigo-600"></i>
                        {{ $program->title }}
                    </h2>
                    <x-feedback-status.programProgress :program="$program" />
                </div>
                <hr class="border-t border-slate-200 mb-4" />
                <div class="space-y-2 mb-6">
                    <x-form.label class="text-slate-700 font-medium flex items-center gap-1">
                        <i class="bx bx-file-blank w-5 h-5 text-indigo-600 mr-1"></i>
                        Description
                    </x-form.label>
                    <p class="leading-relaxed text-slate-800 font-semibold">
                        {{ $program->description }}
                    </p>
                </div>
                <hr class="border-t border-slate-200 mb-4" />
                <div class="pt-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Date --}}
                    <div class="flex items-start gap-4">
                        <span class="flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl">
                            <i class="bx bx-calendar w-5 h-5"></i>
                        </span>
                        <div>
                            <x-form.label class="text-slate-700 font-medium mb-0" variant="date">Date</x-form.label>
                            <p class="text-slate-800 font-semibold">
                                {{ \Carbon\Carbon::parse($program->date)->format('F j, Y') }}
                            </p>
                        </div>
                    </div>
                    {{-- Time --}}
                    <div class="flex items-start gap-4">
                        <span class="flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl">
                            <i class="bx bx-time w-5 h-5"></i>
                        </span>
                        <div>
                            <x-form.label class="text-slate-700 font-medium mb-0" variant="time">Time</x-form.label>
                            <p class="text-slate-800 font-semibold">
                                {{ $program->end_time
                                    ? \Carbon\Carbon::parse($program->start_time)->format('g:ia') . ' - ' . \Carbon\Carbon::parse($program->end_time)->format('g:ia')
                                    : \Carbon\Carbon::parse($program->start_time)->format('g:ia') }}
                            </p>
                        </div>
                    </div>
                    {{-- Location --}}
                    <div class="flex items-start gap-4">
                        <span class="flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl">
                            <i class="bx bx-map w-5 h-5"></i>
                        </span>
                        <div>
                            <x-form.label class="text-slate-700 font-medium mb-0" variant="location">Location</x-form.label>
                            <p class="text-slate-800 font-semibold">{{ $program->location ?? 'N/A' }}</p>
                        </div>
                    </div>
                    {{-- Coordinator --}}
                    <div class="flex items-start gap-4">
                        <span class="flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl">
                            <i class="bx bx-user w-5 h-5"></i>
                        </span>
                        <div>
                            <x-form.label class="text-slate-700 font-medium mb-0" variant="coordinator">Coordinator</x-form.label>
                            <p class="text-slate-800 font-semibold">{{ $program->creator->name }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Right Column: Attendance and Attendance Summary -->
            <div class="col-span-1 flex flex-col gap-4">
                <!-- Attendance Card -->
                <div class="card bg-gradient-to-br from-gray-900 via-slate-800 to-indigo-900 rounded-2xl shadow-lg ring-1 ring-slate-100 outline outline-2 outline-offset-[-2px] outline-neutral-200 text-white">
                    <div class="card-body p-4 sm:p-6 space-y-3 sm:space-y-4">

                        <div class="mb-3">
                            <div class="flex items-center justify-between mb-1">
                                <h2 class="text-2xl font-bold text-white">
                                    Your Attendance
                                </h2>
                                <x-button variant="secondary" size="sm"
                                    onclick="document.getElementById('attendanceStatusModal').showModal();">
                                    <i class='bx bx-info-circle'></i>
                                </x-button>
                            </div>
                            <div class="flex items-center gap-2 mb-2">
                                @if($clockInTime && $clockOutTime && $program->progress_status === 'done')
                                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                    <span class="text-sm font-medium text-green-200">Complete</span>
                                @elseif($clockInTime && !$clockOutTime && $program->progress_status === 'done')
                                    <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                                    <span class="text-sm font-medium text-orange-200">Missed Clock Out</span>
                                @elseif(!$clockInTime && !$clockOutTime && $program->progress_status === 'done')
                                    <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                                    <span class="text-sm font-medium text-red-200">No Record</span>
                                @elseif($clockInTime)
                                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                                    <span class="text-sm font-medium text-blue-200">Clocked In</span>
                                @else
                                    <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                    <span class="text-sm font-medium text-white/80">Not Clocked In</span>
                                @endif
                            </div>
                        </div>

                        {{-- Time Information --}}
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center py-2 border-b border-white/10">
                                <span class="text-white/80">Time In</span>
                                <span class="font-medium text-white">
                                    {{ $clockInTime ? $clockInTime->format('g:ia') : '--:--' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-white/10">
                                <span class="text-white/80">Time Out</span>
                                <span class="font-medium text-white">
                                    {{ $clockOutTime ? $clockOutTime->format('g:ia') : '--:--' }}
                                </span>
                            </div>

                            @if($formattedWorkedTime)
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-white/80">Total Worked</span>
                                    <span class="font-medium text-[#ffb51b]">
                                        {{ $formattedWorkedTime }}
                                    </span>
                                </div>
                            @endif
                        </div>


                        @if($program->progress_status === 'incoming')
                            <x-feedback-status.alert 
                                variant="dark" 
                                icon="bx bx-info-circle" 
                                message="<strong>Program hasn't started yet.</strong><br>Available on {{ \Carbon\Carbon::parse($program->date)->format('F j, Y') }} at {{ \Carbon\Carbon::parse($program->start_time)->format('g:ia') }}" 
                            />

                            <x-button variant="disabled-dark" disabled>
                                <i class='bx bx-log-in-circle'></i> Clock In (Unavailable)
                            </x-button>

                            <x-button variant="disabled-dark" disabled>
                                <i class='bx bx-log-out-circle'></i> Clock Out (Unavailable)
                            </x-button>

                        @elseif($program->progress_status === 'done')
                            <x-feedback-status.alert 
                                variant="dark" 
                                icon="bx bx-check-circle" 
                                message="<strong>Program concluded.</strong><br>Attendance is no longer available." 
                            />

                            <x-button variant="disabled-dark" disabled>
                                <i class='bx bx-log-in-circle'></i> Clock In (Completed)
                            </x-button>

                            <x-button variant="disabled-dark" disabled>
                                <i class='bx bx-log-out-circle'></i> Clock Out (Completed)
                            </x-button>

                        @elseif($isJoined)
                            @if($canClockIn)
                                <div class="text-center">
                                    <form action="{{ route('programs.clock-in-out', $program) }}" method="POST" class="mt-3 sm:mt-4"
                                        onsubmit="this.querySelector('button').disabled = true; this.querySelector('button').innerHTML = '<i class=\'bx bx-loader-alt animate-spin\'></i> Processing...';">
                                        @csrf
                                        <x-button type="submit" variant="attendance-dark" class="w-full">
                                            <i class='bx bx-time-five mr-2'></i>
                                            Clock In
                                        </x-button>
                                    </form>
                                </div>

                                <x-button variant="disabled-dark" disabled>
                                    <i class='bx bx-log-out-circle'></i> Clock Out (Clock In First)
                                </x-button>

                            @elseif($canClockOut)
                                <x-button variant="disabled-dark" disabled>
                                    <i class='bx bx-log-in-circle'></i> Clock In (Already Clocked In)
                                </x-button>

                                <div class="text-center">
                                    <form action="{{ route('programs.clock-in-out', $program) }}" method="POST" class="mt-3 sm:mt-4"
                                        onsubmit="this.querySelector('button').disabled = true; this.querySelector('button').innerHTML = '<i class=\'bx bx-loader-alt animate-spin\'></i> Processing...';">
                                        @csrf
                                        <x-button type="submit" variant="attendance-dark" class="w-full">
                                            <i class='bx bx-time-five mr-2'></i>
                                            Clock Out
                                        </x-button>
                                    </form>
                                </div>

                            @else
                                <x-button variant="disabled-dark" disabled>
                                    <i class='bx bx-check-circle'></i> Clock In (Completed)
                                </x-button>
                                <x-button variant="disabled-dark" disabled>
                                    <i class='bx bx-check-circle'></i> Clock Out (Completed)
                                </x-button>
                            @endif

                        @else
                            <x-feedback-status.alert 
                                variant="dark" 
                                icon="bx bx-error-circle" 
                                message="You are not assigned to this program." 
                            />
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-slate-200 pt-8">
            @include('programs.partials.volunteerTasks')
        </div>
        <div class="mt-10">
            @include('programs.partials.attendanceReminders')
        </div>
    </div>

@endsection