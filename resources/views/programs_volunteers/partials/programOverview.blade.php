<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
    <x-overview.stat-card
        icon="bx-group"
        title="Total Volunteers"
        :value="$totalVolunteersCount"
        bgColor="bg-blue-50"
        iconColor="text-blue-500"
    />
    <x-overview.stat-card
        icon="bx-task"
        title="Active Tasks"
        :value="$activeTasksCount"
        bgColor="bg-yellow-50"
        iconColor="text-yellow-500"
    />
    <x-overview.stat-card
        icon="bx-check-circle"
        title="Completed Tasks"
        :value="$completedTasksCount"
        bgColor="bg-green-50"
        iconColor="text-green-500"
    />
    <x-overview.stat-card
        icon="bx-star"
        title="Average Rating"
        :value="number_format($averageRating, 1) . '/5'"
        bgColor="bg-purple-50"
        iconColor="text-purple-500"
    />
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-3 sm:gap-6">
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Attendance Overview</h3>
        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:space-y-4">
            <div class="bg-blue-50 p-2 sm:p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-xs sm:text-sm font-medium text-blue-800">Total Records</h4>
                        <p class="text-lg sm:text-2xl font-bold text-blue-900">
                            {{ $attendanceOverview['totalAttendanceRecords'] }}</p>
                    </div>
                    <div class="bg-blue-100 p-2 rounded-full">
                        <i class='bx bx-time text-lg sm:text-2xl text-blue-600'></i>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 p-2 sm:p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-xs sm:text-sm font-medium text-yellow-800">No Records</h4>
                        <p class="text-lg sm:text-2xl font-bold text-yellow-900">
                            {{ $attendanceOverview['noRecordsCount'] }}</p>
                        <p class="text-xs text-yellow-700">of {{ $attendanceOverview['totalVolunteers'] }}</p>
                    </div>
                    <div class="bg-yellow-100 p-2 rounded-full">
                        <i class='bx bx-user-x text-lg sm:text-2xl text-yellow-600'></i>
                    </div>
                </div>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Status Breakdown</h4>
                <div class="grid grid-cols-3 gap-2">
                    <div class="bg-green-50 p-2 rounded-lg">
                        <div class="flex items-center gap-1 mb-1">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <span class="text-xs text-gray-600">Approved</span>
                        </div>
                        <span
                            class="text-base font-semibold text-green-700">{{ $attendanceOverview['approvedCount'] }}</span>
                    </div>
                    <div class="bg-yellow-50 p-2 rounded-lg">
                        <div class="flex items-center gap-1 mb-1">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                            <span class="text-xs text-gray-600">Pending</span>
                        </div>
                        <span
                            class="text-base font-semibold text-yellow-700">{{ $attendanceOverview['pendingCount'] }}</span>
                    </div>
                    <div class="bg-red-50 p-2 rounded-lg">
                        <div class="flex items-center gap-1 mb-1">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            <span class="text-xs text-gray-600">Rejected</span>
                        </div>
                        <span
                            class="text-base font-semibold text-red-700">{{ $attendanceOverview['rejectedCount'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Recent Activity</h3>
        <div class="max-h-[300px] sm:max-h-[400px] overflow-y-auto pr-2">
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