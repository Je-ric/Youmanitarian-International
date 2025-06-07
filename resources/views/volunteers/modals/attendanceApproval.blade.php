<dialog id="attendanceModal_{{ $volunteer->id }}" class="modal">
    <form method="POST" action="#" class="modal-box max-w-3xl w-full p-0 rounded-lg bg-white relative" enctype="multipart/form-data">
        @csrf

        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <h3 class="text-gray-800 text-xl sm:text-2xl font-semibold">
                    Review Attendance
                </h3>
                <button type="button"
                    class="text-gray-400 hover:text-gray-600 transition-colors"
                    onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').close()">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <p class="text-gray-600 mt-2 flex items-center">
                <i class='bx bx-user mr-2'></i>
                <span class="font-medium">{{ $volunteer->user->name }}</span>
            </p>
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto">
            @forelse ($volunteerLogs as $log)
                @php
                    // If attendance is already approved or rejected, disable inputs.
                    $disabled = ($log->approval_status === 'approved' || $log->approval_status === 'rejected');
                    
                    // Status badge
                    $statusBadge = match($log->approval_status ?? 'pending') {
                        'approved' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="bx bx-check mr-1"></i>Approved</span>',
                        'rejected' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"><i class="bx bx-x mr-1"></i>Rejected</span>',
                        default => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"><i class="bx bx-time mr-1"></i>Pending</span>',
                    };
                @endphp

                <!-- Attendance Record -->
                <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                    <!-- Status Header -->
                    <div class="bg-gray-50 px-4 py-3 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-700">Status:</span>
                            {!! $statusBadge !!}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($log->created_at)->format('M j, Y') }}
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <!-- Two-column layout for time and image -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left column: Time info -->
                            <div class="space-y-4">
                                <!-- Clock In/Out Times -->
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <div class="w-24 flex-shrink-0 text-gray-500 text-sm">Time In:</div>
                                        <div class="font-medium">
                                            {{ $log->clock_in ? \Carbon\Carbon::parse($log->clock_in)->format('h:i A') : '--:--' }}
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-24 flex-shrink-0 text-gray-500 text-sm">Time Out:</div>
                                        <div class="font-medium">
                                            {{ $log->clock_out ? \Carbon\Carbon::parse($log->clock_out)->format('h:i A') : '--:--' }}
                                        </div>
                                    </div>
                                    
                                 @if($log->clock_in && $log->clock_out)
    @php
        $clockIn = \Carbon\Carbon::parse($log->clock_in);
        $clockOut = \Carbon\Carbon::parse($log->clock_out);
        $duration = $clockIn->diff($clockOut);
        $hours = $duration->h + ($duration->days * 24);
        $minutes = $duration->i;
        $seconds = $duration->s;
    @endphp
    <div class="flex items-center">
        <div class="w-24 flex-shrink-0 text-gray-500 text-sm">Duration:</div>
        <div class="font-medium">
            {{ $hours }}h {{ $minutes }}m {{ $seconds }}s
        </div>
    </div>
@endif

                                </div>

                                <!-- Notes -->
                                <div>
                                    <label for="notes_{{ $log->id }}" class="block text-gray-600 text-sm font-medium mb-1">
                                        Notes:
                                    </label>
                                    <textarea id="notes_{{ $log->id }}" name="notes" rows="3" @if($disabled) disabled @endif
                                        class="w-full p-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @if($disabled) bg-gray-50 text-gray-500 @endif"
                                        placeholder="Add any comments about this attendance record...">{{ old('notes', $log->notes) }}</textarea>
                                </div>
                            </div>
                            
                            <!-- Right column: Proof image -->
                            <div>
                                <div class="text-gray-600 text-sm font-medium mb-2">Attendance Proof:</div>
                                @if ($log->proof_image)
                                    <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                                        <div class="aspect-w-16 aspect-h-9 relative">
                                            <img src="{{ asset('storage/' . $log->proof_image) }}" alt="Proof of Attendance"
                                                class="object-contain w-full h-full" />
                                        </div>
                                        <div class="p-2 text-center">
                                            <a href="{{ asset('storage/' . $log->proof_image) }}" target="_blank" 
                                               class="text-blue-600 hover:text-blue-800 text-xs inline-flex items-center">
                                                <i class='bx bx-fullscreen mr-1'></i> View Full Size
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="border border-gray-200 rounded-lg bg-gray-50 p-8 flex flex-col items-center justify-center text-gray-400">
                                        <i class='bx bx-image text-4xl mb-2'></i>
                                        <p class="text-sm">No proof image uploaded</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row gap-2">
                        <button formaction="{{ route('attendance.approve', $log->id) }}" formmethod="POST" @if($disabled) disabled @endif
                            class="flex-1 flex items-center justify-center py-2 px-4 @if($disabled) bg-gray-100 text-gray-400 cursor-not-allowed @else bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 @endif rounded transition-colors">
                            <i class='bx bx-check-circle mr-2'></i> Approve
                        </button>
                        <button formaction="{{ route('attendance.reject', $log->id) }}" formmethod="POST" @if($disabled) disabled @endif
                            class="flex-1 flex items-center justify-center py-2 px-4 @if($disabled) bg-gray-100 text-gray-400 cursor-not-allowed @else bg-red-50 text-red-700 hover:bg-red-100 border border-red-200 @endif rounded transition-colors">
                            <i class='bx bx-x-circle mr-2'></i> Reject
                        </button>
                    </div>
                </div>
            @empty
                <!-- No Attendance Records -->
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                        <i class='bx bx-time text-3xl text-gray-400'></i>
                    </div>
                    <h4 class="text-lg font-medium text-gray-700 mb-2">No Attendance Records</h4>
                    <p class="text-gray-500 max-w-md">
                        This volunteer hasn't logged any attendance for this program yet. Records will appear here once they clock in.
                    </p>
                </div>
            @endforelse
        </div>
        
        <!-- Modal Footer -->
        <div class="p-4 border-t border-gray-100 flex justify-end">
            <button type="button" 
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition-colors"
                onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').close()">
                Close
            </button>
        </div>
    </form>
</dialog>
