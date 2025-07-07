<div class="space-y-4">
    {{-- Role Header --}}
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                @php
                    $roleIcon = match($roleName) {
                        'Volunteer' => 'bx-user',
                        'Admin' => 'bx-crown',
                        'Program Coordinator' => 'bx-calendar-event',
                        'Financial Coordinator' => 'bx-wallet',
                        'Content Manager' => 'bx-edit-alt',
                        'Member' => 'bx-group',
                        default => 'bx-user-circle'
                    };
                    $roleColor = match($roleName) {
                        'Volunteer' => 'bg-blue-100 text-blue-600',
                        'Admin' => 'bg-purple-100 text-purple-600',
                        'Program Coordinator' => 'bg-green-100 text-green-600',
                        'Financial Coordinator' => 'bg-yellow-100 text-yellow-600',
                        'Content Manager' => 'bg-indigo-100 text-indigo-600',
                        'Member' => 'bg-orange-100 text-orange-600',
                        default => 'bg-gray-100 text-gray-600'
                    };
                @endphp
                <div class="w-10 h-10 rounded-full {{ $roleColor }} flex items-center justify-center">
                    <i class='bx {{ $roleIcon }} text-xl'></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $roleName }}s</h3>
                    <p class="text-sm text-gray-600">{{ $users->total() }} users with this role</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
    @if($users->count() > 0)
        <x-table.table containerClass="overflow-x-auto" tableClass="min-w-full">
            <x-table.thead>
                <x-table.tr :hover="false">
                    <x-table.th class="w-10 text-center">#</x-table.th>
                    <x-table.th>User</x-table.th>
                    <x-table.th>All Roles</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach($users as $user)
                    <x-table.tr>
                        <x-table.td class="w-10 text-center text-gray-500">{{ $loop->iteration }}</x-table.td>
                        <x-table.td>
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($user->profile_pic)
                                        <img class="h-10 w-10 rounded-full" src="{{ $user->profile_pic }}" alt="{{ $user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-800 font-medium">{{ substr($user->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-800">
                                        {{ $user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $user->email }}
                                    </div>
                                </div>
                            </div>
                        </x-table.td>
                        <x-table.td>
                            <div class="flex flex-wrap gap-2">
                                @forelse($user->roles as $role)
                                    @php
                                        $roleBadgeColor = match($role->role_name) {
                                            'Volunteer' => 'bg-blue-100 text-blue-800',
                                            'Admin' => 'bg-purple-100 text-purple-800',
                                            'Program Coordinator' => 'bg-green-100 text-green-800',
                                            'Financial Coordinator' => 'bg-yellow-100 text-yellow-800',
                                            'Content Manager' => 'bg-indigo-100 text-indigo-800',
                                            'Member' => 'bg-orange-100 text-orange-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleBadgeColor }}">
                                        {{ $role->role_name }}
                                    </span>
                                @empty
                                    <span class="text-gray-500 text-sm">No roles assigned</span>
                                @endforelse
                            </div>
                        </x-table.td>
                        <x-table.td>
                            <x-button type="button" variant="table-action-manage" onclick="document.getElementById('assignRolesModal_{{ $roleType }}_{{ $user->id }}').showModal()">
                                <i class='bx bx-edit-alt'></i>
                            </x-button>
                        </x-table.td>
                    </x-table.tr>

                    @include('roles.partials.assign_rolesModal', ['roleType' => $roleName])
                @endforeach
            </x-table.tbody>
        </x-table.table>
        
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $users->appends(['tab' => request()->query('tab', 'volunteer')])->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                <i class='bx {{ $roleIcon }} text-gray-400 text-2xl'></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">No {{ $roleName }}s Found</h3>
            <p class="text-gray-500">There are no users assigned to this role yet.</p>
        </div>
    @endif
</div> 