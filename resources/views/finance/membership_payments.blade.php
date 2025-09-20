@extends('layouts.sidebar_final')

@section('content')
    <x-page-header
        icon="bx-group"
        title="Membership Payments"
        desc="Track and manage membership payments for all members.
        This section provides an overview of payment statuses for each quarter, total revenue, and allows for recording new payments.">
        <div class="flex items-center gap-2">
            <a href="{{ route('finance.membership.payments.download.all', ['format' => 'csv']) }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-green-700 bg-green-100 rounded hover:bg-green-200">
                <i class='bx bx-table'></i> Export All (CSV)
            </a>
            <a href="{{ route('finance.membership.payments.download.all', ['format' => 'pdf']) }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-700 bg-red-100 rounded hover:bg-red-200">
                <i class='bx bx-file-pdf'></i> Export All (PDF)
            </a>
        </div>
    </x-page-header>

    @php
        $tabs = [
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
            ['id' => 'full_pledge', 'label' => 'Full-Pledge', 'icon' => 'bx-user-check'],
            ['id' => 'honorary', 'label' => 'Honorary', 'icon' => 'bx-award'],
        ];
    @endphp

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="overview">
        <x-slot:slot_overview>
            @include('finance.partials.membershipOverview')
        </x-slot:slot_overview>

        <x-slot:slot_full_pledge>
            <x-search-form
                :search="$search"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
                :showSortOptions="true"
                :showYear="true"
                :year="$year"
                :yearOptions="$yearOptions"
                :sortOptions="['name' => 'Name', 'created_at' => 'Date Joined']"
            />
            @include('finance.partials.paymentsTable', ['members' => $fullPledgeMembers, 'tab' => 'full_pledge', 'year' => $year])

            {{-- In pagination sections append year --}}
            {{ $fullPledgeMembers->appends([
                'tab'=>'full_pledge','search'=>$search,'sort_by'=>$sortBy,'sort_order'=>$sortOrder,'year'=>$year
            ])->links() }}
        </x-slot>

        <x-slot:slot_honorary>
            <x-search-form
                :search="$search"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
                :showSortOptions="true"
                :showYear="true"
                :year="$year"
                :yearOptions="$yearOptions"
                :sortOptions="['name' => 'Name', 'created_at' => 'Date Joined']"
            />
            @include('finance.partials.paymentsTable', ['members' => $honoraryMembers, 'tab' => 'honorary', 'year' => $year])

            {{-- In pagination sections append year --}}
            {{ $honoraryMembers->appends([
                'tab'=>'honorary','search'=>$search,'sort_by'=>$sortBy,'sort_order'=>$sortOrder,'year'=>$year
            ])->links() }}
        </x-slot>
    </x-navigation-layout.tabs-modern>
@endsection
