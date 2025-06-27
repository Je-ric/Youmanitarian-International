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
        <div class="p-4 sm:p-6 max-h-[75vh] overflow-y-auto">
            @forelse ($volunteerLogs as $log)
                @php
                    $disabled = ($log->approval_status === 'approved' || $log->approval_status === 'rejected');
                @endphp

                <!-- Attendance Record Card -->
                <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden bg-white">

                    <!-- Card Header -->
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-700">Status:</span>
                                <x-feedback-status.status-indicator :status="$log->approval_status ?? 'pending'" />
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($log->created_at)->format('M j, Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <x-label><i class='bx bx-time mr-1 text-yellow-500'></i>Time Information</x-label>
                                    <div class="space-y-2 bg-gray-50 rounded-lg p-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600"><i class='bx bx-time-five mr-1 text-green-600'></i>Time In:</span>
                                            <span class="font-medium text-[#1a2235]">
                                                {{ $log->clock_in ? \Carbon\Carbon::parse($log->clock_in)->format('h:i A') : '--:--' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600"><i class='bx bx-time-five mr-1 text-red-600'></i>Time Out:</span>
                                            <span class="font-medium text-[#1a2235]">
                                                {{ $log->clock_out ? \Carbon\Carbon::parse($log->clock_out)->format('h:i A') : '--:--' }}
                                            </span>
                                        </div>

                                        @if($log->clock_in && $log->clock_out)
                                            @php
                                                $clockIn = \Carbon\Carbon::parse($log->clock_in);
                                                $clockOut = \Carbon\Carbon::parse($log->clock_out);
                                                $duration = $clockIn->diff($clockOut);
                                                $hours = $duration->h + ($duration->days * 24);
                                                $minutes = $duration->i;
                                            @endphp
                                            <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                                <span class="text-sm text-gray-600">Duration:</span>
                                                <span class="font-medium text-[#ffb51b]">
                                                    {{ $hours }}h {{ $minutes }}m
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <x-form.textarea
                                        id="notes_{{ $log->id }}"
                                        name="notes"
                                        :value="old('notes', $log->notes)"
                                        :disabled="$disabled"
                                        label="Notes"
                                        placeholder="Add any comments about this attendance record..."
                                        rows="3"
                                    />
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <x-label><i class='bx bx-image mr-1 text-orange-600'></i>Attendance Proof</x-label>
                                    @if ($log->proof_image)
                                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                                            <div class="aspect-video relative">
                                                <img src="{{ asset('storage/' . $log->proof_image) }}" alt="Proof of Attendance"
                                                    class="object-contain w-full h-full" />
                                            </div>
                                            <div class="p-2 text-center bg-white">
                                                <a href="{{ asset('storage/' . $log->proof_image) }}" target="_blank"
                                                    class="text-blue-600 hover:text-blue-800 text-xs inline-flex items-center font-medium">
                                                    <i class='bx bx-fullscreen mr-1'></i> View Full Size
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="border border-gray-200 rounded-lg bg-gray-50 p-6 flex flex-col items-center justify-center text-gray-400">
                                            <i class='bx bx-image text-3xl mb-2'></i>
                                            <p class="text-sm">No proof image uploaded</p>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <x-label><i class='bx bx-task mr-1 text-blue-600'></i>Assigned Tasks</x-label>
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
                                        <div
                                            class="border border-gray-200 rounded-lg bg-gray-50 p-4 flex items-center justify-center text-gray-400">
                                            <i class='bx bx-task text-xl mr-2'></i>
                                            <p class="text-sm">No tasks assigned</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if(!$disabled)
                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
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
                        </div>
                    @else
                        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                            <div class="text-center text-sm text-gray-600">
                                <i class='bx bx-lock-alt mr-1'></i>
                                This attendance record has already been reviewed
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class='bx bx-time text-2xl text-gray-400'></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">No Attendance Records</h4>
                    <p class="text-gray-500 max-w-sm text-sm leading-relaxed">
                        This volunteer hasn't logged any attendance for this program yet. Records will appear here once they
                        clock in.
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Modal Footer -->
        <x-modal.footer>
            <x-modal.close-button :modalId="'attendanceModal_' . $volunteer->id" text="Close" />
        </x-modal.footer>
</x-modal.dialog>

<style>
    /* Line clamp utility for task descriptions */
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