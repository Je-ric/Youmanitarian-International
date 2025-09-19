@php
    $showRoles = $showRoles ?? false;
@endphp

<div class="space-y-4">
    @if($users->count() > 0)
        <x-table.table containerClass="overflow-x-auto" tableClass="min-w-full">
            <x-table.thead>
                <x-table.tr :hover="false">
                    <x-table.th class="w-10 text-center">#</x-table.th>
                    <x-table.th>User</x-table.th>
                    @if($showRoles)
                        <x-table.th>Roles</x-table.th>
                    @endif
                    <x-table.th>Actions</x-table.th>
                </x-table.tr>
            </x-table.thead>
            <x-table.tbody>
                @foreach($users as $user)
                    <x-table.tr>
                        <x-table.td class="w-10 text-center text-gray-500">{{ $loop->iteration + (($users instanceof \Illuminate\Pagination\LengthAwarePaginator) ? ($users->currentPage() - 1) * $users->perPage() : 0) }}</x-table.td>
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
                        @if($showRoles)
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
                        @endif
                        <x-table.td>
                            <x-button href="{{ route('volunteers.volunteer-details', $user->id) }}" variant="table-action-view" class="tooltip" data-tip="View Details">
                                <i class='bx bx-dots-horizontal-rounded'></i>
                            </x-button>
                            <x-button type="button" variant="table-action-manage" onclick="document.getElementById('assignRolesModal_{{ $roleType }}_{{ $user->id }}').showModal()">
                                <i class='bx bx-edit-alt'></i>
                            </x-button>
                        </x-table.td>
                    </x-table.tr>

                    @include('roles.partials.assignRolesModal', ['roleType' => $roleType, 'roles' => $roles])
                @endforeach
            </x-table.tbody>
        </x-table.table>

        <div class="mt-4">
            @php
                $pageName = $pageName ?? match($roleType ?? '') {
                    'Volunteer' => 'volunteer_page',
                    'Admin' => 'admin_page',
                    'Program Coordinator' => 'program_coordinator_page',
                    'Financial Coordinator' => 'financial_coordinator_page',
                    'Content Manager' => 'content_manager_page',
                    'Member' => 'member_page',
                    default => 'page',
                };
            @endphp
            @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $users->appends(array_merge(
                    [
                        'tab' => request()->query('tab', $roleType),
                        'search' => request('search'),
                        'sort_by' => request('sort_by'),
                        'sort_order' => request('sort_order'),
                    ],
                    [$pageName => $users->currentPage()]
                ))->links() }}
            @endif
        </div>
    @else
        <x-empty-state
            icon="bx bx-user"
            title="No {{ $roleName }}s Found"
            description="There are no users assigned to this role yet."
        />
    @endif
</div>
