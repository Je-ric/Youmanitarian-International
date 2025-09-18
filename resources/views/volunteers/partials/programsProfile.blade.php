<div class="p-6">
    <h1 class="text-2xl font-bold text-[#1a2235] mb-6">Programs & Attendance</h1>
    @if ($volunteer->programs->isNotEmpty())

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($volunteer->programs as $program)
                @php
                    $attendance = $volunteer->attendanceLogs->where('program_id', $program->id)->first();
                    $hasAttendance = $attendance !== null;
                @endphp

                <div class="bg-gradient-to-br from-white to-slate-50 border border-gray-200 rounded-xl p-5 hover:shadow-lg transition-all duration-200">

                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-[#1a2235] truncate">
                                {{ $program->title }}
                            </h3>

                            <div class="flex items-center gap-2 mt-1">
                                <x-feedback-status.programProgress :program="$program" />
                                @if($hasAttendance)
                                    <x-feedback-status.status-indicator
                                        :status="$attendance->approval_status"
                                        :label="ucfirst($attendance->approval_status)" />
                                @else
                                    <x-feedback-status.status-indicator
                                        status="warning"
                                        label="No Attendance" />
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 mb-4">

                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm font-medium text-gray-600">Date</span>
                            <span class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($program->date)->format('M d, Y') }}</span>
                        </div>
                        @if($hasAttendance)

                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Time In/Out</span>
                                <span class="text-sm text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}
                                    @if ($attendance->clock_out)
                                        - {{ \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A') }}
                                    @else
                                        - <span class="text-amber-600">Still Clocked In</span>
                                    @endif
                                </span>
                            </div>

                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Hours Logged</span>
                                @if ($attendance->clock_out)
                                    @php
                                        $hours = (float) ($attendance->hours_logged ?? 0);
                                        $whole = floor($hours);
                                        $mins = round(($hours - $whole) * 60);
                                    @endphp
                                    <span class="text-sm font-bold text-[#1a2235]">{{ $whole }}h {{ $mins }}m</span>
                                @else
                                    <span class="text-sm text-amber-600 font-medium">Ongoing</span>
                                @endif
                            </div>
                        @else
                            <x-feedback-status.alert
                                variant="warning"
                                icon="bx bx-time"
                                message="No attendance record yet"
                            />
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <button
                            @click="openModal({{ $program->id }})"
                            class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class='bx bx-show mr-1'></i>
                            View Details
                        </button>
                        @if($hasAttendance)
                            {{-- Review Button - Only if attendance exists --}}
                            <button
                                onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}_{{ $program->id }}').showModal()"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class='bx bx-clipboard-check mr-1'></i>
                                Review
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <x-feedback-status.alert
            variant="info"
            icon="bx bx-calendar"
            message="This volunteer hasn't joined any programs yet."
        />
    @endif
</div>

@foreach ($volunteer->programs as $program)
    @include('programs.modals.program-modal', ['program' => $program])
@endforeach

{{-- Attendance Approval Modals - Review for attendance records --}}
@foreach ($volunteer->attendanceLogs as $log)
    @if($log->program)
        @php
            $programLogs = $volunteer->attendanceLogs->where('program_id', $log->program->id);
        @endphp
        @include('programs_volunteers.modals.attendanceApproval', [
            'volunteer' => $volunteer,
            'volunteerLogs' => $programLogs,
            'program' => $log->program,
            'readOnly' => true,
            'modalId' => 'attendanceModal_' . $volunteer->id . '_' . $log->program->id
        ])
    @endif
@endforeach
