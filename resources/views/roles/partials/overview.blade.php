<!-- Overview Tab Content -->
<div x-show="activeTab === 'overview'" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    class="space-y-6">
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Total Users -->
        <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600">Total Users</p>
                    <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $users->count() }}</h3>
                </div>
                <div class="bg-blue-50 p-2 sm:p-3 rounded-full">
                    <i class='bx bx-user text-xl sm:text-2xl text-blue-500'></i>
                </div>
            </div>
        </div>

        <!-- Total Roles -->
        <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600">Total Roles</p>
                    <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $roles->count() }}</h3>
                </div>
                <div class="bg-indigo-50 p-2 sm:p-3 rounded-full">
                    <i class='bx bx-shield text-xl sm:text-2xl text-indigo-500'></i>
                </div>
            </div>
        </div>

        <!-- Users with Roles -->
        <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600">Users with Multiple Roles</p>
                    <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">
                        {{ $users->filter(fn($user) => $user->roles->count() > 1)->count() }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Out of {{ $users->count() }} total users
                    </p>
                </div>
                <div class="bg-green-50 p-2 sm:p-3 rounded-full">
                    <i class='bx bx-layer text-xl sm:text-2xl text-green-500'></i>
                </div>
            </div>
        </div>

        <!-- Role Assignment Rate -->
        <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600">Average Roles per User</p>
                    <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">
                        @php
                            $totalRoleAssignments = $users->sum(fn($user) => $user->roles->count());
                            echo $users->count() > 0 ? number_format($totalRoleAssignments / $users->count(), 1) : '0.0';
                        @endphp
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Total assignments: {{ $totalRoleAssignments }}
                    </p>
                </div>
                <div class="bg-yellow-50 p-2 sm:p-3 rounded-full">
                    <i class='bx bx-stats text-xl sm:text-2xl text-yellow-500'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Distribution -->
    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
        <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Role Distribution</h3>
        <div class="space-y-3 sm:space-y-4">
            @foreach($roles as $role)
                @php
                    $usersWithRole = $users->filter(fn($user) => $user->roles->contains('id', $role->id))->count();
                    $percentage = $users->count() > 0 ? round(($usersWithRole / $users->count()) * 100) : 0;
                @endphp
                <div class="flex items-center justify-between border-b pb-2 sm:pb-3 last:border-0">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class='bx bx-shield text-lg sm:text-xl text-indigo-500'></i>
                        </div>
                        <div>
                            <p class="text-sm sm:text-base font-medium text-[#1a2235]">{{ $role->role_name }}</p>
                            <p class="text-xs sm:text-sm text-gray-600">
                                {{ $usersWithRole }} users assigned
                            </p>
                        </div>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-500">
                        {{ $percentage }}% of users
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div> 