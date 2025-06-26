@extends('layouts.sidebar_final')

@section('content')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #666;
        }
    </style>
    <x-page-header icon="bx-calendar-event" title="Role Management"
        desc="Manage user roles and permissions">
    </x-page-header>

        @php
            $tabs = [
                ['id' => 'users', 'label' => 'Users & Roles', 'icon' => 'bx-user'],
                ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats']
            ];
        @endphp

        <x-navigation-layout.tabs-modern
            :tabs="$tabs"
            default-tab="{{ request()->query('tab', 'users') }}"
        >
            <x-slot:slot_users>
                    <x-table.table containerClass="overflow-x-auto custom-scrollbar" tableClass="min-w-full">
                        <x-table.thead>
                            <x-table.tr :hover="false">
                                <x-table.th>User</x-table.th>
                                <x-table.th>Current Roles</x-table.th>
                                <x-table.th>Actions</x-table.th>
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                            @foreach($users as $user)
                                <x-table.tr>
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
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $role->role_name }}
                                                </span>
                                            @empty
                                                <span class="text-gray-500 text-sm">No roles assigned</span>
                                            @endforelse
                                        </div>
                                    </x-table.td>
                                    <x-table.td>
                                        <x-button type="button" variant="table-action-manage" onclick="document.getElementById('assignRolesModal_{{ $user->id }}').showModal()">
                                            <i class='bx bx-edit-alt'></i>
                                        </x-button>
                                    </x-table.td>
                                </x-table.tr>

                                @include('roles.partials.assign_rolesModal')
                            @endforeach
                        </x-table.tbody>
                    </x-table.table>
            </x-slot>

            <x-slot:slot_overview>
                @include('roles.partials.rolesOverview')
            </x-slot>
        </x-navigation-layout.tabs-modern>
@endsection 