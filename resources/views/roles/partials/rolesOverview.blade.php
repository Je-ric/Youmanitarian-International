<div class="space-y-6">
    {{-- Statistics Cards --}}
    <x-overview.stat-card-group>
        <x-overview.stat-card
            icon="bx-user"
            title="Total Users"
            :value="$users->count()"
            href="{{ route('roles.index', ['tab' => 'users']) }}"
            bgColor="bg-blue-100"
            iconColor="text-blue-500"
            cardColor="bg-blue-50"
        />
        <x-overview.stat-card
            icon="bx-shield-quarter"
            title="Total Roles"
            :value="$roles->count()"
            bgColor="bg-green-100"
            iconColor="text-green-500"
            cardColor="bg-green-50"
        />
        <x-overview.stat-card
            icon="bx-user-plus"
            title="Users Without Roles"
            :value="$usersWithoutRoles->count()"
            href="{{ route('roles.index', ['tab' => 'users']) }}"
            bgColor="bg-yellow-100"
            iconColor="text-yellow-500"
            cardColor="bg-yellow-50"
        />
        <x-overview.stat-card
            icon="bx-user-check"
            title="Active Users"
            :value="$activeUsers->count()"
            href="{{ route('roles.index', ['tab' => 'users']) }}"
            bgColor="bg-red-100"
            iconColor="text-red-500"
            cardColor="bg-red-50"
        />
    </x-overview.stat-card-group>

    {{-- Role Distribution --}}
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

   