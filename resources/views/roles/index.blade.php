@extends('layouts.sidebar_final')

@section('content')
    <x-page-header 
        icon="bx-shield-quarter" 
        title="Role Management"
        desc="Manage user roles and permissions">
    </x-page-header>

        @php
            $tabs = [
                ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
                ['id' => 'volunteer', 'label' => 'Volunteers (' . $volunteerUsers->count() . ')', 'icon' => 'bx-user'],
                ['id' => 'admin', 'label' => 'Admins (' . $adminUsers->count() . ')', 'icon' => 'bx-crown'],
                ['id' => 'program_coordinator', 'label' => 'Program Coordinators (' . $programCoordinatorUsers->count() . ')', 'icon' => 'bx-calendar-event'],
                ['id' => 'financial_coordinator', 'label' => 'Financial Coordinators (' . $financialCoordinatorUsers->count() . ')', 'icon' => 'bx-wallet'],
                ['id' => 'content_manager', 'label' => 'Content Managers (' . $contentManagerUsers->count() . ')', 'icon' => 'bx-edit-alt'],
                ['id' => 'member', 'label' => 'Members (' . $memberUsers->count() . ')', 'icon' => 'bx-group'],
                ['id' => 'no_roles', 'label' => 'No Roles (' . $usersWithoutRoles->count() . ')', 'icon' => 'bx-user-x'],
            ];
        @endphp

        <x-navigation-layout.tabs-modern
            :tabs="$tabs"
            default-tab="{{ request()->query('tab', 'overview') }}"
        >
            <x-slot:slot_overview>
                @include('roles.partials.rolesOverview')
            </x-slot>

                        <x-slot:slot_volunteer>
                @include('roles.partials.usersTable', ['users' => $volunteerUsersPaginated, 
                                                                    'roleName' => 'Volunteer', 
                                                                    'roleType' => 'Volunteer'])
            </x-slot>

            <x-slot:slot_admin>
                @include('roles.partials.usersTable', ['users' => $adminUsersPaginated, 
                                                                    'roleName' => 'Admin', 
                                                                    'roleType' => 'Admin'])
            </x-slot>

            <x-slot:slot_program_coordinator>
                @include('roles.partials.usersTable', ['users' => $programCoordinatorUsersPaginated, 
                                                                    'roleName' => 'Program Coordinator', 
                                                                    'roleType' => 'Program Coordinator'])
            </x-slot>

            <x-slot:slot_financial_coordinator>
                @include('roles.partials.usersTable', ['users' => $financialCoordinatorUsersPaginated, 
                                                                    'roleName' => 'Financial Coordinator', 
                                                                    'roleType' => 'Financial Coordinator'])
            </x-slot>

            <x-slot:slot_content_manager>
                @include('roles.partials.usersTable', ['users' => $contentManagerUsersPaginated, 
                                                                    'roleName' => 'Content Manager', 
                                                                    'roleType' => 'Content Manager'])
            </x-slot>

            <x-slot:slot_member>
                @include('roles.partials.usersTable', ['users' => $memberUsersPaginated, 
                                                                    'roleName' => 'Member', 
                                                                    'roleType' => 'Member'])
            </x-slot>

            <x-slot:slot_no_roles>
                @include('roles.partials.usersTable', ['users' => $usersWithoutRoles, 
                                                                    'roleName' => 'No Role', 
                                                                    'roleType' => 'no-role'])
            </x-slot>
        </x-navigation-layout.tabs-modern>
@endsection 