<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Users</div>
        <div class="text-2xl font-semibold">{{ number_format($data['usersCount'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Programs</div>
        <div class="text-2xl font-semibold">{{ number_format($data['programsCount'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Contents</div>
        <div class="text-2xl font-semibold">{{ number_format($data['contentsCount'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow md:col-span-2">
        <div class="text-gray-500">Confirmed Donations</div>
        <div class="text-2xl font-semibold">₱ {{ number_format($data['donationsTotal'] ?? 0, 2) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Pending Donations</div>
        <div class="text-2xl font-semibold">{{ number_format($data['pendingDonations'] ?? 0) }}</div>
    </div>
</div>


<div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Pending Contents</div>
        <ul class="space-y-2">
            @forelse(($data['pendingContents'] ?? []) as $c)
                <li class="flex items-center justify-between">
                    <div class="truncate">{{ $c->title }}</div>
                    <div class="text-amber-600 text-sm">{{ $c->approval_status }}</div>
                </li>
            @empty
                <li class="text-gray-500">No pending contents.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Top Reacted Contents</div>
        <ul class="space-y-2">
            @forelse(($data['topReactedContents'] ?? []) as $c)
                <li class="flex items-center justify-between">
                    <div class="truncate">{{ $c->title }}</div>
                    <div class="text-pink-600 text-sm font-medium">❤ {{ $c->hearts ?? 0 }}</div>
                </li>
            @empty
                <li class="text-gray-500">No reacts yet.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Recent Donations</div>
        <ul class="space-y-2">
            @forelse(($data['recentDonations'] ?? []) as $d)
                <li class="flex items-center justify-between">
                    <div class="truncate">₱ {{ number_format($d->amount ?? 0, 2) }}</div>
                    <div class="text-gray-500 text-sm">{{ $d->donor_name ?? 'Anonymous' }}</div>
                </li>
            @empty
                <li class="text-gray-500">No recent donations.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="mt-6 bg-white rounded shadow p-4">
    <div class="font-semibold mb-2">Top Donation Methods</div>
    <ul class="space-y-2">
        @forelse(($data['topDonationMethods'] ?? []) as $m)
            <li class="flex items-center justify-between">
                <div class="text-gray-700">{{ $m->payment_method ?? 'Unknown' }}</div>
                <div class="text-gray-900 font-medium">₱ {{ number_format($m->total ?? 0, 2) }}</div>
            </li>
        @empty
            <li class="text-gray-500">No data.</li>
        @endforelse
    </ul>
</div>

