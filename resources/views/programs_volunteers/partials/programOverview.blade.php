<x-overview.stat-card-group>
    <x-overview.stat-card
        icon="bx-group"
        title="Total Volunteers"
        :value="$totalVolunteersCount"
        bgColor="bg-blue-100"
        iconColor="text-purple-500"
        gradientVariant="blue-sky"
    />
    <x-overview.stat-card
        icon="bx-task"
        title="Active Tasks"
        :value="$activeTasksCount"
        bgColor="bg-yellow-100"
        iconColor="text-yellow-500"
        gradientVariant="sunset-orange"
    />
    <x-overview.stat-card
        icon="bx-check-circle"
        title="Completed Tasks"
        :value="$completedTasksCount"
        bgColor="bg-green-100"
        iconColor="text-green-500"
        gradientVariant="lime-green"
    />
    <x-overview.stat-card
        icon="bx-star"
        title="Average Rating"
        :value="number_format($averageRating, 1) . '/5'"
        bgColor="bg-purple-100"
        iconColor="text-purple-500"
        gradientVariant="violet-purple"
    />
</x-overview.stat-card-group>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-3 sm:gap-6">
    <x-overview.card title="Attendance Overview" icon="bx-time" variant="midnight-header">
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <x-overview.count-alert
                    :count="$attendanceOverview['totalAttendanceRecords']"
                    title="Total Records"
                    icon="bx-time"
                    type="primary"
                />
                
                <x-overview.count-alert
                    :count="$attendanceOverview['noRecordsCount']"
                    title="No Records"
                    icon="bx-user-x"
                    type="secondary"
                    :subtitle="'of ' . $attendanceOverview['totalVolunteers']"
                />
            </div>
            
            <div>
                <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-3">Status Breakdown</h4>
                <div class="grid grid-cols-3 gap-2">
                    <x-overview.count-alert
                        :count="$attendanceOverview['approvedCount']"
                        title="Approved"
                        icon="bx-check-circle"
                        type="success"
                    />
                    <x-overview.count-alert
                        :count="$attendanceOverview['pendingCount']"
                        title="Pending"
                        icon="bx-time-five"
                        type="warning"
                    />
                    <x-overview.count-alert
                        :count="$attendanceOverview['rejectedCount']"
                        title="Rejected"
                        icon="bx-x-circle"
                        type="error"
                    />
                </div>
            </div>
        </div>
    </x-overview.card>

     <x-overview.card title="Recent Activity" icon="bx-time" variant="midnight-header">
        <div class="overflow-y-auto pr-2">
            @forelse($recentActivities as $activity)
                <x-overview.summary-list-item>
                    <x-slot:title>{{ $activity['user']->name }}</x-slot:title>
                    <x-slot:subtitle>{{ $activity['message'] }}</x-slot:subtitle>
                    <x-slot:action>
                        <span class="text-xs sm:text-sm text-gray-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($activity['date'])->format('M d, Y') }}
                        </span>
                    </x-slot:action>
                </x-overview.summary-list-item>
            @empty
                <p class="text-gray-600 text-center py-4">No recent activity</p>
            @endforelse
        </div>
    </x-overview.card>
</div>

