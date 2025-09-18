@extends('layouts.sidebar_final')

@section('content')
<x-page-header
    icon="bx-group"
    title="Member Management"
    desc="Manage and view details of all members.">
</x-page-header>

    @php
        $tabs = [
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
            ['id' => 'full_pledge', 'label' => 'Full-Pledge', 'icon' => 'bx-user-check'],
            ['id' => 'honorary', 'label' => 'Honorary', 'icon' => 'bx-award'],
            ['id' => 'pending', 'label' => 'Pending Invitations', 'icon' => 'bx-mail-send'],
        ];
    @endphp

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="overview">
        <x-slot:slot_overview>
            @include('member.partials.membersOverview')
        </x-slot:slot_overview>

        <x-slot:slot_full_pledge>
            <x-search-form
                :search="$search"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
                :showSortOptions="true"
                :sortOptions="['start_date' => 'Start Date', 'name' => 'Name']"
            />
            @include('member.partials.membersTable', ['members' => $fullPledgeMembers, 'tab' => 'full_pledge'])
        </x-slot>

        <x-slot:slot_honorary>
            <x-search-form
                :search="$search"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
                :showSortOptions="true"
                :sortOptions="['start_date' => 'Start Date', 'name' => 'Name']"
            />
            @include('member.partials.membersTable', ['members' => $honoraryMembers, 'tab' => 'honorary'])
        </x-slot>

        <x-slot:slot_pending>
            <x-search-form
                :search="$search"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
                :showSortOptions="true"
                :sortOptions="['start_date' => 'Start Date', 'name' => 'Name']"
            />
            @include('member.partials.membersTable', ['members' => $pendingMembers, 'tab' => 'pending'])
        </x-slot>
    </x-navigation-layout.tabs-modern>

@endsection
