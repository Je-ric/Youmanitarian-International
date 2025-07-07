@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-credit-card" title="Volunteer Attendance - Clock In / Clock Out"
        desc="View and manage the members membership type, status, and payment activity.">

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
    </x-page-header>

    @include('programs.modals.feedbackModal', ['program' => $program, 'userFeedback' => $userFeedback])
    @include('programs.modals.proofModal', ['program' => $program, 'volunteerAttendance' => $volunteerAttendance,])

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">

            <section
                class="bg-white border-2 border-gray-200 col-span-1 lg:col-span-2 w-full p-4 sm:p-5 bg-neutral-50 rounded-2xl outline outline-2 outline-offset-[-2px] outline-neutral-200 flex flex-col gap-4 sm:gap-7">

                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-3 pb-3 border-b border-gray-100">
                    <h2 class="text-xl lg:text-2xl font-bold text-[#1a2235]">
                        {{ $program->title }}
                    </h2>
                    <x-feedback-status.programProgress :program="$program" />
                </div>

                {{-- Description --}}
                <div class="mb-8">
                    <h3 class="text-[#1a2235] font-semibold mb-3 flex items-center">
                        <i class='bx bx-file-blank mr-2 text-lg'></i>
                        Description
                    </h3>
                    <p class="text-gray-700 leading-relaxed text-justify">
                        {{ $program->description }}
                    </p>
                </div>

                {{-- Program Details Grid --}}
                <div class="space-y-4">
                    <h3 class="text-[#1a2235] font-semibold mb-4 flex items-center">
                        <i class='bx bx-info-circle mr-2 text-lg'></i>
                        Program Details
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Date --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-calendar text-[#1a2235]'></i>
                            </div>
                            <div>
                                <div class="font-medium text-[#1a2235] text-sm">Date</div>
                                <div class="text-gray-700">
                                    {{ \Carbon\Carbon::parse($program->date)->format('F j, Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- Time --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-time text-[#1a2235]'></i>
                            </div>
                            <div>
                                <div class="font-medium text-[#1a2235] text-sm">Time</div>
                                <div class="text-gray-700">
                                    {{ $program->end_time
        ? \Carbon\Carbon::parse($program->start_time)->format('g:ia') . ' - ' . \Carbon\Carbon::parse($program->end_time)->format('g:ia')
        : \Carbon\Carbon::parse($program->start_time)->format('g:ia') }}
                                </div>
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-map text-[#1a2235]'></i>
                            </div>
                            <div>
                                <div class="font-medium text-[#1a2235] text-sm">Location</div>
                                <div class="text-gray-700">
                                    {{ $program->location ?? 'N/A' }}
                                </div>
                            </div>
                        </div>

                        {{-- Coordinator --}}
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-user text-[#1a2235]'></i>
                            </div>
                            <div>
                                <div class="font-medium text-[#1a2235] text-sm">Coordinator</div>
                                <div class="text-gray-700">
                                    {{ $program->creator->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <div
                class="col-span-1 card bg-gradient-to-br from-gray-900 via-slate-800 to-indigo-900 rounded-2xl outline outline-2 outline-offset-[-2px] outline-neutral-200 text-white">
                <div class="card-body p-4 sm:p-6 space-y-3 sm:space-y-4">

                    <div class="mb-3">
                        <h2 class="text-xl font-bold text-white mb-2">
                            Your Attendance
                        </h2>

                        {{-- Status Indicator --}}
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-sm text-white/80">Attendance:</span>
                            <div class="flex items-center gap-2">
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

        {{-- Lower grid: Assigned Tasks (left) and Attendance Summary (right) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mt-8">
            {{-- Assigned Tasks (Card 3) --}}
            <div class="h-full flex flex-col">
            <h2 class="text-xl font-bold text-[#1a2235] mb-4">Your Assigned Tasks</h2>
            @if($volunteerTasks->isNotEmpty())
                    <div class="flex flex-col lg:flex-row gap-4 flex-1">
                    @foreach($taskData as $data)
                            <div class="bg-white border border-gray-200 rounded-lg hover:border-gray-300 transition-all duration-200 hover:shadow-sm flex-1 flex flex-col">
                                <div class="p-4 flex-1 flex flex-col">
                                <div class="flex items-center justify-between mb-3">
                                    <x-feedback-status.status-indicator :status="$data['assignment']->status"
                                        :label="ucwords(str_replace('_', ' ', $data['assignment']->status))" />
                                </div>
                                    <p class="text-gray-700 text-sm mb-4 flex-1">{{ $data['task']->task_description }}</p>
                                <form
                                    action="{{ route('programs.tasks.assignments.update-status', [$program, $data['task'], $data['assignment']]) }}"
                                    method="POST" class="inline-flex w-full">
                                    @csrf
                                    @method('PUT')
                                    <div class="w-full">
                                        <select name="status" onchange="this.form.submit()"
                                            class="w-full text-sm border border-gray-300 rounded px-3 py-2 focus:ring-1 focus:ring-[#ffb51b] focus:border-[#ffb51b] bg-white"
                                            @if($data['assignment']->status === 'completed') disabled @endif>
                                            <option value="pending" {{ $data['assignment']->status === 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="in_progress" {{ $data['assignment']->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $data['assignment']->status === 'completed' ? 'selected' : '' }} disabled>Completed (Program Coordinator Only)</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Note: Only program coordinators can mark tasks as
                                            complete</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state icon="bx bx-task" title="No Tasks Assigned"
                    description="You have not been assigned any tasks for this program yet. Please check back later." />
                @endif
            </div>

            {{-- Attendance Summary (Card 4) --}}
            @if($attendance && ($attendance->clock_in || $attendance->clock_out))
                <div class="h-full flex flex-col">
                    <div class="bg-white border-2 border-gray-200 rounded-2xl p-4 sm:p-5 flex-1 flex flex-col">
                        <h3 class="text-lg font-semibold text-[#1a2235] mb-4 pb-3 border-b border-gray-200">Attendance Summary</h3>
                        <div class="space-y-4 flex-1">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 font-medium">Approval Status</span>
                                @if($attendance->approval_status == 'approved')
                                    <span
                                        class="font-medium text-green-600 bg-green-100 px-3 py-1 rounded-full text-sm inline-flex items-center gap-1">
                                        <i class='bx bx-check-circle'></i>
                                        {{ ucfirst($attendance->approval_status) }}
                                    </span>
                                @elseif($attendance->approval_status == 'rejected')
                                    <span
                                        class="font-medium text-red-600 bg-red-100 px-3 py-1 rounded-full text-sm inline-flex items-center gap-1">
                                        <i class='bx bx-x-circle'></i>
                                        {{ ucfirst($attendance->approval_status) }}
                                    </span>
                                @else
                                    <span
                                        class="font-medium text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full text-sm inline-flex items-center gap-1">
                                        <i class='bx bx-time-five'></i>
                                        {{ ucfirst($attendance->approval_status) }}
                                    </span>
                                @endif
                            </div>
                            @if($attendance->approved_by)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 font-medium">
                                        {{ ucfirst($attendance->approval_status) }} by
                                    </span>
                                    <span class="font-semibold text-[#1a2235]">
                                        {{ $attendance->approver->name ?? 'N/A' }}
                                    </span>
                                </div>
                            @endif
                            @if($attendance->notes)
                                <div>
                                    <span class="text-gray-600 font-medium">Notes / Reason</span>
                                    <p class="text-gray-800 bg-gray-50 p-3 rounded-lg mt-2 text-sm border border-gray-200">
                                        {{ $attendance->notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-- Partial --}}
        @include('programs.partials.attendanceReminders')
    </div>

@endsection