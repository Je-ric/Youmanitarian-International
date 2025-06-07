@extends('layouts.sidebar_final')

@php
    use Carbon\Carbon;
@endphp

@section('content')



    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif

    <div class="container mx-auto p-4 sm:p-6">

        <x-header-with-button title="Any Title" description="Description that match with the shown content.">
            @if(Auth::user()->hasRole(['Admin', 'Program Coordinator']))
                <div class="flex justify-end mb-4">
                    <x-button href="{{ route('programs.create') }}" variant="primary">
                        <i class='bx bx-plus-circle mr-2'></i> Create Program
                    </x-button>
                </div>
            @endif
        </x-header-with-button>

        <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                        <input type="text" id="searchInput" placeholder="Search programs..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-full lg:w-48">
                    <select id="statusFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="incoming">Incoming</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="done">Done</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div class="w-full lg:w-48">
                    <select id="sortFilter" class="hidden"></select>
                    <input type="date" id="dateFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Clear Filters -->
                <button id="clearFilters"
                    class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class='bx bx-x'></i> Clear
                </button>
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-200 rounded-md">
            <table class="min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-[#1a2235] text-white">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">#</th>
                        {{-- <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Title</th> --}}
                        <th scope="col"
                            class="px-4 py-3 text-left text-sm font-semibold cursor-pointer hover:bg-[#2a3245] transition-colors"
                            onclick="sortTable('title')">
                            <div class="flex items-center gap-1">
                                Title <i class='bx bx-sort text-xs'></i>
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Location</th>
                        <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                        {{-- <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Date</th> --}}
                        <th scope="col"
                            class="px-4 py-3 text-left text-sm font-semibold cursor-pointer hover:bg-[#2a3245] transition-colors"
                            onclick="sortTable('date')">
                            <div class="flex items-center gap-1">
                                Date <i class='bx bx-sort text-xs'></i>
                            </div>
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100" id="programsTableBody">
                    @foreach($programs as $program)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-800">
                                {{ $loop->iteration + ($programs->currentPage() - 1) * $programs->perPage() }}</td>
                            <td class="px-4 py-3 text-sm text-gray-800 font-medium">{{ $program->title }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $program->location ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm">
                                <x-programProgress :program="$program" />
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ Carbon::parse($program->date)->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm flex flex-wrap gap-2">

                                <x-button onclick="document.getElementById('modal_{{ $program->id }}').showModal();"
                                    variant="info" class="tooltip" data-tip="View Details"
                                    aria-label="View Details for {{ $program->title }}">
                                    <i class='bx bx-show'></i>
                                </x-button>

                                @if(Auth::user()->hasRole('Volunteer') && $program->volunteers->contains(Auth::user()->volunteer))
                                    <x-button href="{{ route('programs.view', $program) }}" variant="success"
                                        aria-label="View Log for {{ $program->title }}">
                                        <i class='bx bx-show'></i> View Log
                                    </x-button>
                                @elseif(Auth::user()->hasRole(['Admin', 'Program Coordinator']))
                                    <x-button href="{{ route('programs.manage_volunteers', $program) }}" variant="manage"
                                        class="tooltip" data-tip="Manage Volunteers"
                                        aria-label="Manage Volunteers for {{ $program->title }}">
                                        <i class='bx bx-group'></i>
                                    </x-button>

                                    <x-button href="{{ route('programs.edit', $program) }}" variant="warning" class="tooltip"
                                        data-tip="Edit" aria-label="Edit {{ $program->title }}">
                                        <i class='bx bx-edit-alt'></i>
                                    </x-button>

                                    <form action="{{ route('programs.destroy', $program) }}" method="POST"
                                        id="delete-form-{{ $program->id }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="button" variant="danger"
                                            onclick="document.getElementById('confirm-dialog-{{ $program->id }}').showModal()"
                                            class="tooltip" data-tip="Delete" aria-label="Delete {{ $program->title }}">
                                            <i class='bx bx-trash'></i>
                                        </x-button>
                                    </form>

                                    <x-delete-confirmation id="confirm-dialog-{{ $program->id }}"
                                        formId="delete-form-{{ $program->id }}" title="Delete this Program?"
                                        message='"This will permanently remove the program and all its related data. This action cannot be undone. Are you sure you want to proceed?"'
                                        confirmText="Delete" cancelText="Cancel" />
                                @endif
                            </td>
                        </tr>

                        @include('programs.modals.program-modal', ['program' => $program])
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $programs->appends(Request::except('page'))->links() }}
        </div>
    </div>

    <script>
        function filterPrograms() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const dateFilter = document.getElementById('dateFilter');

            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            const dateValue = dateFilter.value;

            const tableRows = document.querySelectorAll('#programsTableBody tr');
            const cardItems = document.querySelectorAll('#programsCardContainer > div');

            tableRows.forEach(row => {
                const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const location = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const status = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                const dateText = row.querySelector('td:nth-child(5)').textContent.trim();
                const dateObj = new Date(dateText);
                const filterDate = dateValue ? new Date(dateValue) : null;

                const matchesSearch = title.includes(searchTerm) || location.includes(searchTerm);
                const matchesStatus = !statusValue || status.includes(statusValue);

                let matchesDate = true;
                if (filterDate) {
                    matchesDate = dateObj.toDateString() === filterDate.toDateString();
                }

                row.style.display = matchesSearch && matchesStatus && matchesDate ? '' : 'none';
            });

            cardItems.forEach(card => {
                const title = card.querySelector('h3')?.textContent.toLowerCase() ?? '';
                const location = card.querySelector('.bx-map')?.nextElementSibling?.textContent.toLowerCase() ?? '';
                const status = card.querySelector('[class*="badge"]')?.textContent.toLowerCase() ?? '';
                const dateText = card.querySelector('.bx-calendar')?.nextElementSibling?.textContent.trim() ?? '';
                const dateObj = new Date(dateText);
                const filterDate = dateValue ? new Date(dateValue) : null;

                const matchesSearch = title.includes(searchTerm) || location.includes(searchTerm);
                const matchesStatus = !statusValue || status.includes(statusValue);

                let matchesDate = true;
                if (filterDate) {
                    matchesDate = dateObj.toDateString() === filterDate.toDateString();
                }

                card.style.display = matchesSearch && matchesStatus && matchesDate ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const dateFilter = document.getElementById('dateFilter');
            const clearFilters = document.getElementById('clearFilters');

            searchInput.addEventListener('input', filterPrograms);
            statusFilter.addEventListener('change', filterPrograms);
            dateFilter.addEventListener('change', filterPrograms);

            clearFilters.addEventListener('click', function () {
                searchInput.value = '';
                statusFilter.value = '';
                dateFilter.value = '';
                filterPrograms();
            });
        });
    </script>

@endsection