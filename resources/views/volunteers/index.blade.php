@extends('layouts.sidebar_final')

@section('content')
<x-page-header
    icon="bx-calendar-event"
    title="Volunteers"
    desc="Manage volunteer applications and volunteers.">

</x-page-header>



        @php
            $tabs = [
                ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
                ['id' => 'applications', 'label' => 'Applications', 'icon' => 'bx-user-plus'],
                ['id' => 'denied', 'label' => 'Denied', 'icon' => 'bx-x-circle'],
                ['id' => 'approved', 'label' => 'Approved', 'icon' => 'bx-check-circle']
            ];
        @endphp

        <x-navigation-layout.tabs-modern
            :tabs="$tabs"
            default-tab="overview"
        >
            <x-slot:slot_overview>
                @include('volunteers.partials.volunteersOverview', [
                    'approvedVolunteers' => $approvedVolunteers,
                    'applications' => $applications,
                    'deniedApplications' => $deniedApplications
                ])
            </x-slot>

            <x-slot:slot_applications>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['created_at' => 'Date Applied', 'name' => 'Name']"
                />
                @if($applications->isEmpty())
                    <x-empty-state
                        icon="bx bx-user-plus"
                        title="No Pending Applications"
                        description="There are no new volunteer applications at the moment."
                    />
                @else
                    <x-table.table containerClass="overflow-x-auto custom-scrollbar-gold" tableClass="w-full min-w-[640px]">
                        <x-table.thead>
                            <x-table.tr :hover="false">
                                <x-table.th class="w-10 text-center">#</x-table.th>
                                <x-table.th>Name</x-table.th>
                                <x-table.th>Email</x-table.th>
                                <x-table.th>Actions</x-table.th>
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                                @foreach($applications as $volunteer)
                                <x-table.tr>
                                    <x-table.td class="w-10 text-center text-gray-500">{{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}</x-table.td>
                                    <x-table.td class="font-bold text-gray-800">{{ $volunteer->user->name }}</x-table.td>
                                    <x-table.td>{{ $volunteer->user->email }}</x-table.td>
                                    <x-table.td>
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.volunteer-details', $volunteer->id) }}" variant="table-action-view" class="tooltip" data-tip="View Details">
                                                    <i class='bx bx-dots-horizontal-rounded'></i>
                                                </x-button>

                                                {{-- <form action="{{ route('volunteers.approve', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <x-button type="submit" variant="table-action-manage" class="tooltip" data-tip="Approve">
                                                        <i class='bx bx-check'></i> Approve
                                                    </x-button>
                                                </form> --}}
                                                <x-button type="button" variant="table-action-manage" class="tooltip" data-tip="Approve"
                                                    onclick="document.getElementById('approveVolunteerModal-{{ $volunteer->id }}').showModal()">
                                                    <i class='bx bx-check'></i> Approve
                                                </x-button>

                                            {{-- <form action="{{ route('volunteers.deny', $volunteer->id) }}" method="POST" class="inline">
                                                @csrf
                                                <x-button type="submit" variant="table-action-danger" class="tooltip" data-tip="Deny">
                                                    <i class='bx bx-x'></i> Deny
                                                </x-button>
                                            </form> --}}
                                                <x-button type="button" variant="table-action-danger" class="tooltip" data-tip="Deny"
                                                    onclick="document.getElementById('denyVolunteerModal-{{ $volunteer->id }}').showModal()">
                                                    <i class='bx bx-x'></i> Deny
                                                </x-button>
                                        </div>
                                        @include('volunteers.modals.approveVolunteerModal', ['volunteer' => $volunteer])
                                        @include('volunteers.modals.denyVolunteerModal', ['volunteer' => $volunteer])
                                    </x-table.td>
                                </x-table.tr>
                                @endforeach
                        </x-table.tbody>
                    </x-table.table>
                    <div class="mt-4">{{ $applications->appends(['tab' => 'applications'])->links() }}</div>
                @endif
            </x-slot>

            <x-slot:slot_denied>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['created_at' => 'Date Applied', 'name' => 'Name']"
                />
                @if($deniedApplications->isEmpty())
                    <x-empty-state
                        icon="bx bx-x-circle"
                        title="No Denied Applications"
                        description="There are no applications that have been denied."
                    />
                @else
                    <x-table.table containerClass="overflow-x-auto custom-scrollbar-gold" tableClass="w-full min-w-[640px]">
                        <x-table.thead>
                            <x-table.tr :hover="false">
                                <x-table.th class="w-10 text-center">#</x-table.th>
                                <x-table.th>Name</x-table.th>
                                <x-table.th>Email</x-table.th>
                                <x-table.th>Actions</x-table.th>
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                                @foreach($deniedApplications as $volunteer)
                                <x-table.tr>
                                    <x-table.td class="w-10 text-center text-gray-500">{{ $loop->iteration + ($deniedApplications->currentPage() - 1) * $deniedApplications->perPage() }}</x-table.td>
                                    <x-table.td class="font-bold text-gray-800">{{ $volunteer->user->name }}</x-table.td>
                                    <x-table.td>{{ $volunteer->user->email }}</x-table.td>
                                    <x-table.td>
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.volunteer-details', $volunteer->id) }}" variant="table-action-view" class="tooltip" data-tip="View Details">
                                                    <i class='bx bx-dots-horizontal-rounded'></i>
                                                </x-button>

                                                {{-- <form action="{{ route('volunteers.restore', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <x-button type="submit" variant="table-action-edit" class="tooltip" data-tip="Restore to Pending">
                                                        <i class='bx bx-reset'></i> Restore
                                                    </x-button>
                                                </form> --}}
                                                <x-button type="button" variant="table-action-edit" class="tooltip" data-tip="Restore"
                                                    onclick="document.getElementById('restoreVolunteerModal-{{ $volunteer->id }}').showModal()">
                                                    <i class='bx bx-reset'></i> Restore
                                                </x-button>
                                            </div>

                                        @include('volunteers.modals.restoreVolunteerModal', ['volunteer' => $volunteer])
                                    </x-table.td>
                                </x-table.tr>
                                @endforeach
                        </x-table.tbody>
                    </x-table.table>
                    <div class="mt-4">{{ $deniedApplications->appends(['tab' => 'denied'])->links() }}</div>
                @endif
            </x-slot>

            <x-slot:slot_approved>
                <x-search-form
                    :search="$search"
                    :sortBy="$sortBy"
                    :sortOrder="$sortOrder"
                    :showSortOptions="true"
                    :sortOptions="['created_at' => 'Date Joined', 'name' => 'Name']"
                />
                @if($approvedVolunteers->isEmpty())
                    <x-empty-state
                        icon="bx bx-check-circle"
                        title="No Approved Volunteers"
                        description="There are no volunteers who have been approved yet."
                    />
                @else
                    <x-table.table containerClass="overflow-x-auto custom-scrollbar-gold" tableClass="w-full min-w-[640px]">
                        <x-table.thead>
                            <x-table.tr :hover="false">
                                <x-table.th class="w-10 text-center">#</x-table.th>
                                <x-table.th>Name</x-table.th>
                                <x-table.th>Email</x-table.th>
                                <x-table.th class="text-right">Total Hours</x-table.th>
                                <x-table.th>Joined At</x-table.th>
                                <x-table.th>Actions</x-table.th>
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                                @foreach($approvedVolunteers as $volunteer)
                                <x-table.tr>
                                    <x-table.td class="w-10 text-center text-gray-500">{{ $loop->iteration + ($approvedVolunteers->currentPage() - 1) * $approvedVolunteers->perPage() }}</x-table.td>
                                    <x-table.td class="font-bold text-gray-800">{{ $volunteer->user->name ?? 'N/A' }}</x-table.td>
                                    <x-table.td>{{ $volunteer->user->email ?? 'N/A' }}</x-table.td>
                                    <x-table.td class="text-right font-semibold">{{ number_format($volunteer->calculated_total_hours, 2) }}</x-table.td>
                                    <x-table.td>{{ $volunteer->created_at->format('M d, Y') }}</x-table.td>
                                    <x-table.td>
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.volunteer-details', $volunteer->id) }}" variant="table-action-view" class="tooltip" data-tip="View Details">
                                                    <i class='bx bx-dots-horizontal-rounded'></i>
                                                </x-button>

                                            @if($volunteer->user && $volunteer->user->member)
                                                <x-button variant="disabled" class="tooltip" data-tip="Already a member" disabled>
                                                    <i class='bx bx-user-check'></i>
                                                </x-button>
                                            @else
                                                <x-button
                                                    variant="table-action-manage"
                                                    class="tooltip"
                                                    data-tip="Invite to be Member"
                                                    onclick="
                                                        const modal = document.getElementById('invitationModal');
                                                        const form = document.getElementById('invitationForm');
                                                        form.action = '{{ route('members.invite', $volunteer->id) }}';
                                                        form.method = 'POST';
                                                        modal.showModal();
                                                    ">
                                                    <i class='bx bx-mail-send'></i>
                                                    </x-button>
                                            @endif
                                            </div>
                                    </x-table.td>
                                </x-table.tr>
                                @endforeach
                        </x-table.tbody>
                    </x-table.table>
                    <div class="mt-4">{{ $approvedVolunteers->appends(['tab' => 'approved'])->links() }}</div>
                @endif
            </x-slot>
        </x-navigation-layout.tabs-modern>

    @include('volunteers.modals.invitationModal', ['volunteer' => $volunteer])

    <style>
    </style>
@endsection
