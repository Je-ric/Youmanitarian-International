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
        $isCoordinator = $user->hasRole('Program Coordinator');
        $isManager = $user->hasRole('Content Manager');
        $isAdmin = $user->hasRole('Admin');

        $tabs = [ //all
            ['id' => 'my', 'label' => 'My Content', 'icon' => 'bx-user'],
            ['id' => 'published', 'label' => 'Published', 'icon' => 'bx-globe'],
        ];

        // arcchive para lang kay $isCoordinator || $isAdm
        if ($isManager || $isAdmin) {
            $tabs[] = ['id' => 'archived', 'label' => 'Archived', 'icon' => 'bx-archive'];
        }

        // kay program coordinator lang, since siya lang need ng approval when creating content.
        if ($isCoordinator && !$isAdmin && !$isManager) {
            $tabs[] = ['id' => 'submitted', 'label' => 'Submitted', 'icon' => 'bx-upload'];
            $tabs[] = ['id' => 'needs_revision', 'label' => 'Needs Revision', 'icon' => 'bx-refresh'];
        }

        // then dito opposite ng nasa taas, since sila yung privileged to approve content.
        if ($isManager || $isAdmin) {
            $tabs[] = ['id' => 'needs_approval', 'label' => 'Needs Approval', 'icon' => 'bx-check-circle'];
        }
    @endphp

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="my">
        <x-slot:slot_my>
            <x-feedback-status.alert
                type="info"
                message="This tab lists only the content you created. Drafts are editable; published items are read-only unless updated."
            />
            <x-search-form
                :search="$search"
                :dateFilter="$dateFilter"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
                :showDateFilter="true"
                :showSortOptions="true"
                :sortOptions="['created_at' => 'Date Created', 'updated_at' => 'Date Updated', 'title' => 'Title']"
            />
            @include('content.partials.contentTable', ['contents' => $myContent, 'tab' => 'my'])
        </x-slot>

        <x-slot:slot_published>
            <x-feedback-status.alert
                type="neutral"
                message="All published content visible to users. Editing creates an updated version if workflow requires review."
            />
            <x-search-form
                :search="$search"
                :dateFilter="$dateFilter"
                :sortBy="$sortBy"
                :sortOrder="$sortOrder"
                :showDateFilter="true"
                :showSortOptions="true"
                :sortOptions="['created_at' => 'Date Created', 'updated_at' => 'Date Updated', 'title' => 'Title']"
            />
            @include('content.partials.contentTable', ['contents' => $publishedContent, 'tab' => 'published'])
        </x-slot>

        @if($isManager || $isAdmin)
            <x-slot:slot_archived>
                <x-feedback-status.alert
                    type="warning"
                    message="Archived content is hidden from public views. You can restore it by editing and republishing."
                />
                <x-search-form
                    :search="$search"
                    :dateFilter="$dateFilter"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showDateFilter="true"
                    :showSortOptions="true"
                    :sortOptions="['created_at' => 'Date Created', 'updated_at' => 'Date Updated', 'title' => 'Title']"
                />
                @include('content.partials.contentTable', ['contents' => $archived, 'tab' => 'archived'])
            </x-slot>
        @endif

        @if($isCoordinator && !$isAdmin && !$isManager)
            <x-slot:slot_submitted>
                <x-feedback-status.alert
                    type="info"
                    message="Submitted items are waiting for a Content Manager to review. You can still edit before approval."
                />
                <x-search-form
                    :search="$search"
                    :dateFilter="$dateFilter"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showDateFilter="true"
                    :showSortOptions="true"
                    :sortOptions="['created_at' => 'Date Created', 'updated_at' => 'Date Updated', 'title' => 'Title']"
                />
                @include('content.partials.contentTable', ['contents' => $submitted, 'tab' => 'submitted'])
            </x-slot>

            <x-slot:slot_needs_revision>
                <x-feedback-status.alert
                    type="warning"
                    message="These items were sent back for revision. Update them and resubmit for approval."
                />
                <x-search-form
                    :search="$search"
                    :dateFilter="$dateFilter"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showDateFilter="true"
                    :showSortOptions="true"
                    :sortOptions="['created_at' => 'Date Created', 'updated_at' => 'Date Updated', 'title' => 'Title']"
                />
                @include('content.partials.contentTable', ['contents' => $needsRevision, 'tab' => 'needs_revision'])
            </x-slot>
        @endif

        @if($isManager || $isAdmin)
            <x-slot:slot_needs_approval>
                <x-feedback-status.alert
                    type="info"
                    message="Queue of content awaiting your approval. Approve, request revision, or reject."
                />
                <x-search-form
                    :search="$search"
                    :dateFilter="$dateFilter"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showDateFilter="true"
                    :showSortOptions="true"
                    :sortOptions="['created_at' => 'Date Created', 'updated_at' => 'Date Updated', 'title' => 'Title']"
                />
                @include('content.partials.contentTable', ['contents' => $needsApproval, 'tab' => 'needs_approval'])
            </x-slot>
        @endif
    </x-navigation-layout.tabs-modern>
@endsection
