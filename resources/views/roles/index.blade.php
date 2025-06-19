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

    <div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <div class="mb-4 sm:mb-8">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1a2235] mb-1 sm:mb-2">
                Role Management
            </h1>
            <p class="text-sm sm:text-base text-gray-600">Manage user roles and permissions</p>
        </div>

        @if (session('toast'))
            <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
        @endif

        @php
            $tabs = [
                ['id' => 'users', 'label' => 'Users & Roles', 'icon' => 'bx-user'],
                ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats']
            ];
        @endphp

        <x-tabs 
            :tabs="$tabs"
            default-tab="{{ request()->query('tab', 'users') }}"
        >
            <x-slot:slot_users>
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Current Roles
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
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
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                @forelse($user->roles as $role)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        {{ $role->role_name }}
                                                    </span>
                                                @empty
                                                    <span class="text-gray-500 text-sm">No roles assigned</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <x-button type="button" variant="table-action-manage" onclick="document.getElementById('assignRolesModal_{{ $user->id }}').showModal()">
                                                        <i class='bx bx-edit-alt'></i>
                                                    </x-button>
                                                </td>
                                    </tr>

                                    @include('roles.partials.assign_rolesModal')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </x-slot>

            <x-slot:slot_overview>
                @include('roles.partials.overview')
            </x-slot>
        </x-tabs>
    </div>
@endsection 