@if($program->volunteers->isEmpty())
    <p class="text-gray-600 text-center py-4">No volunteers assigned to this program.</p>
@else
    <table class="min-w-full bg-white overflow-hidden border border-gray-200">
        <thead class="bg-[#1a2235] text-white">
            <tr>
                <th class="p-4 text-left text-sm font-medium">#</th>
                <th class="p-4 text-left text-sm font-medium">Name</th>
                <th class="p-4 text-left text-sm font-medium">Clock In</th>
                <th class="p-4 text-left text-sm font-medium">Clock Out</th>
                <th class="p-4 text-left text-sm font-medium">Total Time</th>
                <th class="p-4 text-left text-sm font-medium">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($program->volunteers as $volunteer)
                @if($volunteer->pivot->status == 'approved')
                    <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                        <td class="p-4">{{ $loop->iteration }}</td>
                        <td class="p-4 text-sm text-[#1a2235] font-semibold">
                            {{ $volunteer->user->name }}
                            {{-- <span class="text-gray-500">({{ $volunteer->user->email }})</span> --}}
                        </td>
                        <td class="p-4 text-sm">
                            @php
                                $volunteerLogs = $logs[$volunteer->id]['logs'] ?? collect();
                            @endphp
                            @if ($volunteerLogs->isEmpty())
                                <p class="text-gray-500">N/A</p>
                            @else
                                @foreach ($volunteerLogs as $log)
                                    <div class="flex gap-2">
                                        <span class="text-sm text-gray-600">
                                            {{-- {{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }} --}}
                                            {{ \Carbon\Carbon::parse($log->clock_in)->format('h:i A') }}
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td class="p-4 text-sm">
                            @if ($volunteerLogs->isEmpty())
                                <p class="text-gray-500">N/A</p>
                            @else
                                @foreach ($volunteerLogs as $log)
                                    <div class="flex gap-2">
                                        <span class="text-sm text-gray-600">
                                            @if ($log->clock_out)
                                                {{-- {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }} --}}
                                                    {{ \Carbon\Carbon::parse($log->clock_out)->format('h:i A') }}
                                                @else
                                                <span class="text-red-500">Still Clocked In</span>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td class="p-4 text-sm">
                            @if ($volunteerLogs->isEmpty())
                                <p class="text-gray-500">N/A</p>
                            @else
                                <p class="text-gray-600">{{ $logs[$volunteer->id]['totalTime'] ?? 'N/A' }}</p>
                            @endif
                        </td>
                        <td class="p-4 flex items-center gap-2">
                            @php
                                $hasLogs = !$volunteerLogs->isEmpty();
                                $allReviewed = $hasLogs && $volunteerLogs->every(fn($log) => in_array($log->approval_status, ['approved', 'rejected']));
                            @endphp
                            <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info">
                                <i class='bx bx-show'></i> View
                            </x-button>
                             @php
                                $hasLogs = !$volunteerLogs->isEmpty();
                                $hasClockOut = $hasLogs && $volunteerLogs->first()->clock_out;
                            @endphp
                            @if (!$hasLogs || ($hasLogs && !$hasClockOut))
                                <x-button variant="warning"
                                    onclick="document.getElementById('manualAttendanceModal_{{ $volunteer->id }}').showModal()">
                                    <i class='bx bx-edit'></i> Manual Entry
                                </x-button>
                                @php
                                $attendance = \App\Models\VolunteerAttendance::where('volunteer_id', $volunteer->id)
                                    ->where('program_id', $program->id)
                                    ->first();
                            @endphp

                            @include('programs_volunteers.modals.manualAttendanceModal', [
                                'program' => $program,
                                'selectedVolunteer' => $volunteer,
                                'attendance' => $attendance
                            ])
                            @endif
                            @if ($allReviewed)
                                <x-button variant="reviewed"
                                    title="Attendance already reviewed"
                                    onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()">
                                    <i class='bx bx-check-double'></i> Reviewed
                                </x-button>
                            @else
                                <x-button variant="info"
                                    onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()">
                                    <i class='bx bx-show'></i> Review Attendance
                                </x-button>
                            @endif
                            @include('programs_volunteers.modals.attendanceApproval', ['volunteer' => $volunteer, 'volunteerLogs' => $volunteerLogs])
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endif