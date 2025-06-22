<!-- Statistics Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
    <!-- Total Volunteers -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-600">Total Volunteers</p>
                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $approvedVolunteers->count() }}</h3>
            </div>
            <div class="bg-blue-50 p-2 sm:p-3 rounded-full">
                <i class='bx bx-user text-xl sm:text-2xl text-blue-500'></i>
            </div>
        </div>
    </div>

    <!-- Pending Applications -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-600">Pending Applications</p>
                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $applications->count() }}</h3>
            </div>
            <div class="bg-yellow-50 p-2 sm:p-3 rounded-full">
                <i class='bx bx-time text-xl sm:text-2xl text-yellow-500'></i>
            </div>
        </div>
    </div>

    <!-- Denied Applications -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-600">Denied Applications</p>
                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $deniedApplications->count() }}</h3>
            </div>
            <div class="bg-red-50 p-2 sm:p-3 rounded-full">
                <i class='bx bx-x-circle text-xl sm:text-2xl text-red-500'></i>
            </div>
        </div>
    </div>

    <!-- Approval Rate -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs sm:text-sm text-gray-600">Approval Rate</p>
                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">
                    @php
                        $total = $approvedVolunteers->count() + $deniedApplications->count();
                        echo $total > 0 ? round(($approvedVolunteers->count() / $total) * 100) : 0;
                    @endphp%
                </h3>
            </div>
            <div class="bg-green-50 p-2 sm:p-3 rounded-full">
                <i class='bx bx-trending-up text-xl sm:text-2xl text-green-500'></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
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