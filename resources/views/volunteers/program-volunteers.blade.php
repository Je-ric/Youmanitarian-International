@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Manage Volunteers for {{ $program->title }}</h1>
    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif

    

    <div class="text-end">
        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example">
        Assign Volunteers to the {{ $program->title}}
        </button>
     </div>

    <h2 class="text-xl font-semibold text-[#1a2235] mb-4">Assigned Volunteers</h2>

    @if($program->volunteers->isEmpty())
        <p class="text-gray-600">No volunteers assigned to this program.</p>
    @else
        <table class="w-full bg-white shadow-lg rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($program->volunteers as $volunteer)
                    @if($volunteer->pivot->status == 'approved')
                    <tr class="border-t">
                        <td class="p-3">{{ $volunteer->user->name }}</td>
                        <td class="p-3">{{ $volunteer->user->email }}</td>
                        <td class="p-3">

                                <button  data-modal-target="view-logs-{{ $volunteer->id }}" 
                                        data-modal-toggle="view-logs-{{ $volunteer->id }}"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        View Logs
                                    </button>

                                    <form action="{{ route('programs.restore_volunteer', [$program, $volunteer]) }}" method="POST">
                                        @csrf
                                        <button type="submit">Restore to Pending</button>
                                    </form>
                                    
                                    

                            <div id="view-logs-{{ $volunteer->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-6 w-full max-w-lg bg-white rounded-lg shadow-md">
                                    <div class="flex justify-between items-center pb-3 border-b">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Volunteer Logs for {{ $volunteer->user->name }}
                                        </h3>
                                        <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center" data-modal-hide="view-logs-{{ $volunteer->id }}">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6m-6-6l6-6m-6 6L1 13"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="p-4">
                                        @php
                                            $logs = $program->volunteerAttendances()
                                                ->where('volunteer_id', $volunteer->id)
                                                ->orderBy('clock_in', 'desc')
                                                ->get();
                                        @endphp

                                        @if ($logs->isEmpty())
                                            <p class="text-gray-500">No logs available for this volunteer.</p>
                                        @else
                                            <table class="w-full border">
                                                <thead>
                                                    <tr>
                                                        <th class="p-2 border">Clock In</th>
                                                        <th class="p-2 border">Clock Out</th>
                                                        <th class="p-2 border">Total Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($logs as $log)
                                                        <tr>
                                                            <td class="p-2 border">{{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}</td>
                                                            <td class="p-2 border">
                                                                @if ($log->clock_out)
                                                                    {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                                                                @else
                                                                    <span class="text-red-500">Still Clocked In</span>
                                                                @endif
                                                            </td>
                                                            <td class="p-2 border">
                                                                @if ($log->clock_out)
                                                                    @php
                                                                        $diff = \Carbon\Carbon::parse($log->clock_in)->diff(\Carbon\Carbon::parse($log->clock_out));
                                                                    @endphp
                                                                    {{ $diff->h }}h {{ $diff->i }}m {{ $diff->s }}s
                                                                @else
                                                                    <span class="text-red-500">Ongoing</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                    <div class="flex justify-end pt-3">
                                        <button data-modal-hide="view-logs-{{ $volunteer->id }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif


 <div id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 md:w-96 lg:w-[600px] dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
     <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
     <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
   </svg>Assign Volunteers</h5>
    <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
       <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
       </svg>
       <span class="sr-only">Close menu</span>
    </button>


    <div class="mb-6 bg-white rounded-lg p-6 border border-gray-200">
        <p class="text-gray-600">Volunteers: <span class="font-semibold">{{ $program->volunteers->count() }}</span> / <span class="font-semibold">{{ $program->volunteer_count }}</span></p>
        
        @if($program->volunteers->count() >= $program->volunteer_count)
            <div class="text-sm text-green-500 mt-2">The program is full!</div>
        @else
            <div class="text-sm text-yellow-500 mt-2">More volunteers needed!</div>
        @endif
    </div>
    
    <div class="bg-white rounded-lg p-6 border border-gray-200">
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
                        @if($volunteer->pivot->status === 'pending')
                            @if($program->volunteers->count() < $program->volunteer_count)
                                <form action="{{ route('programs.approve_volunteer', [$program, $volunteer]) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                            @else
                                <button class="btn btn-disabled btn-sm">Full</button>
                            @endif
    
                            <form action="{{ route('programs.deny_volunteer', [$program, $volunteer]) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error btn-sm">Deny</button>
                            </form>
                        @elseif($volunteer->pivot->status === 'denied')
                            <form action="{{ route('programs.restore_volunteer', [$program, $volunteer]) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">Restore</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    
 </div>
 
</div>


@endsection


