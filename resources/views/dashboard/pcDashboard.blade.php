<!-- Program Coordinator Dashboard -->
<div class="bg-gray-50 min-h-screen">
    <!-- Programs (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-calendar" title="My Programs" :value="number_format($data['myPrograms'] ?? 0)" gradientVariant="brand" />
        <x-overview.stat-card icon="bx-play-circle" title="Ongoing" :value="number_format($data['ongoing'] ?? 0)" gradientVariant="forest" />
        <x-overview.stat-card icon="bx-calendar-plus" title="Upcoming" :value="number_format($data['upcoming'] ?? 0)" gradientVariant="amber-orange" />
        <x-overview.stat-card icon="bx-check-circle" title="Completed" :value="number_format($data['completed'] ?? 0)" gradientVariant="blue-sky" />
    </x-overview.stat-card-group>

    <!-- People & Tasks (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-user-check" title="Volunteers Approved" :value="number_format($data['volApproved'] ?? 0)" gradientVariant="forest" />
        <x-overview.stat-card icon="bx-time" title="Volunteers Pending" :value="number_format($data['volPending'] ?? 0)" gradientVariant="sunset-orange" />
        <x-overview.stat-card icon="bx-list-check" title="Open Tasks" :value="number_format($data['tasksOpen'] ?? 0)" gradientVariant="indigo" />
        <x-overview.stat-card icon="bx-error" title="Overdue Assignments" :value="number_format($data['tasksOverdue'] ?? 0)" gradientVariant="deep-rose" />
    </x-overview.stat-card-group>

    <!-- Comms & Insight (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-message-rounded-dots" title="Unread Chats" :value="number_format($data['chatsUnread'] ?? 0)" gradientVariant="violet" />
        <x-overview.stat-card icon="bx-conversation" title="Active Threads" :value="number_format($data['chatsActive'] ?? 0)" gradientVariant="brand" />
        <x-overview.stat-card icon="bx-star" title="Avg Rating" :value="number_format($data['avgRating'] ?? 0, 2)" gradientVariant="amber-orange" />
        <x-overview.stat-card icon="bx-notepad" title="Attendance Logs" :value="number_format($data['attendanceTotalLogs'] ?? 0)" gradientVariant="blue-sky" />
    </x-overview.stat-card-group>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Latest Feedback -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-yellow-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-star text-xl text-yellow-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Latest Feedback</h3>
                    <p class="text-gray-600 text-sm">Recent program reviews</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse(($data['latestFeedback'] ?? []) as $f)
                    <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors border-l-4 border-yellow-400">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-medium text-gray-800">{{ $f->program->title ?? 'Program' }}</div>
                            <div class="flex items-center text-yellow-600">
                                <i class='bx bx-star mr-1'></i>
                                <span class="font-bold">{{ $f->rating }}</span>
                            </div>
                        </div>
                        <div class="text-gray-600 text-sm mb-2">
                            by {{ data_get($f, 'volunteer.user.name', 'Volunteer') }} • {{ optional($f->submitted_at)->diffForHumans() }}
                        </div>
                        @if($f->feedback)
                            <div class="text-gray-700 text-sm bg-white p-2 rounded italic">
                                "{{ $f->feedback }}"
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class='bx bx-comment text-3xl mb-2'></i>
                        <p>No feedback yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Requests (latest 3) -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-purple-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-task text-xl text-purple-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Latest Requests</h3>
                    <p class="text-gray-600 text-sm">Most recent program requests</p>
                </div>
            </div>

            <div class="mb-4 flex items-center justify-between">
                <div class="text-sm text-gray-600">Pending approvals</div>
                <div class="text-sm font-semibold text-amber-600">{{ number_format($data['requestsPending'] ?? 0) }}</div>
            </div>

            <div class="space-y-3">
                @forelse(($data['requestsLatest'] ?? []) as $r)
                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <div class="text-gray-800 font-medium">Request #{{ $r->id }}</div>
                        <div class="text-gray-600 text-sm">{{ ucfirst($r->status ?? 'pending') }}</div>
                        <div class="text-gray-500 text-xs">{{ optional($r->created_at)->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class='bx bx-task text-3xl mb-2'></i>
                        <p>No recent requests.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Attendance + Engagement -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Attendance -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-blue-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-time-five text-xl text-blue-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Attendance</h3>
                    <p class="text-gray-600 text-sm">Recent logs · Last 30d hours: <span class="font-semibold">{{ number_format($data['attendanceHours30d'] ?? 0, 2) }}</span></p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['attendanceRecent'] ?? []) as $a)
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="text-gray-800 font-medium truncate">{{ $a->volunteer_name ?? 'Volunteer' }}</div>
                        <div class="text-gray-600 text-sm">#{{ $a->program_id }}</div>
                        <div class="text-gray-500 text-xs">{{ optional($a->created_at)->diffForHumans() }}</div>
                        @if(!is_null($a->hours_logged))
                            <div class="text-blue-700 text-sm font-semibold">{{ number_format($a->hours_logged, 2) }}h</div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class='bx bx-time-five text-3xl mb-2'></i>
                        <p>No recent attendance.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Program Engagement -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-indigo-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-trending-up text-xl text-indigo-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Program Engagement</h3>
                    <p class="text-gray-600 text-sm">Daily joins over the last 14 days</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                @forelse(($data['engagement'] ?? []) as $row)
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3 text-center hover:bg-indigo-100 transition-colors">
                        <div class="text-gray-600 text-xs mb-1">{{ \Illuminate\Support\Carbon::parse($row->date)->format('M d') }}</div>
                        <div class="text-lg font-bold text-indigo-600">{{ $row->joins }}</div>
                        <i class='bx bx-user-plus text-indigo-400'></i>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <i class='bx bx-trending-down text-3xl mb-2'></i>
                        <p>No recent engagement data.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
