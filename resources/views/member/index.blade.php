@extends('layouts.sidebar_final')

@section('content')
<x-page-header
    icon="bx-group"
    title="Member Management"
    desc="Manage and view details of all members.">
    <div class="flex items-center gap-2">
        <button onclick="document.getElementById('memberDownloadModal').showModal()" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded hover:bg-blue-200">
            <i class='bx bx-download'></i> Export Members
        </button>
    </div>
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

    @include('finance.partials.downloadModal', [
        'modalId' => 'memberDownloadModal',
        'title' => 'Export Members',
        'description' => 'Choose your preferred format for downloading member records.',
        'options' => [
            [
                'url' => route('reports.members', ['format' => 'csv']),
                'icon' => 'bx bx-table',
                'color' => 'text-green-600',
                'title' => 'CSV Format (All Types)',
                'description' => 'Includes both full-pledge and honorary members in one file'
            ],
            [
                'url' => route('reports.members', ['format' => 'pdf', 'type' => 'full_pledge']),
                'icon' => 'bx bx-file-pdf',
                'color' => 'text-red-600',
                'title' => 'PDF - Full-Pledge Only',
                'description' => 'Professional report format for full-pledge members'
            ],
            [
                'url' => route('reports.members', ['format' => 'pdf', 'type' => 'honorary']),
                'icon' => 'bx bx-file-pdf',
                'color' => 'text-red-600',
                'title' => 'PDF - Honorary Only',
                'description' => 'Professional report format for honorary members'
            ]
        ]
    ])
@endsection
