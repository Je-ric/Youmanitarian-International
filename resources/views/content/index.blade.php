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
        $tabs = [
            ['id' => 'my', 'label' => 'My Content', 'icon' => 'bx-user'],
            ['id' => 'published', 'label' => 'Published', 'icon' => 'bx-globe'],
            ['id' => 'archived', 'label' => 'Archived', 'icon' => 'bx-archive'],
        ];
        if ($user->hasRole('Program Coordinator')) {
            $tabs[] = ['id' => 'submitted', 'label' => 'Submitted', 'icon' => 'bx-upload'];
            $tabs[] = ['id' => 'needs_revision', 'label' => 'Needs Revision', 'icon' => 'bx-refresh'];
        }
        if ($user->hasRole('Content Manager')) {
            $tabs[] = ['id' => 'needs_approval', 'label' => 'Needs Approval', 'icon' => 'bx-check-circle'];
        }
    @endphp

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="my">
        <x-slot:slot_my>
            @include('content.partials.contentTable', ['contents' => $myContent, 'tab' => 'my'])
        </x-slot>
        <x-slot:slot_published>
            @include('content.partials.contentTable', ['contents' => $publishedContent, 'tab' => 'published'])
        </x-slot>
        <x-slot:slot_archived>
            @include('content.partials.contentTable', ['contents' => $archived, 'tab' => 'archived'])
        </x-slot>
        @if($user->hasRole('Program Coordinator'))
            <x-slot:slot_needs_revision>
                @include('content.partials.contentTable', ['contents' => $needsRevision, 'tab' => 'needs_revision'])
            </x-slot>
            <x-slot:slot_submitted>
                @include('content.partials.contentTable', ['contents' => $submitted, 'tab' => 'submitted'])
            </x-slot>
        @endif
        @if($user->hasRole('Content Manager'))
            <x-slot:slot_needs_approval>
                @include('content.partials.contentTable', ['contents' => $needsApproval, 'tab' => 'needs_approval'])
            </x-slot>
        @endif
    </x-navigation-layout.tabs-modern>


@endsection
