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
            ['id' => 'drafts', 'label' => 'Drafts', 'icon' => 'bx-edit'],
            ['id' => 'archived', 'label' => 'Archived', 'icon' => 'bx-archive'],
            ['id' => 'rejected', 'label' => 'Rejected/Needs Revision', 'icon' => 'bx-x-circle'],
        ];
        if ($user->hasRole('Content Manager')) {
            $tabs[] = ['id' => 'needs_approval', 'label' => 'Needs Approval', 'icon' => 'bx-check-circle'];
        }
    @endphp

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="my">
        <x-slot:slot_my>
            @include('content.partials.contentTable', ['contents' => $myContent])
        </x-slot>
        <x-slot:slot_published>
            @include('content.partials.contentTable', ['contents' => $publishedContent])
        </x-slot>
        <x-slot:slot_drafts>
            @include('content.partials.contentTable', ['contents' => $drafts])
        </x-slot>
        <x-slot:slot_archived>
            @include('content.partials.contentTable', ['contents' => $archived])
        </x-slot>
        <x-slot:slot_rejected>
            @include('content.partials.contentTable', ['contents' => $rejected])
        </x-slot>
        @if($user->hasRole('Content Manager'))
            <x-slot:slot_needs_approval>
                @include('content.partials.contentTable', ['contents' => $needsApproval])
            </x-slot>
        @endif
    </x-navigation-layout.tabs-modern>



@endsection
