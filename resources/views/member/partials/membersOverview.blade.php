<x-overview.stat-card-group>
    <x-overview.stat-card
        icon="bx-group"
        title="Total Members"
        :value="$totalMembersCount"
        bgColor="bg-green-100"
        iconColor="text-green-500"
        gradientVariant="emerald-teal"
    />
    <x-overview.stat-card
        icon="bx-user-check"
        title="Active Members"
        :value="$activeMembersCount"
        bgColor="bg-green-100"
        iconColor="text-green-500"
        gradientVariant="golden"
    />
    <x-overview.stat-card
        icon="bx-star"
        title="Full-Pledge Members"
        :value="$fullPledgeMembersCount"
        bgColor="bg-yellow-100"
        iconColor="text-yellow-500"
        gradientVariant="cherry"
    />
    <x-overview.stat-card
        icon="bx-award"
        title="Honorary Members"
        :value="$honoraryMembersCount"
        bgColor="bg-purple-100"
        iconColor="text-purple-500"
        gradientVariant="ocean"
    />
</x-overview.stat-card-group>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recently Joined Members --}}
    <x-overview.card title="Recently Joined Members" variant="minimal">
        @forelse($recentlyJoinedMembers as $member)
            <x-overview.summary-list-item :imageUrl="$member->user->profile_photo_url">
                <x-slot:title>{{ $member->user->name }}</x-slot:title>
                <x-slot:subtitle>Joined on {{ $member->start_date->format('M d, Y') }}</x-slot:subtitle>
                <x-slot:action>
                    <span class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $member->membership_type)) }}</span>
                </x-slot:action>
            </x-overview.summary-list-item>
        @empty
            <p class="text-gray-500 text-center py-4">No recently joined members.</p>
        @endforelse
    </x-overview.card>

    {{-- Oldest Pending Invitations --}}
    <x-overview.card title="Oldest Pending Invitations" variant="minimal">
        @forelse($oldestPendingInvitations as $member)
            <x-overview.summary-list-item :imageUrl="$member->user->profile_photo_url">
                <x-slot:title>{{ $member->user->name }}</x-slot:title>
                <x-slot:subtitle>Invited on {{ $member->invited_at->format('M d, Y') }} ({{ $member->invited_at->diffForHumans() }})</x-slot:subtitle>
                <x-slot:action>
                    <form action="{{ route('members.resend-invitation', $member) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Resend</button>
                    </form>
                </x-slot:action>
            </x-overview.summary-list-item>
        @empty
            <p class="text-gray-500 text-center py-4">No pending invitations.</p>
        @endforelse
    </x-overview.card>
</div> 