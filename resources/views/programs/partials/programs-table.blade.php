@php
    use Carbon\Carbon;
@endphp

@if($programs->isEmpty())
    <p class="text-gray-600 text-center py-4">No programs found.</p>
@else
    <div class="overflow-x-auto custom-scrollbar">
        <table class="min-w-full w-full divide-y divide-gray-200">
            <thead class="bg-[#1a2235] text-white">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">#</th>
                    <th scope="col"
                        class="px-4 py-3 text-left text-sm font-semibold cursor-pointer hover:bg-[#2a3245] transition-colors"
                        onclick="sortTable('title')">
                        <div class="flex items-center gap-1">
                            Title <i class='bx bx-sort text-xs'></i>
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Location</th>
                    <th scope="col" class="px-4 py-3 text-left text-sm font-semibold">Status</th>
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
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($programs as $program)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-800">
                            {{ $loop->iteration + ($programs->currentPage() - 1) * $programs->perPage() }}
                        </td>
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
                            @elseif(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                                <x-button href="{{ route('programs.manage_volunteers', $program) }}" variant="manage"
                                    class="tooltip" data-tip="Manage Volunteers"
                                    aria-label="Manage Volunteers for {{ $program->title }}">
                                    <i class='bx bx-group'></i>
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
@endif 