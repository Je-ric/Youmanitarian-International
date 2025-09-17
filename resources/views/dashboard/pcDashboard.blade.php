<!-- Program Coordinator Dashboard -->
<div class="bg-gray-50 min-h-screen">
    <!-- Stats (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-calendar" title="My Programs" :value="number_format($data['myPrograms'] ?? 0)" gradientVariant="brand" />
        <x-overview.stat-card icon="bx-play-circle" title="Ongoing" :value="number_format($data['ongoing'] ?? 0)" gradientVariant="forest" />
        <x-overview.stat-card icon="bx-calendar-plus" title="Upcoming" :value="number_format($data['upcoming'] ?? 0)" gradientVariant="amber-orange" />
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

        <!-- Volunteer Applications -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-purple-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-user-plus text-xl text-purple-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Volunteer Applications</h3>
                    <p class="text-gray-600 text-sm">Application status overview</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-center hover:bg-amber-100 transition-colors">
                    <i class='bx bx-hourglass text-2xl text-amber-600 mb-2'></i>
                    <div class="text-gray-600 text-sm mb-1">Pending</div>
                    <div class="text-2xl font-bold text-amber-600">{{ number_format($data['volunteerStats']['applicationsPending'] ?? 0) }}</div>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center hover:bg-green-100 transition-colors">
                    <i class='bx bx-check-circle text-2xl text-green-600 mb-2'></i>
                    <div class="text-gray-600 text-sm mb-1">Approved</div>
                    <div class="text-2xl font-bold text-green-600">{{ number_format($data['volunteerStats']['applicationsApproved'] ?? 0) }}</div>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center hover:bg-red-100 transition-colors">
                    <i class='bx bx-x-circle text-2xl text-red-600 mb-2'></i>
                    <div class="text-gray-600 text-sm mb-1">Denied</div>
                    <div class="text-2xl font-bold text-red-600">{{ number_format($data['volunteerStats']['applicationsDenied'] ?? 0) }}</div>
                </div>
            </div>
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
