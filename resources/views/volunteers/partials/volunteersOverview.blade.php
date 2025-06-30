{{-- Statistics Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
    <x-overview.stat-card
        icon="bx-user"
        title="Total Volunteers"
        :value="$approvedVolunteers->count()"
        bgColor="bg-blue-50"
        iconColor="text-blue-500"
        href="{{ route('volunteers.index', ['tab' => 'approved']) }}"
    />
    <x-overview.stat-card
        icon="bx-time"
        title="Pending Applications"
        :value="$applications->count()"
        bgColor="bg-yellow-50"
        iconColor="text-yellow-500"
        href="{{ route('volunteers.index', ['tab' => 'applications']) }}"
    />
    <x-overview.stat-card
        icon="bx-x-circle"
        title="Denied Applications"
        :value="$deniedApplications->count()"
        bgColor="bg-red-50"
        iconColor="text-red-500"
        href="{{ route('volunteers.index', ['tab' => 'denied']) }}"
    />
    <x-overview.stat-card
        icon="bx-trending-up"
        title="Approval Rate"
        value="{{ $approvalRate }}%"
        bgColor="bg-green-50"
        iconColor="text-green-500"
    />
</div>

{{-- Recent Activity --}}
<div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm mt-6">
    <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Recent Activity</h3>
    <div class="space-y-3 sm:space-y-4">
        @php
            $allVolunteers = collect([$applications, $deniedApplications, $approvedVolunteers])
                ->flatten()
                ->sortByDesc('updated_at')
                ->take(5);
        @endphp

        @forelse($allVolunteers as $volunteer)
            <div class="flex items-center justify-between border-b pb-2 sm:pb-3 last:border-0">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class='bx bx-user text-lg sm:text-xl text-gray-500'></i>
                    </div>
                    <div>
                        <p class="text-sm sm:text-base font-medium text-[#1a2235]">{{ $volunteer->user->name }}</p>
                        <p class="text-xs sm:text-sm text-gray-600">
                            @if($volunteer->application_status === 'pending')
                                Application submitted
                            @elseif($volunteer->application_status === 'approved')
                                Application approved
                            @else
                                Application denied
                            @endif
                        </p>
                    </div>
                </div>
                <span class="text-xs sm:text-sm text-gray-500 whitespace-nowrap">
                    {{ $volunteer->updated_at->diffForHumans() }}
                </span>
            </div>
        @empty
            <p class="text-gray-600 text-center py-4">No recent activity</p>
        @endforelse
    </div>
</div>