@if($program->volunteers->isEmpty())
    <p class="text-gray-600 text-center py-4">No volunteers assigned to this program.</p>
@else
    <x-table.table tableClass="min-w-full bg-white" containerClass="overflow-hidden">
        <x-table.thead>
            <x-table.tr :hover="false">
                <x-table.th align="right">#</x-table.th>
                <x-table.th>Name</x-table.th>
                <x-table.th>Clock In</x-table.th>
                <x-table.th>Clock Out</x-table.th>
                <x-table.th>Total Time</x-table.th>
                <x-table.th>Action</x-table.th>
            </x-table.tr>
        </x-table.thead>
        <x-table.tbody>
            @foreach($program->volunteers as $volunteer)
                @if($volunteer->pivot->status == 'approved')
                    <x-table.tr>
                        <x-table.td align="right" class="text-gray-500">{{ $loop->iteration }}</x-table.td>
                        <x-table.td class="font-bold text-gray-800">
                            {{ $volunteer->user->name }}
                        </x-table.td>
                        <x-table.td>
                            @php
                                $volunteerLogs = $logs[$volunteer->id]['logs'] ?? collect();
                            @endphp
                            @if ($volunteerLogs->isEmpty())
                                <p class="text-gray-500">N/A</p>
                            @else
                                @foreach ($volunteerLogs as $log)
                                    <div>
                                        <span>
                                            @if ($log->clock_in)
                                                {{ \Carbon\Carbon::parse($log->clock_in)->format('h:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </x-table.td>
                        <x-table.td>
                            @if ($volunteerLogs->isEmpty())
                                <p class="text-gray-500">N/A</p>
                            @else
                                @foreach ($volunteerLogs as $log)
                                    <div>
                                        <span>
                                            @if ($log->clock_in)
                                                @if ($log->clock_out)
                                                    {{ \Carbon\Carbon::parse($log->clock_out)->format('h:i A') }}
                                                @else
                                                    <span class="text-red-500">Still Clocked In</span>
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            @endif
                        </x-table.td>
                        <x-table.td>
                            @if ($volunteerLogs->isEmpty())
                                <p class="text-gray-500">N/A</p>
                            @else
                                <p>{{ $logs[$volunteer->id]['totalTime'] ?? 'N/A' }}</p>
                            @endif
                        </x-table.td>
                        <x-table.td class="flex items-center gap-2">
                            @php
                                $hasLogs = !$volunteerLogs->isEmpty();
                                $allReviewed = $hasLogs && $volunteerLogs->every(fn($log) => in_array($log->approval_status, ['approved', 'rejected']));
                            @endphp
                            <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="table-action-view">
                                <i class='bx bx-show'></i>
                            </x-button>
                             @php
                                $hasLogs = !$volunteerLogs->isEmpty();
                                $hasClockOut = $hasLogs && $volunteerLogs->first()->clock_out;
                            @endphp
                            @if (!$hasLogs || ($hasLogs && !$hasClockOut))
                                <x-button variant="manual-entry"
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
                                <x-button variant="review-attendance"
                                    onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()">
                                    <i class='bx bx-show'></i> Review Attendance
                                </x-button>
                            @endif
                            @include('programs_volunteers.modals.attendanceApproval', ['volunteer' => $volunteer, 'volunteerLogs' => $volunteerLogs])
                        </x-table.td>
                    </x-table.tr>
                @endif
            @endforeach
        </x-table.tbody>
    </x-table.table>
@endif