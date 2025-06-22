@extends('layouts.sidebar_final')

@section('content')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #666;
        }
    </style>

    <div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <div class="mb-4 sm:mb-8">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1a2235] mb-1 sm:mb-2">
                Volunteers Management
            </h1>
            <p class="text-sm sm:text-base text-gray-600">Manage volunteer applications and approved volunteers</p>
        </div>

        @php
            $tabs = [
                ['id' => 'applications', 'label' => 'Applications', 'icon' => 'bx-user-plus'],
                ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
                ['id' => 'denied', 'label' => 'Denied', 'icon' => 'bx-x-circle'],
                ['id' => 'approved', 'label' => 'Approved', 'icon' => 'bx-check-circle']
            ];
        @endphp

        <x-tabs 
            :tabs="$tabs"
            default-tab="applications"
        >
            <x-slot:slot_applications>
                @if($applications->isEmpty())
                    <p class="text-gray-600 text-center py-4">No pending applications found.</p>
                @else
                    <x-table.table containerClass="overflow-x-auto custom-scrollbar" tableClass="w-full min-w-[640px]">
                        <x-table.thead>
                            <x-table.tr :hover="false">
                                <x-table.th>Name</x-table.th>
                                <x-table.th>Email</x-table.th>
                                <x-table.th>Actions</x-table.th>
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                                @foreach($applications as $volunteer)
                                <x-table.tr>
                                    <x-table.td class="font-bold text-gray-800">{{ $volunteer->user->name }}</x-table.td>
                                    <x-table.td>{{ $volunteer->user->email }}</x-table.td>
                                    <x-table.td>
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="table-action-view" class="tooltip" data-tip="View Details">
                                                    <i class='bx bx-show'></i>
                                                </x-button>

                                                <form action="{{ route('volunteers.approve', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <x-button type="submit" variant="table-action-manage" class="tooltip" data-tip="Approve">
                                                        <i class='bx bx-check'></i>
                                                    </x-button>
                                                </form>

                                                <form action="{{ route('volunteers.deny', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <x-button type="submit" variant="table-action-danger" class="tooltip" data-tip="Deny">
                                                        <i class='bx bx-x'></i>
                                                    </x-button>
                                                </form>
                                            </div>
                                    </x-table.td>
                                </x-table.tr>
                                @endforeach
                        </x-table.tbody>
                    </x-table.table>
                @endif
            </x-slot>

            <x-slot:slot_overview>
                @include('volunteers.partials.volunteersOverview', [
                    'approvedVolunteers' => $approvedVolunteers,
                    'applications' => $applications,
                    'deniedApplications' => $deniedApplications
                ])
            </x-slot>

            <x-slot:slot_denied>
                @if($deniedApplications->isEmpty())
                    <p class="text-gray-600 text-center py-4">No denied applications found.</p>
                @else
                    <x-table.table containerClass="overflow-x-auto custom-scrollbar" tableClass="w-full min-w-[640px]">
                        <x-table.thead>
                            <x-table.tr :hover="false">
                                <x-table.th>Name</x-table.th>
                                <x-table.th>Email</x-table.th>
                                <x-table.th>Actions</x-table.th>
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                                @foreach($deniedApplications as $volunteer)
                                <x-table.tr>
                                    <x-table.td class="font-bold text-gray-800">{{ $volunteer->user->name }}</x-table.td>
                                    <x-table.td>{{ $volunteer->user->email }}</x-table.td>
                                    <x-table.td>
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="table-action-view" class="tooltip" data-tip="View Details">
                                                    <i class='bx bx-show'></i>
                                                </x-button>

                                                <form action="{{ route('volunteers.restore', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <x-button type="submit" variant="table-action-edit" class="tooltip" data-tip="Restore to Pending">
                                                        <i class='bx bx-reset'></i>
                                                    </x-button>
                                                </form>
                                            </div>
                                    </x-table.td>
                                </x-table.tr>
                                @endforeach
                        </x-table.tbody>
                    </x-table.table>
                @endif
            </x-slot>

            <x-slot:slot_approved>
                @if($approvedVolunteers->isEmpty())
                    <p class="text-gray-600 text-center py-4">No approved volunteers found.</p>
                @else
                    <x-table.table containerClass="overflow-x-auto custom-scrollbar" tableClass="w-full min-w-[640px]">
                        <x-table.thead>
                            <x-table.tr :hover="false">
                                <x-table.th>Name</x-table.th>
                                <x-table.th>Email</x-table.th>
                                <x-table.th>Joined At</x-table.th>
                                <x-table.th>Actions</x-table.th>
                            </x-table.tr>
                        </x-table.thead>
                        <x-table.tbody>
                                @foreach($approvedVolunteers as $volunteer)
                                <x-table.tr>
                                    <x-table.td class="font-bold text-gray-800">{{ $volunteer->user->name ?? 'N/A' }}</x-table.td>
                                    <x-table.td>{{ $volunteer->user->email ?? 'N/A' }}</x-table.td>
                                    <x-table.td>{{ $volunteer->created_at->format('M d, Y') }}</x-table.td>
                                    <x-table.td>
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="table-action-view" class="tooltip" data-tip="View Details">
                                                    <i class='bx bx-show'></i>
                                                </x-button>

                                            @if($volunteer->user && $volunteer->user->member)
                                                {{-- <x-button variant="disabled" class="tooltip" data-tip="Already a member" disabled>
                                                    <i class='bx bx-user-check'></i>
                                                </x-button> --}}
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
                @endif
            </x-slot>
        </x-tabs>
    </div>

    @include('volunteers.modals.invitationModal')
@endsection 