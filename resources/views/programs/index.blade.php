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
                @include('programs.partials.programsTable', ['programs' => $allPrograms, 'tab' => 'all'])
                </x-slot>

                @if(Auth::user()->hasRole('Volunteer'))
                    <x-slot:slot_joined>
                        @include('programs.partials.programsTable', ['programs' => $joinedPrograms, 'tab' => 'joined'])
                        </x-slot>
                @endif

                    @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                        <x-slot:slot_my>
                            @include('programs.partials.programsTable', ['programs' => $myPrograms, 'tab' => 'my'])
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
        <div>
            @foreach($allPrograms as $program)
                @include('programs.modals.program-modal', ['program' => $program])
            @endforeach
            @if(Auth::user()->hasRole('Volunteer'))
                @foreach($joinedPrograms as $program)
                    @include('programs.modals.program-modal', ['program' => $program])
                @endforeach
            @endif
            @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                @foreach($myPrograms as $program)
                    @if(Auth::id() === $program->created_by)
                        @include('programs.modals.deleteProgramModal', ['program' => $program, 'modalId' => 'delete-program-modal-' . $program->id])
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endsection
