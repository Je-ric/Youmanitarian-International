<!-- Program Statistics -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
    <!-- Total Volunteers -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-600">Total Volunteers</p>
                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $program->volunteers->count() }}</h3>
            </div>
            <div class="bg-blue-50 p-2 sm:p-3 rounded-full">
                <i class='bx bx-group text-xl sm:text-2xl text-blue-500'></i>
            </div>
        </div>
    </div>

    <!-- Active Tasks -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-600">Active Tasks</p>
                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $tasks->where('status', 'active')->count() }}</h3>
            </div>
            <div class="bg-yellow-50 p-2 sm:p-3 rounded-full">
                <i class='bx bx-task text-xl sm:text-2xl text-yellow-500'></i>
            </div>
        </div>
    </div>

    <!-- Completed Tasks -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-600">Completed Tasks</p>
                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $tasks->where('status', 'completed')->count() }}</h3>
            </div>
            <div class="bg-green-50 p-2 sm:p-3 rounded-full">
                <i class='bx bx-check-circle text-xl sm:text-2xl text-green-500'></i>
            </div>
        </div>
    </div>

    <!-- Average Rating -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-600">Average Rating</p>
                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ number_format($averageRating, 1) }}/5</h3>
            </div>
            <div class="bg-purple-50 p-2 sm:p-3 rounded-full">
                <i class='bx bx-star text-xl sm:text-2xl text-purple-500'></i>
            </div>
        </div>
    </div>
</div>

<!-- Program Details -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-3 sm:gap-6">
    <!-- Program Information -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Attendance Overview</h3>
        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:space-y-4">
            @php
                $totalVolunteers = $program->volunteers()->where('program_volunteers.status', 'approved')->count();
                $totalAttendanceRecords = 0;
                $approvedCount = 0;
                $pendingCount = 0;
                $rejectedCount = 0;
                $noRecordsCount = 0;

                foreach ($program->volunteers()->where('program_volunteers.status', 'approved')->get() as $volunteer) {
                    $attendanceRecords = $volunteer->attendanceLogs()->where('program_id', $program->id)->get();
                    if ($attendanceRecords->isEmpty()) {
                        $noRecordsCount++;
                    } else {
                        $totalAttendanceRecords += $attendanceRecords->count();
                        foreach ($attendanceRecords as $record) {
                            switch ($record->approval_status) {
                                case 'approved':
                                    $approvedCount++;
                                    break;
                                case 'pending':
                                    $pendingCount++;
                                    break;
                                case 'rejected':
                                    $rejectedCount++;
                                    break;
                            }
                        }
                    }
                }
            @endphp

            <!-- Total Attendance Records -->
            <div class="bg-blue-50 p-2 sm:p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-xs sm:text-sm font-medium text-blue-800">Total Records</h4>
                        <p class="text-lg sm:text-2xl font-bold text-blue-900">{{ $totalAttendanceRecords }}</p>
                    </div>
                    <div class="bg-blue-100 p-2 rounded-full">
                        <i class='bx bx-time text-lg sm:text-2xl text-blue-600'></i>
                    </div>
                </div>
            </div>

            <!-- Volunteers Without Records -->
            <div class="bg-yellow-50 p-2 sm:p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-xs sm:text-sm font-medium text-yellow-800">No Records</h4>
                        <p class="text-lg sm:text-2xl font-bold text-yellow-900">{{ $noRecordsCount }}</p>
                        <p class="text-xs text-yellow-700">of {{ $totalVolunteers }}</p>
                    </div>
                    <div class="bg-yellow-100 p-2 rounded-full">
                        <i class='bx bx-user-x text-lg sm:text-2xl text-yellow-600'></i>
                    </div>
                </div>
            </div>

            <!-- Approval Status Breakdown -->
            <div class="col-span-2 sm:col-span-1">
                <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Status Breakdown</h4>
                <div class="grid grid-cols-3 gap-2">
                    <!-- Approved -->
                    <div class="bg-green-50 p-2 rounded-lg">
                        <div class="flex items-center gap-1 mb-1">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <span class="text-xs text-gray-600">Approved</span>
                        </div>
                        <span class="text-base font-semibold text-green-700">{{ $approvedCount }}</span>
                    </div>
                    <!-- Pending -->
                    <div class="bg-yellow-50 p-2 rounded-lg">
                        <div class="flex items-center gap-1 mb-1">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            <span class="text-xs text-gray-600">Pending</span>
                        </div>
                        <span class="text-base font-semibold text-yellow-700">{{ $pendingCount }}</span>
                    </div>
                    <!-- Rejected -->
                    <div class="bg-red-50 p-2 rounded-lg">
                        <div class="flex items-center gap-1 mb-1">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            <span class="text-xs text-gray-600">Rejected</span>
                        </div>
                        <span class="text-base font-semibold text-red-700">{{ $rejectedCount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Recent Activity</h3>
        <div class="max-h-[300px] sm:max-h-[400px] overflow-y-auto pr-2">
            @php
                $recentActivities = $program->volunteers()
                    ->where('program_volunteers.status', 'approved')
                    ->orderBy('program_volunteers.created_at', 'desc')
                    ->get()
                    ->map(function($volunteer) {
                        return [
                            'user' => $volunteer->user,
                            'date' => $volunteer->pivot->created_at,
                            'message' => 'joined the program'
                        ];
                    });
            @endphp

            @forelse($recentActivities as $activity)
                <div class="flex items-center justify-between border-b pb-2 sm:pb-3 last:border-0">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class='bx bx-user text-lg sm:text-xl text-gray-500'></i>
                        </div>
                        <div>
                            <p class="text-sm sm:text-base font-medium text-[#1a2235]">{{ $activity['user']->name }}</p>
                            <p class="text-xs sm:text-sm text-gray-600">{{ $activity['message'] }}</p>
                        </div>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($activity['date'])->format('M d, Y h:i A') }}
                    </span>
                </div>
            @empty
                <p class="text-gray-600 text-center py-4">No recent activity</p>
            @endforelse
        </div>
    </div>
</div> 