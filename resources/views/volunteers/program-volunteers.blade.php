@extends('layouts.sidebar_final')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="font-bold text-[#1a2235] mb-6">Manage Volunteers for {{ $program->title }}</h1>
        @if (session('toast'))
            <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
        @endif

        <div class="text-end">
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                data-drawer-placement="right" aria-controls="drawer-right-example">
                Assign Volunteers
            </button>
        </div>

        <h2 class="text-xl font-semibold text-[#1a2235] mb-4">Assigned Volunteers</h2>

        @if($program->volunteers->isEmpty())
            <p class="text-gray-600 text-center py-4">No volunteers assigned to this program.</p>
        @else
            <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                <thead class="bg-[#1a2235] text-white">
                    <tr>
                        <th class="p-4 text-left text-sm font-medium">Name</th>
                        <th class="p-4 text-left text-sm font-medium">Clock In</th>
                        <th class="p-4 text-left text-sm font-medium">Clock Out</th>
                        <th class="p-4 text-left text-sm font-medium">Total Time</th>
                        <th class="p-4 text-left text-sm font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($program->volunteers as $volunteer)
                        @if($volunteer->pivot->status == 'approved')
                            <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                                <td class="p-4 text-sm text-[#1a2235] font-semibold">{{ $volunteer->user->name }} <span
                                        class="text-gray-500">({{ $volunteer->user->email }})</span></td>
                                <td class="p-4 text-sm">
                                    @php
                                        $volunteerLogs = $logs[$volunteer->id]['logs'];
                                    @endphp

                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        @foreach ($volunteerLogs as $log)
                                            <div class="flex gap-2">
                                                <span
                                                    class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>

                                <td class="p-4 text-sm">
                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        @foreach ($volunteerLogs as $log)
                                            <div class="flex gap-2">
                                                <span class="text-sm text-gray-600">
                                                    @if ($log->clock_out)
                                                        {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                                                    @else
                                                        <span class="text-red-500">Still Clocked In</span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>

                                <td class="p-4 text-sm">
                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        <p class="text-gray-600">{{ $logs[$volunteer->id]['totalTime'] }}</p>
                                    @endif
                                </td>

                                <td class="p-4 flex items-center gap-2">
                                    <x-button href="{{ route('volunteers.details', $volunteer->id) }}" variant="info">
                                        <i class='bx bx-show'></i> View
                                    </x-button>

                                    {{-- <form action="{{ route('programs.restore_volunteer', [$program, $volunteer]) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="restore">Restore</x-button>
                                    </form> --}}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif





        <div id="drawer-right-example"
            class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 md:w-96 lg:w-[600px] dark:bg-gray-800"
            tabindex="-1" aria-labelledby="drawer-right-label">
            <h5 id="drawer-right-label"
                class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg
                    class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>Assign Volunteers</h5>
            <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>


            <div class="mb-6 bg-white rounded-lg p-6 border border-gray-200">
                <p class="text-gray-600">Volunteers: <span class="font-semibold">{{ $program->volunteers->count() }}</span>
                    / <span class="font-semibold">{{ $program->volunteer_count }}</span></p>

                @if($program->volunteers->count() >= $program->volunteer_count)
                    <div class="text-sm text-green-500 mt-2">The program is full!</div>
                @else
                    <div class="text-sm text-yellow-500 mt-2">More volunteers needed!</div>
                @endif
            </div>

            {{-- <div class="bg-white rounded-lg p-6 border border-gray-200">
                @foreach($program->volunteers as $volunteer)
                    @if($volunteer->pivot->status === 'pending' || $volunteer->pivot->status === 'denied')
                        <div class="flex items-center justify-between py-4 border-b border-gray-300">
                            <div class="w-full">
                                <p class="text-base font-semibold text-[#1a2235]">{{ $volunteer->user->name }}</p>
                                <div class="flex gap-2">
                                    <p class="text-sm text-gray-600">{{ $volunteer->user->email }}</p>
                                    @if($volunteer->pivot->status === 'denied')
                                        <span class="text-sm text-red-500">Denied</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <x-button href="{{ route('volunteers.details', $volunteer->id) }}" variant="info" class="tooltip"
                                    data-tip="View Details">
                                    <i class='bx bx-show'></i> View
                                </x-button>

                                @if($volunteer->pivot->status === 'pending')
                                    @if($program->volunteers->count() < $program->volunteer_count)
                                        <form action="{{ route('programs.approve_volunteer', [$program, $volunteer]) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            <x-button type="submit" variant="approve">Approve</x-button>
                                        </form>
                                    @else
                                        <button class="btn btn-disabled btn-sm">Full</button>
                                    @endif

                                    <form action="{{ route('programs.deny_volunteer', [$program, $volunteer]) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="deny">Deny</x-button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div> --}}
        </div>

    </div>



@endsection