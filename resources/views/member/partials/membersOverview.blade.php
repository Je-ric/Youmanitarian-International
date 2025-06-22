@php
    $stats = [
        [
            'title' => 'Total Members',
            'value' => $members->total(),
            'icon' => 'bx-group',
            'color' => 'blue'
        ],
        [
            'title' => 'Active Members',
            'value' => $activeMembersCount,
            'icon' => 'bx-user-check',
            'color' => 'green'
        ],
        [
            'title' => 'Full-Pledge Members',
            'value' => $fullPledgeMembers->total(),
            'icon' => 'bx-star',
            'color' => 'yellow'
        ],
        [
            'title' => 'Honorary Members',
            'value' => $honoraryMembers->total(),
            'icon' => 'bx-award',
            'color' => 'purple'
        ]
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    @foreach($stats as $stat)
        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ $stat['title'] }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                </div>
                <div class="p-3 bg-{{ $stat['color'] }}-100 rounded-full">
                    <i class='bx {{ $stat['icon'] }} text-{{ $stat['color'] }}-500 text-xl'></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recently Joined Members -->
    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recently Joined Members</h3>
        <div class="space-y-4">
            @forelse($recentlyJoinedMembers as $member)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ $member->user->profile_photo_url }}" alt="{{ $member->user->name }}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $member->user->name }}</p>
                            <p class="text-sm text-gray-500">Joined on {{ $member->start_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $member->membership_type)) }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No recently joined members.</p>
            @endforelse
        </div>
    </div>

    <!-- Oldest Pending Invitations -->
    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Oldest Pending Invitations</h3>
        <div class="space-y-4">
            @forelse($oldestPendingInvitations as $member)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                         <img src="{{ $member->user->profile_photo_url }}" alt="{{ $member->user->name }}" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $member->user->name }}</p>
                            <p class="text-sm text-gray-500">Invited on {{ $member->invited_at->format('M d, Y') }} ({{ $member->invited_at->diffForHumans() }})</p>
                        </div>
                    </div>
                    <form action="{{ route('members.resend-invitation', $member) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Resend</button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No pending invitations.</p>
            @endforelse
        </div>
    </div>
</div> 