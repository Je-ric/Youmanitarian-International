<div class="space-y-4">
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
                                        $variant = match($role->role_name) {
                                            'Volunteer' => 'volunteer',
                                            'Admin' => 'admin',
                                            'Program Coordinator' => 'program-coordinator',
                                            'Financial Coordinator' => 'financial-coordinator',
                                            'Content Manager' => 'content-manager',
                                            'Member' => 'member',
                                            default => 'role'
                                        };
                                    @endphp
                                    <x-feedback-status.status-indicator 
                                            :label="$role->role_name" 
                                            :status="$variant" />
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
        
        {{-- Pagination Section --}}
        <div class="mt-4">
            {{ $users->appends(['tab' => request()->query('tab', 'volunteer')])->links() }}
        </div>
    @else
        {{-- Empty State Section --}}
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                <i class='bx bx-user text-gray-400 text-2xl'></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">No {{ $roleName }}s Found</h3>
            <p class="text-gray-500">There are no users assigned to this role yet.</p>
        </div>
    @endif
</div> 