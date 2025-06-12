@extends('layouts.sidebar_final')

@section('content')
    <div x-data="{ 
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'applications',
        setTab(tab) {
            this.activeTab = tab;
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        }   
    }" class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <div class="mb-4 sm:mb-8">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1a2235] mb-1 sm:mb-2">
                Volunteers Management
            </h1>
            <p class="text-sm sm:text-base text-gray-600">Manage volunteer applications and approved volunteers</p>
        </div>

        @if (session('toast'))
            <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
        @endif

        <!-- Responsive Tab Navigation -->
        <div class="mb-6 sm:mb-8 overflow-x-auto pb-2 sm:pb-0">
            <div class="bg-gray-50 p-1 rounded-lg inline-flex space-x-1 min-w-max">
                <button @click="setTab('applications')" 
                    :class="activeTab === 'applications' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-user-plus text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Applications</span>
                </button>

                <button @click="setTab('overview')" 
                    :class="activeTab === 'overview' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-stats text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Overview</span>
                </button>

                <button @click="setTab('denied')" 
                    :class="activeTab === 'denied' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-x-circle text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Denied</span>
                </button>

                <button @click="setTab('approved')" 
                    :class="activeTab === 'approved' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-check-circle text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Approved</span>
                </button>
            </div>
        </div>

        <!-- Tab Content with Smooth Transitions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <!-- Applications Tab -->
            <div x-show="activeTab === 'applications'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-4">
                @if($applications->isEmpty())
                    <p class="text-gray-600 text-center py-4">No pending applications found.</p>
                @else
                    <table class="w-full">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Overview Tab -->
            <div x-show="activeTab === 'overview'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-6">
                
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Volunteers -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Volunteers</p>
                                <h3 class="text-2xl font-bold text-[#1a2235]">{{ $approvedVolunteers->count() }}</h3>
                            </div>
                            <div class="bg-blue-50 p-3 rounded-full">
                                <i class='bx bx-user text-2xl text-blue-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Applications -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Pending Applications</p>
                                <h3 class="text-2xl font-bold text-[#1a2235]">{{ $applications->count() }}</h3>
                            </div>
                            <div class="bg-yellow-50 p-3 rounded-full">
                                <i class='bx bx-time text-2xl text-yellow-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Denied Applications -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Denied Applications</p>
                                <h3 class="text-2xl font-bold text-[#1a2235]">{{ $deniedApplications->count() }}</h3>
                            </div>
                            <div class="bg-red-50 p-3 rounded-full">
                                <i class='bx bx-x-circle text-2xl text-red-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Approval Rate -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Approval Rate</p>
                                <h3 class="text-2xl font-bold text-[#1a2235]">
                                    @php
                                        $total = $approvedVolunteers->count() + $deniedApplications->count();
                                        echo $total > 0 ? round(($approvedVolunteers->count() / $total) * 100) : 0;
                                    @endphp%
                                </h3>
                            </div>
                            <div class="bg-green-50 p-3 rounded-full">
                                <i class='bx bx-trending-up text-2xl text-green-500'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                    <h3 class="text-lg font-semibold text-[#1a2235] mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        @php
                            $allVolunteers = collect([$applications, $deniedApplications, $approvedVolunteers])
                                ->flatten()
                                ->sortByDesc('updated_at')
                                ->take(5);
                        @endphp

                        @forelse($allVolunteers as $volunteer)
                            <div class="flex items-center justify-between border-b pb-3 last:border-0">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                        <i class='bx bx-user text-xl text-gray-500'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[#1a2235]">{{ $volunteer->user->name }}</p>
                                        <p class="text-sm text-gray-600">
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
                                <span class="text-sm text-gray-500">
                                    {{ $volunteer->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-600 text-center py-4">No recent activity</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Denied Applications Tab -->
            <div x-show="activeTab === 'denied'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-4">
                @if($deniedApplications->isEmpty())
                    <p class="text-gray-600 text-center py-4">No denied applications found.</p>
                @else
                    <table class="w-full">
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
                                        <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info" class="tooltip"
                                            data-tip="View Details">
                                            <i class='bx bx-show'></i> View
                                        </x-button>

                                        <form action="{{ route('volunteers.restore', $volunteer->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-info">Restore</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Approved Volunteers Tab -->
            <div x-show="activeTab === 'approved'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-4">
                @if($approvedVolunteers->isEmpty())
                    <p class="text-gray-600 text-center py-4">No approved volunteers found.</p>
                @else
                    <table class="w-full">
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
                                        <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info" class="tooltip"
                                            data-tip="View Details">
                                            <i class='bx bx-show'></i> View
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection 