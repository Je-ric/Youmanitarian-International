@extends('layouts.sidebar_final')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="font-bold text-[#1a2235] mb-6">Manage Volunteers for {{ $program->title }}</h1>
        @if (session('toast'))
            <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
        @endif

        <x-button href="{{ route('programs.feedback.view', $program->id) }}" variant="secondary" class="mb-6">
             View Feedbacks
        </x-button>

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
                                    <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info">
                                        <i class='bx bx-show'></i> View
                                    </x-button>

                                    <button
                                    class="btn btn-info"
                                    onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()"
                                >
                                    <i class='bx bx-show'></i> Review Attendance
                                </button>

                                    {{-- <form action="{{ route('programs.restore_volunteer', [$program, $volunteer]) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="restore">Restore</x-button>
                                    </form> --}}
                                </td>
                            </tr>

                             <!-- Modal -->
                        {{-- <dialog id="attendanceModal_{{ $volunteer->id }}" class="modal">
                            <form method="POST" action="#" class="modal-box max-w-3xl" enctype="multipart/form-data">
                                @csrf
                                <h3 class="font-bold text-2xl mb-6 text-center">Review Attendance - {{ $volunteer->user->name }}</h3>

                                @foreach ($volunteerLogs as $log)
                                    <div class="mb-6 border border-gray-300 rounded-lg p-4 relative">
                                        <div class="flex justify-between mb-2">
                                            <div class="flex items-center gap-3">
                                                <div class="relative w-7 h-7">
                                                    <div class="absolute left-[5px] top-[5px] w-5 h-5 rounded-full outline outline-[2.50px] outline-gray-500"></div>
                                                    <div class="absolute left-[15px] top-[10.62px] w-1.5 h-1 outline outline-[2.50px] outline-offset-[-1.25px] outline-gray-500"></div>
                                                </div>
                                                <p class="text-black text-xl font-medium font-['Poppins'] tracking-tight">Time In:</p>
                                                <p class="text-black text-xl font-normal font-['Poppins'] tracking-tight">{{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}</p>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <p class="text-black text-xl font-medium font-['Poppins'] tracking-tight">Time Out:</p>
                                                <p class="text-black text-xl font-normal font-['Poppins'] tracking-tight">
                                                    @if ($log->clock_out)
                                                        {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                                                    @else
                                                        <span class="text-red-500">Still Clocked In</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <label for="notes_{{ $log->id }}" class="block text-black font-medium mb-2">Notes (optional):</label>
                                        <form method="POST" action="{{ route('attendance.approve', $log->id) }}" class="mb-3">
                                            @csrf
                                            <textarea
                                                id="notes_{{ $log->id }}"
                                                name="notes"
                                                rows="4"
                                                class="w-full p-3 rounded-md border border-gray-300"
                                                placeholder="Add any comments about this attendance record..."
                                            >{{ old('notes', $log->notes) }}</textarea>

                                            <div class="flex justify-between mt-4">
                                                <div>
                                                    @if($log->proof_image_path)
                                                       <a href="{{ asset('storage/uploads/' . $log->proof_image_path) }}" target="_blank" class="underline text-blue-600 hover:text-blue-800">
                                                            View Proof Image
                                                            </a>

                                                    @else
                                                        <p class="text-gray-500">No proof image uploaded</p>
                                                    @endif
                                                </div>

                                                <div class="flex gap-2">
                                                    <button
                                                        formaction="{{ route('attendance.approve', $log->id) }}"
                                                        formmethod="POST"
                                                        class="btn btn-primary flex items-center gap-2"
                                                    >
                                                        <i class='bx bx-check-circle'></i> Approve
                                                    </button>

                                                    <button
                                                        formaction="{{ route('attendance.reject', $log->id) }}"
                                                        formmethod="POST"
                                                        class="btn btn-danger flex items-center gap-2"
                                                    >
                                                        <i class='bx bx-x-circle'></i> Reject
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach

                                <div class="modal-action">
                                    <button type="button" class="btn" onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').close()">Close</button>
                                </div>
                            </form>
                        </dialog> --}}

                        <dialog id="attendanceModal_{{ $volunteer->id }}" class="modal">
    <form method="POST" action="#" class="modal-box max-w-3xl p-8 rounded-[20px] bg-white relative" enctype="multipart/form-data">
        @csrf
        <h3 class="text-gray-800 text-2xl font-bold font-['Poppins'] mb-8 text-center">
            Review Attendance - {{ $volunteer->user->name }}
        </h3>

        @foreach ($volunteerLogs as $log)
            <div class="mb-8 border border-gray-300 rounded-[12px] p-6 bg-white shadow-sm">
                <div class="flex justify-between mb-4 flex-wrap gap-4">
                    <div class="flex items-center gap-3">
                        <div class="relative w-7 h-7">
                            <div class="absolute left-[5px] top-[5px] w-5 h-5 rounded-full outline outline-[2.5px] outline-gray-500"></div>
                            <div class="absolute left-[15px] top-[10.6px] w-1.5 h-1 outline outline-[2.5px] outline-offset-[-1.25px] outline-gray-500"></div>
                        </div>
                        <p class="text-black text-xl font-medium font-['Poppins'] tracking-tight">Time In:</p>
                        <p class="text-black text-xl font-normal font-['Poppins'] tracking-tight">
                            {{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <p class="text-black text-xl font-medium font-['Poppins'] tracking-tight">Time Out:</p>
                        <p class="text-black text-xl font-normal font-['Poppins'] tracking-tight">
                            @if ($log->clock_out)
                                {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                            @else
                                <span class="text-red-500">Still Clocked In</span>
                            @endif
                        </p>
                    </div>
                </div>

                <label for="notes_{{ $log->id }}" class="block text-black font-medium mb-2 font-['Poppins'] tracking-tight">
                    Notes (optional):
                </label>

                <textarea
                    id="notes_{{ $log->id }}"
                    name="notes"
                    rows="5"
                    class="w-full px-4 py-2.5 bg-white rounded-xl outline outline-[1.4px] outline-stone-300 resize-none text-zinc-700 text-base font-medium font-['Montserrat'] tracking-tight mb-4"
                    placeholder="Add any comments about this attendance record..."
                >{{ old('notes', $log->notes) }}</textarea>

                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        @if($log->proof_image_path)
                            <a href="{{ asset('storage/uploads/attendance_proof/' . $log->proof_image_path) }}" target="_blank" class="underline text-blue-600 hover:text-blue-800 font-['Poppins']">
                                View Proof Image
                            </a>
                        @else
                            <p class="text-gray-500 font-['Poppins']">No proof image uploaded</p>
                        @endif
                    </div>

                    <div class="flex gap-4 flex-wrap">
                        <button
                            formaction="{{ route('attendance.approve', $log->id) }}"
                            formmethod="POST"
                            class="w-64 h-14 px-5 bg-emerald-50 rounded-md outline outline-1 outline-green-500 flex justify-center items-center gap-2 text-green-600 font-medium font-['Inter'] cursor-pointer hover:bg-green-100 transition"
                        >
                            <i class='bx bx-check-circle text-green-600 text-xl'></i> Approve
                        </button>

                        <button
                            formaction="{{ route('attendance.reject', $log->id) }}"
                            formmethod="POST"
                            class="w-64 h-14 px-5 bg-rose-100 rounded-md outline outline-1 outline-red-600 flex justify-center items-center gap-2 text-red-600 font-medium font-['Inter'] cursor-pointer hover:bg-red-200 transition"
                        >
                            <i class='bx bx-x-circle text-red-600 text-xl'></i> Reject
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="modal-action mt-4 text-center">
            <button
                type="button"
                class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-md font-semibold"
                onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').close()"
            >
                Close
            </button>
        </div>
    </form>
</dialog>

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

        </div>

    </div>
    



@endsection