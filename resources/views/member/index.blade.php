@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Member Management</h1>
    
    </div>

    @php
        $tabs = [
            ['id' => 'overview', 'label' => 'Members Overview', 'icon' => 'bx-group'],
            ['id' => 'full_pledge', 'label' => 'Full-Pledge', 'icon' => 'bx-user-check'],
            ['id' => 'honorary', 'label' => 'Honorary', 'icon' => 'bx-award'],
            ['id' => 'pending', 'label' => 'Pending Invitations', 'icon' => 'bx-mail-send'],
        ];
        $activeTab = $tab ?? 'overview';
    @endphp

    <x-navigation-layout.tabs :tabs="$tabs" default-tab="{{ $activeTab }}">
        <x-slot:slot_overview>
            @include('member.partials.membersOverview')
        </x-slot:slot_overview>

        <x-slot:slot_full_pledge>
            @include('member.partials.members_table', ['members' => $fullPledgeMembers])
        </x-slot>

        <x-slot:slot_honorary>
            @include('member.partials.members_table', ['members' => $honoraryMembers])
        </x-slot>

        <x-slot:slot_pending>
            @include('member.partials.members_table', ['members' => $pendingMembers])
        </x-slot>
    </x-navigation-layout.tabs>
</div>


@endsection 