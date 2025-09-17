<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Joined Programs</div>
        <div class="text-2xl font-semibold">{{ number_format($data['joinedPrograms'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Total Hours</div>
        <div class="text-2xl font-semibold">{{ number_format($data['totalHours'] ?? 0, 2) }}</div>
    </div>
</div>


<div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Upcoming Programs</div>
        <ul class="space-y-2">
            @forelse(($data['upcomingPrograms'] ?? []) as $p)
                <li class="flex items-center justify-between">
                    <div class="truncate">{{ $p->title }}</div>
                    <a href="{{ route('programs.view', $p) }}" class="text-blue-600 text-sm">Attendance</a>
                </li>
            @empty
                <li class="text-gray-500">No upcoming programs.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Ongoing Programs</div>
        <ul class="space-y-2">
            @forelse(($data['ongoingPrograms'] ?? []) as $p)
                <li class="flex items-center justify-between">
                    <div class="truncate">{{ $p->title }}</div>
                    <a href="{{ route('programs.view', $p) }}" class="text-blue-600 text-sm">Attendance</a>
                </li>
            @empty
                <li class="text-gray-500">No ongoing programs.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Completed Programs</div>
        <ul class="space-y-2">
            @forelse(($data['donePrograms'] ?? []) as $p)
                <li class="flex items-center justify-between">
                    <div class="truncate">{{ $p->title }}</div>
                    <a href="{{ route('programs.view', $p) }}" class="text-blue-600 text-sm">View</a>
                </li>
            @empty
                <li class="text-gray-500">No completed programs.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="mt-6 bg-white rounded shadow p-4">
    <div class="font-semibold mb-2">My Volunteer Overview</div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
        <div>
            <div class="text-gray-500">Assigned Tasks</div>
            <div class="text-2xl font-semibold">{{ number_format($data['assignedTasks'] ?? 0) }}</div>
        </div>
        <div>
            <div class="text-gray-500">Joined Programs</div>
            <div class="text-2xl font-semibold">{{ number_format($data['joinedPrograms'] ?? 0) }}</div>
        </div>
        <div>
            <div class="text-gray-500">Total Hours</div>
            <div class="text-2xl font-semibold">{{ number_format($data['totalHours'] ?? 0, 2) }}</div>
        </div>
        <div>
            <div class="text-gray-500">This Month</div>
            <div class="text-2xl font-semibold">{{ number_format(($data['totalHours'] ?? 0), 2) }}</div>
        </div>
    </div>
</div>

