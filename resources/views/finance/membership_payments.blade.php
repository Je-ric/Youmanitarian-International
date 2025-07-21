@extends('layouts.sidebar_final')

@section('content')
    <x-page-header
        icon="bx-group"
        title="Membership Payments"
        desc="Track and manage membership payments for all members.
        This section provides an overview of payment statuses for each quarter, total revenue, and allows for recording new payments.">
    </x-page-header>

    @php
        $tabs = [
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
            ['id' => 'full_pledge', 'label' => 'Full-Pledge', 'icon' => 'bx-user-check'],
            ['id' => 'honorary', 'label' => 'Honorary', 'icon' => 'bx-award'],
        ];
        $activeTab = $tab ?? 'full_pledge';
    @endphp

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="{{ $activeTab }}">
        <x-slot:slot_overview>
            @include('finance.partials.membershipOverview')
        </x-slot:slot_overview>

        <x-slot:slot_full_pledge>
            @include('finance.partials.paymentsTable', ['members' => $fullPledgeMembers])
        </x-slot>

        <x-slot:slot_honorary>
            @include('finance.partials.paymentsTable', ['members' => $honoraryMembers])
        </x-slot>
    </x-navigation-layout.tabs-modern>
@endsection
