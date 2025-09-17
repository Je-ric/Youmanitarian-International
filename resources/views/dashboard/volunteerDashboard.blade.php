<!-- Volunteer Dashboard -->
<div class="bg-gray-50 min-h-screen">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white border-2 border-blue-100 rounded-xl p-6 hover:border-blue-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 text-sm font-medium mb-1">Joined Programs</div>
                    <div class="text-3xl font-bold text-blue-600">{{ number_format($data['joinedPrograms'] ?? 0) }}</div>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <i class='bx bx-group text-2xl text-blue-600'></i>
                </div>
            </div>
        </div>

        <div class="bg-white border-2 border-green-100 rounded-xl p-6 hover:border-green-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 text-sm font-medium mb-1">Total Hours</div>
                    <div class="text-3xl font-bold text-green-600">{{ number_format($data['totalHours'] ?? 0, 2) }}</div>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <i class='bx bx-time text-2xl text-green-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Upcoming Programs -->
        <div class="bg-white border-2 border-amber-100 rounded-xl p-6 hover:border-amber-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-amber-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-calendar-plus text-xl text-amber-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Upcoming Programs</h3>
                    <p class="text-gray-600 text-sm">Programs to attend</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['upcomingPrograms'] ?? []) as $p)
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                        <div class="flex items-center">
                            <i class='bx bx-calendar text-amber-600 mr-2'></i>
                            <span class="text-gray-700 font-medium truncate">{{ $p->title }}</span>
                        </div>
                        <a href="{{ route('programs.view', $p) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-calendar-x text-2xl mb-2'></i>
                        <p class="text-sm">No upcoming programs.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Ongoing Programs -->
        <div class="bg-white border-2 border-green-100 rounded-xl p-6 hover:border-green-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-green-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-play-circle text-xl text-green-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Ongoing Programs</h3>
                    <p class="text-gray-600 text-sm">Currently active</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['ongoingPrograms'] ?? []) as $p)
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="flex items-center">
                            <i class='bx bx-play text-green-600 mr-2'></i>
                            <span class="text-gray-700 font-medium truncate">{{ $p->title }}</span>
                        </div>
                        <a href="{{ route('programs.view', $p) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-pause-circle text-2xl mb-2'></i>
                        <p class="text-sm">No ongoing programs.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Completed Programs -->
        <div class="bg-white border-2 border-blue-100 rounded-xl p-6 hover:border-blue-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-blue-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-check-circle text-xl text-blue-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Completed Programs</h3>
                    <p class="text-gray-600 text-sm">Finished activities</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['donePrograms'] ?? []) as $p)
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="flex items-center">
                            <i class='bx bx-check text-blue-600 mr-2'></i>
                            <span class="text-gray-700 font-medium truncate">{{ $p->title }}</span>
                        </div>
                        <a href="{{ route('programs.view', $p) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class='bx bx-show'></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-list-check text-2xl mb-2'></i>
                        <p class="text-sm">No completed programs.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Volunteer Overview -->
    <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
        <div class="flex items-center mb-6">
            <div class="bg-indigo-50 p-2 rounded-lg mr-3">
                <i class='bx bx-user-check text-xl text-indigo-600'></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">My Volunteer Overview</h3>
                <p class="text-gray-600 text-sm">Performance summary</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center hover:bg-purple-100 transition-colors">
                <i class='bx bx-task text-2xl text-purple-600 mb-2'></i>
                <div class="text-gray-600 text-sm mb-1">Assigned Tasks</div>
                <div class="text-2xl font-bold text-purple-600">{{ number_format($data['assignedTasks'] ?? 0) }}</div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center hover:bg-blue-100 transition-colors">
                <i class='bx bx-group text-2xl text-blue-600 mb-2'></i>
                <div class="text-gray-600 text-sm mb-1">Joined Programs</div>
                <div class="text-2xl font-bold text-blue-600">{{ number_format($data['joinedPrograms'] ?? 0) }}</div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center hover:bg-green-100 transition-colors">
                <i class='bx bx-time text-2xl text-green-600 mb-2'></i>
                <div class="text-gray-600 text-sm mb-1">Total Hours</div>
                <div class="text-2xl font-bold text-green-600">{{ number_format($data['totalHours'] ?? 0, 2) }}</div>
            </div>

            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-center hover:bg-orange-100 transition-colors">
                <i class='bx bx-calendar text-2xl text-orange-600 mb-2'></i>
                <div class="text-gray-600 text-sm mb-1">This Month</div>
                <div class="text-2xl font-bold text-orange-600">{{ number_format(($data['totalHours'] ?? 0), 2) }}</div>
            </div>
        </div>
    </div>
</div>
