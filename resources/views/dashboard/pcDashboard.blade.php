<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">My Programs</div>
        <div class="text-2xl font-semibold">{{ number_format($data['myPrograms'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Ongoing</div>
        <div class="text-2xl font-semibold">{{ number_format($data['ongoing'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Upcoming</div>
        <div class="text-2xl font-semibold">{{ number_format($data['upcoming'] ?? 0) }}</div>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Latest Feedback (5)</div>
        <ul class="space-y-3">
            @forelse(($data['latestFeedback'] ?? []) as $f)
                <li class="border-b pb-2">
                    <div class="text-gray-900">
                        {{ $f->program->title ?? 'Program' }} — <span class="text-yellow-600">★ {{ $f->rating }}</span>
                    </div>
                    <div class="text-gray-600 text-sm">
                        by {{ data_get($f, 'volunteer.user.name', 'Volunteer') }} • {{ optional($f->submitted_at)->diffForHumans() }}
                    </div>
                    @if($f->feedback)
                        <div class="text-gray-700 text-sm mt-1 truncate">“{{ $f->feedback }}”</div>
                    @endif
                </li>
            @empty
                <li class="text-gray-500">No feedback yet.</li>
            @endforelse
        </ul>
    </div>

    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Volunteer Applications</div>
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <div class="text-gray-500">Pending</div>
                <div class="text-2xl font-semibold">{{ number_format($data['volunteerStats']['applicationsPending'] ?? 0) }}</div>
            </div>
            <div>
                <div class="text-gray-500">Approved</div>
                <div class="text-2xl font-semibold">{{ number_format($data['volunteerStats']['applicationsApproved'] ?? 0) }}</div>
            </div>
            <div>
                <div class="text-gray-500">Denied</div>
                <div class="text-2xl font-semibold">{{ number_format($data['volunteerStats']['applicationsDenied'] ?? 0) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-6 bg-white rounded shadow p-4">
    <div class="font-semibold mb-2">Program Engagement (Joins per day, last 14d)</div>
    <ul class="space-y-2">
        @forelse(($data['engagement'] ?? []) as $row)
            <li class="flex items-center justify-between">
                <div class="text-gray-700">{{ \Illuminate\Support\Carbon::parse($row->date)->format('M d') }}</div>
                <div class="text-gray-900 font-medium">{{ $row->joins }}</div>
            </li>
        @empty
            <li class="text-gray-500">No recent engagement.</li>
        @endforelse
    </ul>
</div>

