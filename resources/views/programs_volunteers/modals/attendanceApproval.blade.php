<x-modal.dialog id="attendanceModal_{{ $volunteer->id }}" maxWidth="max-w-4xl" width="w-full" maxHeight="max-h-[90vh]">
    <!-- Modal Header -->
    <x-modal.header>
        <div>
            <h3 class="text-lg sm:text-xl font-semibold text-[#1a2235] flex items-center">
                <i class='bx bx-clipboard-check mr-2 text-[#ffb51b]'></i>
                Review Attendance
            </h3>
            <p class="text-sm text-gray-600 mt-1 flex items-center">
                <i class='bx bx-user mr-1'></i>
                {{ $volunteer->user->name }}
            </p>
        </div>
    </x-modal.header>

    <!-- Modal Body -->
    <x-modal.body>
        @forelse ($volunteerLogs as $log)
            @php
                $disabled = ($log->approval_status === 'approved' || $log->approval_status === 'rejected');
            @endphp

            <div class="mb-4 flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Attendance Approval Status:</span>
                <x-feedback-status.status-indicator :status="$log->approval_status ?? 'pending'" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <x-form.label variant="time-info">Time Information</x-form.label>
                        <div class="bg-gray-50 rounded-lg p-3 flex flex-col gap-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Time In</span>
                                <span class="font-medium text-[#1a2235]">
                                    {{ $log->clock_in ? \Carbon\Carbon::parse($log->clock_in)->format('h:i A') : '--:--' }}
                                </span>
                            </div>
                            <hr class="my-1 border-gray-200">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Time Out</span>
                                <span class="font-medium text-[#1a2235]">
                                    {{ $log->clock_out ? \Carbon\Carbon::parse($log->clock_out)->format('h:i A') : '--:--' }}
                                </span>
                            </div>
                            @if($log->clock_in && $log->clock_out)
                                <hr class="my-1 border-gray-200">
                                @php
                                    $clockIn = \Carbon\Carbon::parse($log->clock_in);
                                    $clockOut = \Carbon\Carbon::parse($log->clock_out);
                                    $duration = $clockIn->diff($clockOut);
                                    $hours = $duration->h + ($duration->days * 24);
                                    $minutes = $duration->i;
                                @endphp
                                <div class="flex justify-between items-center pt-1">
                                    <span class="text-sm text-gray-600">Duration</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                        {{ $hours > 0 ? $hours . ' hour' . ($hours > 1 ? 's' : '') : '' }}
                                        {{ $minutes > 0 ? $minutes . ' min' . ($minutes > 1 ? 's' : '') : '' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="space-y-4">
                    <div>
                        <x-form.label variant="assigned-tasks">Assigned Tasks</x-form.label>
                        @php
                            $volunteerTasks = $program->tasks()
                                ->whereHas('assignments', function ($query) use ($volunteer) {
                                    $query->where('volunteer_id', $volunteer->id);
                                })
                                ->with([
                                    'assignments' => function ($query) use ($volunteer) {
                                        $query->where('volunteer_id', $volunteer->id);
                                    }
                                ])
                                ->get();
                        @endphp

                        @if($volunteerTasks->isNotEmpty())
                            <div class="space-y-2 max-h-40 overflow-y-auto">
                                @foreach($volunteerTasks as $task)
                                    @php
                                        $assignment = $task->assignments->first();
                                        $taskStatusConfig = match ($assignment?->status ?? 'pending') {
                                            'completed' => ['bg-green-100', 'text-green-800', 'bx-check', 'Completed'],
                                            'in_progress' => ['bg-blue-100', 'text-blue-800', 'bx-time', 'In Progress'],
                                            default => ['bg-gray-100', 'text-gray-800', 'bx-hourglass', 'Pending'],
                                        };
                                    @endphp
                                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-start justify-between gap-2">
                                            <p class="text-sm text-gray-700 line-clamp-2 flex-1">
                                                {{ $task->task_description }}
                                            </p>
                                            <x-feedback-status.status-indicator :status="$assignment?->status ?? 'pending'" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <x-form.readonly>
                                <x-empty-state 
                                    icon="bx bx-task"
                                    title="No Tasks Assigned"
                                    description="No volunteers assigned to this task"
                                    size="small"
                                />
                            </x-form.readonly>
                        @endif
                    </div>
                </div>

            </div>
            
            <div class="mt-6">
                <div>
                    <x-form.label for="notes" variant="notes">Notes</x-form.label>
                    <x-form.readonly>
                        @if(empty($log->notes))
                            <x-empty-state 
                                icon="bx bx-message-square-dots"
                                title="No Notes"
                                description="No notes provided for this record."
                                size="small"
                            />
                        @else
                            {{ $log->notes }}
                        @endif
                    </x-form.readonly>
                </div>
            </div>

            <div class="mt-6">
                <x-form.label variant="attendance-proof">Attendance Proof</x-form.label>
                    @if ($log->proof_image)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <img src="{{ asset('storage/' . $log->proof_image) }}" alt="Proof of Attendance"
                            class="w-full max-w-sm rounded-lg border border-gray-300 mb-4 object-contain mx-auto" />
                            <div class="text-center">
                                <a href="{{ asset('storage/' . $log->proof_image) }}" target="_blank" 
                                    class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors duration-200">
                                    <i class='bx bx-fullscreen mr-1'></i> View Full Size
                                </a>
                            </div>
                        </div>
                    @else
                        <x-form.readonly>
                            <x-empty-state 
                                icon="bx bx-image"
                                title="No Proof"
                                description="No proof image uploaded"
                                size="small"
                            />
                        </x-form.readonly>
                    @endif
                </div>

            @if(!$disabled)
                <div class="flex flex-col sm:flex-row gap-2">
                    <form action="{{ route('attendance.status', $log->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <input type="hidden" name="notes" id="approve_notes_{{ $log->id }}">
                        <x-button variant="attendance-approve" type="submit"
                            onclick="document.getElementById('approve_notes_{{ $log->id }}').value = document.getElementById('notes_{{ $log->id }}').value">
                            <i class='bx bx-check-circle mr-2'></i> Approve Attendance
                        </x-button>
                    </form>

                    <form action="{{ route('attendance.status', $log->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <input type="hidden" name="notes" id="reject_notes_{{ $log->id }}">
                        <x-button variant="attendance-reject" type="submit"
                            onclick="document.getElementById('reject_notes_{{ $log->id }}').value = document.getElementById('notes_{{ $log->id }}').value">
                            <i class='bx bx-x-circle mr-2'></i> Reject Attendance
                        </x-button>
                    </form>
                </div>
            @else
                <x-feedback-status.alert 
                    class="items-center"
                    type="info"
                    icon="bx bx-lock-alt"
                    message="This attendance record has already been reviewed."
                    variant="attendance"
                />
            @endif
        @empty
            <x-empty-state 
                icon="bx bx-calendar-check"
                title="No Attendance Yet"
                description="This volunteer has not logged any attendance for this program."
            />
        @endforelse
    </x-modal.body>

    <x-modal.footer>
        <x-modal.close-button :modalId="'attendanceModal_' . $volunteer->id" text="Close" />
    </x-modal.footer>
</x-modal.dialog>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive modal adjustments */
    @media (max-width: 640px) {
        .modal-box {
            margin: 1rem;
            max-height: 90vh;
        }
    }

    /* Aspect ratio for images */
    .aspect-video {
        aspect-ratio: 16 / 9;
    }

    /* Custom scrollbar for tasks list */
    .max-h-40::-webkit-scrollbar {
        width: 4px;
    }

    .max-h-40::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 2px;
    }

    .max-h-40::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }

    .max-h-40::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>