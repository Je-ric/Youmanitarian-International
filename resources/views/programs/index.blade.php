@extends('layouts.sidebar_final')
@php
    use Carbon\Carbon;
@endphp

@section('content')
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Programs</h1>

    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif


    <div class="container mx-auto p-6">

        @if(Auth::user()->hasRole('Admin'))
            <div class="flex justify-between">
                <x-button href="{{ route('programs.create') }}" variant="add-create" class="mb-6">
                    <i class='bx bx-plus-circle mr-2'></i> Create Program
                </x-button>

            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-[#1a2235] text-white">
                    <tr>
                        {{-- <th class="px-6 py-3 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Created By</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th> --}}
                        <th class="px-6 py-3 text-left text-sm font-semibold cursor-pointer select-none">
                            @php
                                $sortField = request('sort');      // e.g. 'title'
                                $sortDirection = request('direction'); // 'asc' or 'desc'
                                $column = 'title';
                            @endphp

                            <a href="{{ request()->fullUrlWithQuery(['sort' => $column, 'direction' => ($sortField === $column && $sortDirection === 'asc') ? 'desc' : 'asc']) }}"
                                class="flex items-center gap-1">

                                Title

                                @if ($sortField === $column)
                                    @if ($sortDirection === 'asc')
                                        <i class='bx bx-sort-up text-yellow-400'></i>
                                    @else
                                        <i class='bx bx-sort-down text-yellow-400'></i>
                                    @endif
                                @else
                                    <i class='bx bx-sort text-gray-400'></i>
                                @endif

                            </a>
                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">
                            @sortablelink('created_by', 'Created By')
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">
                            Actions
                        </th>


                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($programs as $program)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#1a2235]">{{ $program->title }}</td>
                            <td class="px-6 py-4 text-sm font-semibold">

                            </td>

                            <td class="px-6 py-4 text-sm text-[#1a2235]">{{ $program->creator->name }}</td>
                            <td class="px-6 py-4 text-sm flex gap-2">
                                <x-button onclick="document.getElementById('modal_{{ $program->id }}').showModal();"
                                    variant="info" class="tooltip" data-tip="View Details">
                                    <i class='bx bx-show'></i>
                                </x-button>

                                
                                {{-- @if(Auth::user()->volunteer) --}}
                                {{-- @if(Auth::user()->hasRole('Volunteer'))
                                    <x-button href="{{ route('programs.view', $program) }}" variant="success">
                                        <i class='bx bx-show'></i>View Log
                                    </x-button> --}}
                                @if(Auth::user()->hasRole('Volunteer') && $program->volunteers->contains(Auth::user()->volunteer))
                                    <x-button href="{{ route('programs.view', $program) }}" variant="success">
                                        <i class='bx bx-show'></i> View Log
                                    </x-button>
                                @else
                                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Program Coordinator'))
                                        <x-button href="{{ route('programs.manage_volunteers', $program) }}" variant="manage"
                                            class="tooltip" data-tip="Manage Volunteers">
                                            <i class='bx bx-group'></i>
                                        </x-button>

                                        <x-button href="{{ route('programs.edit', $program) }}" variant="warning" class="tooltip"
                                            data-tip="Edit">
                                            <i class='bx bx-edit-alt'></i>
                                        </x-button>

                                        <form action="{{ route('programs.destroy', $program) }}" method="POST"
                                            id="delete-form-{{ $program->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="button" variant="danger"
                                                onclick="document.getElementById('confirm-dialog-{{ $program->id }}').showModal()"
                                                class="tooltip" data-tip="Delete">
                                                <i class='bx bx-trash'></i>
                                            </x-button>
                                        </form>

                                        <x-delete-confirmation id="confirm-dialog-{{ $program->id }}"
                                            formId="delete-form-{{ $program->id }}" title="Delete this Program?"
                                            message='"This will permanently remove the program and all its related data. This action cannot be undone. Are you sure you want to proceed?"'
                                            confirmText="Delete" cancelText="Cancel" />

                                    @endif
                                @endif
                            </td>

                        </tr>

                        <x-program-modal :program="$program" />
                        {{-- show modal --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>



        </div>


        <div class="mt-6">
            {{-- {{ $programs->links() }} --}}
            {{ $programs->appends(Request::except('page'))->links() }}

        </div>
    </div>


@endsection