@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-calendar-event" title="Programs" desc="View and manage all programs.">
        @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
            <x-button href="{{ route('programs.create') }}" variant="primary">
                <i class='bx bx-plus-circle mr-2'></i> Create Program
            </x-button>
        @endif
    </x-page-header>

    <div x-data="{
            openModal(id) {
                document.getElementById('modal_' + id).showModal();
            }
        }">

        @php
            $tabs = [
                ['id' => 'all', 'label' => 'All Programs', 'icon' => 'bx-list-ul']
            ];

            if (Auth::user()->hasRole('Volunteer')) {
                $tabs[] = ['id' => 'joined', 'label' => 'Joined Programs', 'icon' => 'bx-user-check'];
            }

            if (Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin')) {
                $tabs[] = ['id' => 'my', 'label' => 'My Programs', 'icon' => 'bx-cog'];
            }
        @endphp

        <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="all">
            <x-slot:slot_all>
                <div id="slot_all">
                    <x-search-form
                        :search="$search"
                        :sortBy="$sortBy"
                        :sortOrder="$sortOrder"
                        :showSortOptions="true"
                        :sortOptions="['date' => 'Date', 'title' => 'Title', 'created_at' => 'Date Created']"
                    />
                    @include('programs.partials.programsTable', ['programs' => $allPrograms, 'tab' => 'all'])
                </div>
            </x-slot>

            @if(Auth::user()->hasRole('Volunteer'))
                <x-slot:slot_joined>
                    <div id="slot_joined">
                        <x-search-form
                            :search="$search"
                            :sortBy="$sortBy"
                            :sortOrder="$sortOrder"
                            :showSortOptions="true"
                            :sortOptions="['date' => 'Date', 'title' => 'Title', 'created_at' => 'Date Created']"
                        />
                        @include('programs.partials.programsTable', ['programs' => $joinedPrograms, 'tab' => 'joined'])
                    </div>
                </x-slot>
            @endif

            @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                <x-slot:slot_my>
                    <div id="slot_my">
                        <x-search-form
                            :search="$search"
                            :sortBy="$sortBy"
                            :sortOrder="$sortOrder"
                            :showSortOptions="true"
                            :sortOptions="['date' => 'Date', 'title' => 'Title', 'created_at' => 'Date Created']"
                        />
                        @include('programs.partials.programsTable', ['programs' => $myPrograms, 'tab' => 'my'])
                    </div>
                </x-slot>
            @endif
        </x-navigation-layout.tabs-modern>

        @php
            $uniquePrograms = collect($allPrograms->items())
                ->merge(optional($joinedPrograms)->items())
                ->merge(optional($myPrograms)->items())
                ->unique('id');
        @endphp

        {{-- Modals Container --}}
        {{-- If this, viewModal isnt opening --}}
        {{-- @foreach($uniquePrograms as $program)
            @if(Auth::id() === $program->created_by)
                @include('programs.modals.deleteProgramModal', [
                    'program' => $program,
                    'modalId' => 'delete-program-modal-' . $program->id
                ])
            @endif
        @endforeach --}}

        <div>
            @foreach($allPrograms as $program)
                @include('programs.modals.program-modal',
                            ['program' => $program])
            @endforeach
            @if(Auth::user()->hasRole('Volunteer'))
                @foreach($joinedPrograms as $program)
                    @include('programs.modals.program-modal',
                            ['program' => $program])
                @endforeach
            @endif
            @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                @foreach($myPrograms as $program)
                    @if(Auth::id() === $program->created_by)
                        @include('programs.modals.deleteProgramModal',
                            ['program' => $program,
                            'modalId' => 'delete-program-modal-' . $program->id])
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).on('submit', '.delete-program-form', function(e) {
    e.preventDefault();

    const form = $(this);
    const modalId = form.data('modal-id');

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize() + '&_method=DELETE',
        success: function(response) {
            if (!response.success) return;

            const programId = response.program_id ?? form.data('program-id');

            // 1) Remove any row with this program id across all tabs
            const $rows = $(`.program-row[data-program-id="${programId}"]`);
            if ($rows.length) {
                $rows.fadeOut(200, function() { $(this).remove(); });
            }

            // 2) Optionally refresh only the active tab’s content (to update pagination/count)
            // const activeTabEl = document.querySelector('[role="tab"][aria-selected="true"]');
            // const tabId = activeTabEl?.dataset?.tab || 'all';
            // const slotId = `#slot_${tabId}`;
            // if (document.querySelector(slotId)) {
            //     $(slotId).load(location.href + ` ${slotId} > *`);
            // }
            ['all','joined','my'].forEach(tabId => {
                const slotId = `#slot_${tabId}`;
                if (document.querySelector(slotId)) {
                    $(slotId).load(location.href + ` ${slotId} > *`);
                }
            });

            // 3) Close modal
            if (modalId) {
                const dlg = document.getElementById(modalId);
                if (dlg?.close) dlg.close();
            }

            console.log('Program deleted successfully.');
        },
        error: function() {
            console.error('Failed to delete program. Please try again.');
        }
    });
});
</script>
@endpush

