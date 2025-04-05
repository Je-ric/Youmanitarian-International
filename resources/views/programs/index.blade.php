@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Programs</h1>

    @if (session('toast'))
    <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
@endif


    @if(Auth::user()->hasRole('Admin'))
        <a href="{{ route('programs.create') }}" class="inline-block px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a017] transition-colors mb-6">
            Create Program
        </a>
    @endif

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-[#1a2235] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Created By</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($programs as $program)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-[#1a2235]">{{ $program->title }}</td>
                    <td class="px-6 py-4 text-sm font-semibold">
                        @php
                            $today = now();
                            if ($program->start_date > $today) {
                                echo '<span class="text-blue-500">Incoming</span>';
                            } elseif ($program->end_date && $program->end_date < $today) {
                                echo '<span class="text-gray-500">Done</span>';
                            } else {
                                echo '<span class="text-green-500">Ongoing</span>';
                            }
                        @endphp
                    </td>
                    
                    <td class="px-6 py-4 text-sm text-[#1a2235]">{{ $program->creator->name }}</td> 
                    <td class="px-6 py-4 text-sm flex gap-2">
                        <button onclick="openModal({{ $program }})" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            View Details
                        </button>
                    
                        @if(Auth::user()->volunteer) 
                            @php
                                $isEnrolled = $program->volunteers->contains(Auth::user()->volunteer->id);
                            @endphp
                    
                            @if($isEnrolled)
                                <form action="{{ route('programs.cancel_application', $program) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Cancel Application
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('programs.apply', $program) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" 
                                            onclick="my_modal_2.showModal()"
                                            class="btn px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                        Apply as Volunteer
                                    </button>
                                </form>
                            @endif
                    
                            <a href="{{ route('programs.view', $program) }}" class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                View Log
                            </a>
                        @else
                            @if(Auth::user()->hasRole('Admin'))
                                <a href="{{ route('programs.edit', $program) }}" class="px-3 py-1 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a017] transition-colors">
                                    Edit
                                </a>
                                <a href="{{ route('programs.manage_volunteers', $program) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                    Manage Volunteers
                                </a>
                                <form action="{{ route('programs.destroy', $program) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors" onclick="return confirm('Delete this program?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        @endif
                    </td>

                    {{-- <td class="px-6 py-4 text-sm flex gap-2">
                        <button onclick="document.getElementById('my_modal_2').showModal();" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                          View Details
                        </button>
                      
                        <dialog id="my_modal_2" class="modal">
                          <div class="modal-box">
                            <h3 class="text-lg font-bold">{{ $program->title }}</h3>
                            <p class="py-4">Description: {{ $program->description }}</p>
                            <p><strong>Location:</strong> {{ $program->location }}</p>
                            <p><strong>Start Date:</strong> {{ $program->start_date }}</p>
                            <p><strong>End Date:</strong> {{ $program->end_date ?? 'N/A' }}</p>
                            <p><strong>Progress:</strong> {{ ucfirst($program->progress) }}</p>
                          </div>
                          <form method="dialog" class="modal-backdrop">
                            <button>Close</button>
                          </form>
                        </dialog>
                        </td> --}}

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $programs->links() }}
    </div>
</div>


<dialog id="my_modal_2" class="modal">
    <div class="modal-box">
      <h3 class="text-lg font-bold">Hello!</h3>
      <p class="py-4">Press ESC key or click outside to close</p>
    </div>
    <form method="dialog" class="modal-backdrop">
      <button>close</button>
    </form>
  </dialog>


<dialog id="programDetailsModal" class="modal">
    <div class="modal-box bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold text-[#1a2235]" id="modalTitle"></h2>
        <p class="text-gray-700 mt-2"><strong>Description:</strong> <span id="modalDescription"></span></p>
        <p class="text-gray-700 mt-2"><strong>Date:</strong> <span id="modalDate"></span></p>
        <p class="text-gray-700 mt-2"><strong>Time:</strong> <span id="modalTime"></span></p>
        <p class="text-gray-700 mt-2"><strong>Location:</strong> <span id="modalLocation"></span></p>
        <p class="text-gray-700 mt-2"><strong>Created By:</strong> <span id="modalCreator"></span></p>

        <div class="modal-action">
            <button class="btn bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded-lg" onclick="closeModal()">Close</button>
        </div>
    </div>
</dialog>


<script>
    function formatTime(time) {
        if (!time) return "N/A";
        const [hour, minute] = time.split(":");
        let h = parseInt(hour);
        const suffix = h >= 12 ? "pm" : "am";
        h = h % 12 || 12; // Convert 24-hour to 12-hour format
        return `${h}:${minute}${suffix}`;
    }

    function openModal(program) {
        document.getElementById("modalTitle").textContent = program.title;
        document.getElementById("modalDescription").textContent = program.description;
        document.getElementById("modalLocation").textContent = program.location ? program.location : "N/A";
        document.getElementById("modalCreator").textContent = program.creator.name;

        // Format date (without time)
        let startDate = new Date(program.start_date).toLocaleDateString("en-US", {
            month: "long", day: "numeric", year: "numeric"
        });
        let endDate = program.end_date ? new Date(program.end_date).toLocaleDateString("en-US", {
            month: "long", day: "numeric", year: "numeric"
        }) : null;
        document.getElementById("modalDate").textContent = endDate ? `${startDate} - ${endDate}` : startDate;

        // Format time range
        let startTime = formatTime(program.start_time);
        let endTime = program.end_time ? formatTime(program.end_time) : null;
        document.getElementById("modalTime").textContent = endTime ? `${startTime} - ${endTime}` : startTime;

        document.getElementById("programDetailsModal").showModal();
    }

    function closeModal() {
        document.getElementById("programDetailsModal").close();
    }
</script>


@endsection
