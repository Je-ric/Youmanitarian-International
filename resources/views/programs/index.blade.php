@extends('layouts.sidebar_final')

@section('content')

    <div x-data="{ 
        openModal(id) {
            document.getElementById('modal_' + id).showModal();
        }
    }" class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <div class="mb-4 sm:mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                        Programs
                    </h1>
                    <p class="text-gray-600">View and manage all programs.</p>
                </div>
                
                @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                    <div class="flex gap-3 w-full lg:w-auto">
                        <x-button href="{{ route('programs.create') }}" variant="primary">
                            <i class='bx bx-plus-circle mr-2'></i> Create Program
                        </x-button>
                    </div>
                @endif
            </div>
        </div>

        @php
            $tabs = [
                ['id' => 'all', 'label' => 'All Programs', 'icon' => 'bx-list-ul']
            ];

            if(Auth::user()->hasRole('Volunteer')) {
                $tabs[] = ['id' => 'joined', 'label' => 'Joined Programs', 'icon' => 'bx-user-check'];
            }

            if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin')) {
                $tabs[] = ['id' => 'my', 'label' => 'My Programs', 'icon' => 'bx-cog'];
            }
        @endphp

        <x-navigation-layout.tabs
            :tabs="$tabs"
            default-tab="all"
        >
            <x-slot:slot_all>
                @include('programs.partials.programsTable', ['programs' => $allPrograms])
            </x-slot>

            @if(Auth::user()->hasRole('Volunteer'))
                <x-slot:slot_joined>
                    @include('programs.partials.programsTable', ['programs' => $joinedPrograms])
                </x-slot>
            @endif

            @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                <x-slot:slot_my>
                    @include('programs.partials.programsTable', ['programs' => $myPrograms])
                </x-slot>
            @endif
        </x-navigation-layout.tabs>
        
        @php
            $uniquePrograms = collect($allPrograms->items())
                ->merge(optional($joinedPrograms)->items())
                ->merge(optional($myPrograms)->items())
                ->unique('id');
        @endphp

        <!-- Modals Container -->
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