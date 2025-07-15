@php
    use Carbon\Carbon;
@endphp

@if($programs->isEmpty())
    <p class="text-gray-600 text-center py-4">No programs found.</p>
@else
    <x-table.table containerClass="overflow-x-auto custom-scrollbar-gold" tableClass="w-full">
        <x-table.thead>
            <x-table.tr :hover="false">
                <x-table.th class="w-10 text-center">#</x-table.th>
                <x-table.th class="cursor-pointer hover:bg-gray-200/50 transition-colors" onclick="sortTable('title')">
                    <div class="flex items-center gap-1">
                        Title <i class='bx bx-sort text-sm text-gray-400'></i>
                    </div>
                </x-table.th>
                <x-table.th>Location</x-table.th>
                <x-table.th>Status</x-table.th>
                <x-table.th class="cursor-pointer hover:bg-gray-200/50 transition-colors" onclick="sortTable('date')">
                    <div class="flex items-center gap-1">
                        Date <i class='bx bx-sort text-sm text-gray-400'></i>
                    </div>
                </x-table.th>
                <x-table.th>Actions</x-table.th>
            </x-table.tr>
        </x-table.thead>
        <x-table.tbody class="bg-white">
            @foreach($programs as $program)
                <x-table.tr>
                    <x-table.td class="w-10 text-center text-gray-500">
                        {{ $loop->iteration + ($programs->currentPage() - 1) * $programs->perPage() }}
                    </x-table.td>
                    <x-table.td class="font-bold text-gray-800">{{ $program->title }}</x-table.td>
                    <x-table.td>{{ $program->location ?? 'N/A' }}</x-table.td>
                    <x-table.td>
                        <x-feedback-status.programProgress :program="$program" />
                    </x-table.td>
                    <x-table.td>
                        {{ Carbon::parse($program->date)->format('M d, Y') }}
                    </x-table.td>
                    <x-table.td class="flex flex-wrap gap-2">
                        <!-- View Details Button (Available to all) -->
                        <x-button @click="openModal({{ $program->id }})" {{-- Pass ID to the function --}}
                            variant="table-action-view" class="tooltip" data-tip="View Details"
                            aria-label="View Details for {{ $program->title }}">
                            <i class='bx bx-dots-horizontal-rounded'></i>
                        </x-button>

                        @if(Auth::user()->hasRole('Volunteer'))
                            @if($program->volunteers->contains(Auth::user()->volunteer))
                                <x-button href="{{ route('programs.view', $program) }}" variant="table-action-manage"
                                    class="tooltip" data-tip="View Log"
                                    aria-label="View Log for {{ $program->title }}">
                                    <i class='bx bx-history'></i>
                                </x-button>
                            @endif
                        @endif

                        @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                            @if(Auth::id() === $program->created_by)
                                <!-- Manage Volunteers Button (For program creator) -->
                                <x-button href="{{ route('programs.manage_volunteers', $program) }}" variant="table-action-manage"
                                    class="tooltip" data-tip="Manage Volunteers"
                                    aria-label="Manage Volunteers for {{ $program->title }}">
                                    <i class='bx bx-group'></i>
                                </x-button>

                                <!-- Delete Button (For program creator) -->
                                <x-button type="button" variant="table-action-danger"
                                    onclick="document.getElementById('delete-program-modal-{{ $program->id }}').showModal()"
                                    class="tooltip" data-tip="Delete"
                                    aria-label="Delete {{ $program->title }}">
                                    <i class='bx bx-trash'></i>
                                </x-button>
                            @endif
                        @endif
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table.table>

    <div class="mt-6">
        {{ $programs->appends(Request::except('page'))->links() }}
    </div>
@endif 