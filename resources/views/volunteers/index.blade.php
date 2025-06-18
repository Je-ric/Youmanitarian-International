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

        @if (session('toast'))
            <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
        @endif

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
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full min-w-[640px]">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 text-left">Name</th>
                                    <th class="p-3 text-left">Email</th>
                                    <th class="p-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $volunteer)
                                    <tr class="border-t">
                                        <td class="p-3">{{ $volunteer->user->name }}</td>
                                        <td class="p-3">{{ $volunteer->user->email }}</td>
                                        <td class="p-3">
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info" class="tooltip"
                                                    data-tip="View Details">
                                                    <i class='bx bx-show'></i> View
                                                </x-button>

                                                <form action="{{ route('volunteers.approve', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                </form>

                                                <form action="{{ route('volunteers.deny', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">Deny</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-slot>

            <x-slot:slot_overview>
                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <!-- Total Volunteers -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600">Total Volunteers</p>
                                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $approvedVolunteers->count() }}</h3>
                            </div>
                            <div class="bg-blue-50 p-2 sm:p-3 rounded-full">
                                <i class='bx bx-user text-xl sm:text-2xl text-blue-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Applications -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600">Pending Applications</p>
                                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $applications->count() }}</h3>
                            </div>
                            <div class="bg-yellow-50 p-2 sm:p-3 rounded-full">
                                <i class='bx bx-time text-xl sm:text-2xl text-yellow-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Denied Applications -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600">Denied Applications</p>
                                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $deniedApplications->count() }}</h3>
                            </div>
                            <div class="bg-red-50 p-2 sm:p-3 rounded-full">
                                <i class='bx bx-x-circle text-xl sm:text-2xl text-red-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Approval Rate -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600">Approval Rate</p>
                                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">
                                    @php
                                        $total = $approvedVolunteers->count() + $deniedApplications->count();
                                        echo $total > 0 ? round(($approvedVolunteers->count() / $total) * 100) : 0;
                                    @endphp%
                                </h3>
                            </div>
                            <div class="bg-green-50 p-2 sm:p-3 rounded-full">
                                <i class='bx bx-trending-up text-xl sm:text-2xl text-green-500'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm mt-6">
                    <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Recent Activity</h3>
                    <div class="space-y-3 sm:space-y-4">
                        @php
                            $allVolunteers = collect([$applications, $deniedApplications, $approvedVolunteers])
                                ->flatten()
                                ->sortByDesc('updated_at')
                                ->take(5);
                        @endphp

                        @forelse($allVolunteers as $volunteer)
                            <div class="flex items-center justify-between border-b pb-2 sm:pb-3 last:border-0">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class='bx bx-user text-lg sm:text-xl text-gray-500'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm sm:text-base font-medium text-[#1a2235]">{{ $volunteer->user->name }}</p>
                                        <p class="text-xs sm:text-sm text-gray-600">
                                            @if($volunteer->application_status === 'pending')
                                                Application submitted
                                            @elseif($volunteer->application_status === 'approved')
                                                Application approved
                                            @else
                                                Application denied
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs sm:text-sm text-gray-500 whitespace-nowrap">
                                    {{ $volunteer->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-600 text-center py-4">No recent activity</p>
                        @endforelse
                    </div>
                </div>
            </x-slot>

            <x-slot:slot_denied>
                @if($deniedApplications->isEmpty())
                    <p class="text-gray-600 text-center py-4">No denied applications found.</p>
                @else
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full min-w-[640px]">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 text-left">Name</th>
                                    <th class="p-3 text-left">Email</th>
                                    <th class="p-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deniedApplications as $volunteer)
                                    <tr class="border-t">
                                        <td class="p-3">{{ $volunteer->user->name }}</td>
                                        <td class="p-3">{{ $volunteer->user->email }}</td>
                                        <td class="p-3">
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info" class="tooltip"
                                                    data-tip="View Details">
                                                    <i class='bx bx-show'></i> View
                                                </x-button>

                                                <form action="{{ route('volunteers.restore', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info tooltip" data-tip="Restore to Pending">
                                                        <i class='bx bx-reset'></i> Restore
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-slot>

            <x-slot:slot_approved>
                @if($approvedVolunteers->isEmpty())
                    <p class="text-gray-600 text-center py-4">No approved volunteers found.</p>
                @else
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full min-w-[640px]">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 text-left">Name</th>
                                    <th class="p-3 text-left">Email</th>
                                    <th class="p-3 text-left">Joined At</th>
                                    <th class="p-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approvedVolunteers as $volunteer)
                                    <tr class="border-t">
                                        <td class="p-3">{{ $volunteer->user->name ?? 'N/A' }}</td>
                                        <td class="p-3">{{ $volunteer->user->email ?? 'N/A' }}</td>
                                        <td class="p-3">{{ $volunteer->created_at->format('M d, Y') }}</td>
                                        <td class="p-3">
                                            <div class="flex flex-wrap gap-2">
                                                <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info" class="tooltip"
                                                    data-tip="View Details">
                                                    <i class='bx bx-show'></i> View
                                                </x-button>

                                                <form action="{{ route('finance.members.invite', $volunteer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success tooltip" data-tip="Invite to be Member">
                                                        <i class='bx bx-user-plus'></i> Invite to Member
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-slot>
        </x-tabs>
    </div>
@endsection 