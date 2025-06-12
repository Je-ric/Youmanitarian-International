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