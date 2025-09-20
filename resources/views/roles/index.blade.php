@extends('layouts.sidebar_final')

@section('content')
    <x-page-header
        icon="bx-shield-quarter"
        title="Role Management"
        desc="Manage user roles and permissions">
        <div class="flex items-center gap-2">
            <a href="{{ route('reports.users.roles', ['format' => 'csv']) }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-green-700 bg-green-100 rounded hover:bg-green-200">
                <i class='bx bx-table'></i> Export Users+Roles (CSV)
            </a>
            <a href="{{ route('reports.users.roles', ['format' => 'pdf']) }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-700 bg-red-100 rounded hover:bg-red-200">
                <i class='bx bx-file'></i> Export Users+Roles (PDF)
            </a>
        </div>
    </x-page-header>

        @php
            $tabs = [
                ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
                ['id' => 'all_users', 'label' => 'All Users (' . $allUsers->count() . ')', 'icon' => 'bx-group'],
                ['id' => 'admin', 'label' => 'Admins (' . $adminUsers->count() . ')', 'icon' => 'bx-crown'],
                ['id' => 'content_manager', 'label' => 'Content (' . $contentManagerUsers->count() . ')', 'icon' => 'bx-edit-alt'],
                ['id' => 'program_coordinator', 'label' => 'Program (' . $programCoordinatorUsers->count() . ')', 'icon' => 'bx-calendar-event'],
                ['id' => 'financial_coordinator', 'label' => 'Finance (' . $financialCoordinatorUsers->count() . ')', 'icon' => 'bx-wallet'],
                ['id' => 'volunteer', 'label' => 'Volunteers (' . $volunteerUsers->count() . ')', 'icon' => 'bx-user'],
                // ['id' => 'no_roles', 'label' => 'No Roles (' . $usersWithoutRoles->count() . ')', 'icon' => 'bx-user-x'],
            ];

            $currentTab = request()->query('tab', 'overview'); // fallback to overview
        @endphp

        <x-navigation-layout.tabs-modern
            :tabs="$tabs"
            default-tab="{{ $currentTab }}"
        >
            <x-slot:slot_overview>
                @include('roles.partials.rolesOverview')
            </x-slot>

            <x-slot:slot_all_users>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['name' => 'Name']"
                    searchPlaceholder="Search by name"
                    searchLabel="Name"
                />
                @include('roles.partials.usersTable', [
                    'users' => $allUsersPaginated,
                    'roleName' => 'User',
                    'roleType' => 'all',
                    'pageName' => 'all_users_page',
                    'roles' => $roles,
                    'showRoles' => true
                ])
            </x-slot>

            <x-slot:slot_volunteer>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['name' => 'Name']"
                />
                @include('roles.partials.usersTable', ['users' => $volunteerUsersPaginated,
                'roleName' => 'Volunteer',
                'roleType' => 'Volunteer',
                'pageName' => 'volunteer_page',
                'roles' => $roles])
            </x-slot>

            <x-slot:slot_admin>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['name' => 'Name']"
                />
                @include('roles.partials.usersTable', ['users' => $adminUsersPaginated,
                'roleName' => 'Admin',
                'roleType' => 'Admin',
                'pageName' => 'admin_page',
                'roles' => $roles])
            </x-slot>

            <x-slot:slot_program_coordinator>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['name' => 'Name']"
                />
                @include('roles.partials.usersTable', ['users' => $programCoordinatorUsersPaginated,
                'roleName' => 'Program Coordinator',
                'roleType' => 'Program Coordinator',
                'pageName' => 'program_coordinator_page',
                'roles' => $roles])
            </x-slot>

            <x-slot:slot_financial_coordinator>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['name' => 'Name']"
                />
                @include('roles.partials.usersTable', ['users' => $financialCoordinatorUsersPaginated,
                'roleName' => 'Financial Coordinator',
                'roleType' => 'Financial Coordinator',
                'pageName' => 'financial_coordinator_page',
                'roles' => $roles])
            </x-slot>

            <x-slot:slot_content_manager>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['name' => 'Name']"
                />
                @include('roles.partials.usersTable', ['users' => $contentManagerUsersPaginated,
                'roleName' => 'Content Manager',
                'roleType' => 'Content Manager',
                'pageName' => 'content_manager_page',
                'roles' => $roles])
            </x-slot>

            {{-- <x-slot:slot_member>
                @include('roles.partials.usersTable', ['users' => $memberUsersPaginated,
                'roleName' => 'Member',
                'roleType' => 'Member',
                'pageName' => 'member_page',
                'roles' => $roles])
            </x-slot> --}}

            {{-- <x-slot:slot_no_roles>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['name' => 'Name']"
                />
                @include('roles.partials.usersTable', [
                    'users' => $usersWithoutRoles,
                    'roleName' => 'No Role',
                    'roleType' => 'no-role',
                    'pageName' => 'no_role_page',
                    'roles' => $roles
                ])
            </x-slot> --}}
        </x-navigation-layout.tabs-modern>
@endsection
