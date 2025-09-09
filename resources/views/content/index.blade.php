@extends('layouts.sidebar_final')

@section('content')
<x-page-header icon="bx-file" title="Content Management"
    desc="View, create, and manage all site content, articles, and media.">

    <x-button href="{{ route('content.create') }}" variant="add-create" class="mb-6">
        <i class='bx bx-plus-circle mr-2'></i> Add Content
    </x-button>
</x-page-header>

@php
    $user = Auth::user();

    // Top-level role tabs
    $roleTabs = [];

    // Everyone sees general content
    $generalTabs = [
        ['id' => 'my', 'label' => 'My Content', 'icon' => 'bx-user'],
        ['id' => 'published', 'label' => 'Published', 'icon' => 'bx-globe'],
        ['id' => 'archived', 'label' => 'Archived', 'icon' => 'bx-archive'],
    ];

    $roleTabs[] = ['id' => 'general', 'label' => 'General', 'icon' => 'bx-grid-alt'];

    // Program Coordinator
    if ($user->hasRole('Program Coordinator')) {
        $roleTabs[] = ['id' => 'coordinator', 'label' => 'Program Coordinator', 'icon' => 'bx-user-check'];
    }

    // Content Manager
    if ($user->hasRole('Content Manager')) {
        $roleTabs[] = ['id' => 'manager', 'label' => 'Content Manager', 'icon' => 'bx-shield'];
    }
@endphp

{{-- Top-level role tabs --}}
<x-navigation-layout.tabs-modern :tabs="$roleTabs" default-tab="general">
    {{-- General content --}}
    <x-slot:slot_general>
        <x-navigation-layout.tabs-modern :tabs="$generalTabs" default-tab="my">
            <x-slot:slot_my>
                @include('content.partials.contentTable', ['contents' => $myContent, 'tab' => 'my'])
            </x-slot>
            <x-slot:slot_published>
                @include('content.partials.contentTable', ['contents' => $publishedContent, 'tab' => 'published'])
            </x-slot>
            <x-slot:slot_archived>
                @include('content.partials.contentTable', ['contents' => $archived, 'tab' => 'archived'])
            </x-slot>
        </x-navigation-layout.tabs-modern>
    </x-slot>

    {{-- Program Coordinator content --}}
    @if($user->hasRole('Program Coordinator'))
        @php
            $coordinatorTabs = [
                ['id' => 'submitted', 'label' => 'Submitted', 'icon' => 'bx-upload'],
                ['id' => 'needs_revision', 'label' => 'Needs Revision', 'icon' => 'bx-refresh'],
            ];
        @endphp
        <x-slot:slot_coordinator>
            <x-navigation-layout.tabs-modern :tabs="$coordinatorTabs" default-tab="submitted">
                <x-slot:slot_submitted>
                    @include('content.partials.contentTable', ['contents' => $submitted, 'tab' => 'submitted'])
                </x-slot>
                <x-slot:slot_needs_revision>
                    @include('content.partials.contentTable', ['contents' => $needsRevision, 'tab' => 'needs_revision'])
                </x-slot>
            </x-navigation-layout.tabs-modern>
        </x-slot>
    @endif

    {{-- Content Manager content --}}
    @if($user->hasRole('Content Manager'))
        @php
            $managerTabs = [
                ['id' => 'needs_approval', 'label' => 'Needs Approval', 'icon' => 'bx-check-circle'],
            ];
        @endphp
        <x-slot:slot_manager>
            <x-navigation-layout.tabs-modern :tabs="$managerTabs" default-tab="needs_approval">
                <x-slot:slot_needs_approval>
                    @include('content.partials.contentTable', ['contents' => $needsApproval, 'tab' => 'needs_approval'])
                </x-slot>
            </x-navigation-layout.tabs-modern>
        </x-slot>
    @endif
</x-navigation-layout.tabs-modern>
@endsection
