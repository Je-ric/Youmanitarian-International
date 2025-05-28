@extends('layouts.sidebar')

@section('content')
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Programs</h1>

    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif


    <div class="container mx-auto p-6">

        @if(Auth::user()->hasRole('Admin'))
            <div class="flex justify-between">
                <x-button href="{{ route('programs.create') }}" variant="add-create" class="mb-6">
                    <i class='bx bx-plus-circle mr-2'></i> Create Program
                </x-button>

            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-[#1a2235] text-white">
                    <tr>
                        {{-- <th class="px-6 py-3 text-left text-sm font-semibold">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Created By</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th> --}}
                        <th class="px-6 py-3 text-left text-sm font-semibold cursor-pointer select-none">
                            @php
                                $sortField = request('sort');      // e.g. 'title'
                                $sortDirection = request('direction'); // 'asc' or 'desc'
                                $column = 'title';
                            @endphp

                            <a href="{{ request()->fullUrlWithQuery(['sort' => $column, 'direction' => ($sortField === $column && $sortDirection === 'asc') ? 'desc' : 'asc']) }}"
                                class="flex items-center gap-1">

                                Title

                                @if ($sortField === $column)
                                    @if ($sortDirection === 'asc')
                                        <i class='bx bx-sort-up text-yellow-400'></i>
                                    @else
                                        <i class='bx bx-sort-down text-yellow-400'></i>
                                    @endif
                                @else
                                    <i class='bx bx-sort text-gray-400'></i>
                                @endif

                            </a>
                        </th>

                        <th class="px-6 py-3 text-left text-sm font-semibold">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">
                            @sortablelink('created_by', 'Created By')
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">
                            Actions
                        </th>


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
                                <x-button onclick="document.getElementById('modal_{{ $program->id }}').showModal();"
                                    variant="info" class="tooltip" data-tip="View Details">
                                    <i class='bx bx-show'></i>
                                </x-button>

                                {{-- @if(Auth::user()->volunteer) --}}
                                @if(Auth::user()->hasRole('Volunteer'))
                                    <x-button href="{{ route('programs.view', $program) }}" variant="success">
                                        <i class='bx bx-show'></i>View Log
                                    </x-button>
                                @else
                                    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Program Coordinator'))
                                        <x-button href="{{ route('programs.manage_volunteers', $program) }}" variant="manage"
                                            class="tooltip" data-tip="Manage Volunteers">
                                            <i class='bx bx-group'></i>
                                        </x-button>

                                        <x-button href="{{ route('programs.edit', $program) }}" variant="warning" class="tooltip"
                                            data-tip="Edit">
                                            <i class='bx bx-edit-alt'></i>
                                        </x-button>

                                        <form action="{{ route('programs.destroy', $program) }}" method="POST" class="inline-block">
                                            @csrf @method('DELETE')
                                            <x-button type="submit" variant="danger" onclick="return confirm('Delete this program?')"
                                                class="tooltip" data-tip="Delete">
                                                <i class='bx bx-trash'></i>
                                            </x-button>
                                        </form>

                                    @endif
                                @endif
                            </td>

                        </tr>
                        {{--
                        ================================================================================================================
                        --}}
                        {{-- <dialog id="modal_{{ $program->id }}" class="modal">
                            <div class="modal-box mx-auto p-6 space-y-4">
                                <h3 class="text-lg font-bold">{{ $program->title }}</h3>
                                <p class="py-2">{{ $program->description }}</p>
                                <p><strong>Location:</strong> {{ $program->location }}</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <p><strong>Start Date:</strong> {{
                                            \Carbon\Carbon::parse($program->start_date)->format('M d, Y') }}</p>
                                        <p><strong>Start Time:</strong> {{
                                            \Carbon\Carbon::parse($program->start_time)->format('h:i A') }}</p>
                                    </div>

                                    <div class="space-y-1">
                                        <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($program->end_date)->format('M d,
                                            Y') ?? 'N/A' }}</p>
                                        <p><strong>End Time:</strong> {{ \Carbon\Carbon::parse($program->end_time)->format('h:i
                                            A') ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="border-t border-gray-300 my-4"></div>

                                <p><strong>Progress:</strong> {{ ucfirst($program->progress) }}</p>

                                @if(Auth::user()->hasRole('Volunteer'))
                                @php
                                $isEnrolled = $program->volunteers->contains(Auth::user()->volunteer->id);
                                $volunteerStatus = $program->volunteers->find(Auth::user()->volunteer->id)?->pivot->status;
                                @endphp

                                @if($isEnrolled)
                                @if($volunteerStatus === 'pending')
                                <div class="text-green-500 font-semibold">
                                    You have successfully applied to this program. We’re excited to have you on board. Your
                                    interest in this program is truly appreciated. The program coordinator will review your
                                    application shortly. Stay tuned, and we’re looking forward to working together!
                                </div>
                                <form action="{{ route('programs.cancel_application', $program) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 w-full">
                                        Cancel Application
                                    </button>
                                </form>
                                @elseif($volunteerStatus === 'approved')
                                <div class="text-green-500 font-semibold">
                                    Congratulations! Your application has been approved. You are now an official volunteer for
                                    this program. (Additional message or notification between volunteer and coordinator)
                                </div>
                                @elseif($volunteerStatus === 'denied')
                                <div class="text-red-500 font-semibold">
                                    Unfortunately, your application to this program has been denied. Thank you for your
                                    interest. You're still welcome to participate to this program and apply in other programs.
                                </div>
                                @endif
                                @else
                                <form action="{{ route('programs.proceed_application', $program) }}" method="POST" class="mt-4">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 w-full">
                                        Apply as Volunteer
                                    </button>
                                </form>
                                @endif
                                @endif

                                <form method="dialog" class="modal-backdrop">
                                    <button class="w-full py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                                        Close
                                    </button>
                                </form>
                            </div>
                        </dialog> --}}

                        {{--
                        -------------------------------------------------------------------------------------------------------------------
                        --}}

                     <dialog id="modal_{{ $program->id }}" class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title-{{ $program->id }}">
    <div class="modal-box w-11/12 max-w-7xl p-0 overflow-hidden rounded-2xl bg-white shadow-2xl border border-gray-200 transition-all">

        <section class="relative bg-white rounded-2xl overflow-hidden w-full max-h-[90vh]">

            <header class="px-6 py-4 border-b border-gray-200 relative bg-[#fff7e5]">
                <x-x-button />
                <h2 id="modal-title-{{ $program->id }}"
                    class="text-3xl font-extrabold text-[#1a2235] tracking-tight [text-shadow:_0px_2px_1px_rgb(255_181_27_/_0.7)]">
                    {{ $program->title }}
                </h2>
            </header>

            <div class="flex flex-col lg:flex-row">
                <!-- Left Content -->
                <div class="lg:w-9/12 w-full p-6 space-y-6 bg-white">
                    <article>
                        <h3 class="text-xl font-semibold text-[#1a2235] mb-3">📖 Description</h3>
                        <p class="bg-neutral-100 p-4 rounded-xl border border-gray-200 text-gray-700 leading-relaxed text-base shadow-sm transition-all hover:bg-neutral-50">
                            {{ $program->description }}
                        </p>
                    </article>

                    <div class="pt-4">
                        <h4 class="text-xl font-semibold text-[#1a2235] mb-3">🧭 Program Coordinator</h4>
                        <div class="flex items-center space-x-4">
                            <img src="https://placehold.co/60x60" alt="Coordinator"
                                class="rounded-full w-16 h-16 object-cover border-2 border-[#ffb51b]" />
                            <div>
                                <div class="text-lg font-semibold text-gray-800">Jozen Agustin</div>
                                <div class="text-gray-500 text-sm">Coordinator</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Details -->
                <aside class="lg:w-3/12 w-full bg-[#fef9eb] p-6 space-y-5 rounded-br-2xl border-l border-gray-200 shadow-inner">
                    <h3 class="text-lg font-bold text-[#1a2235]">📝 Program Details</h3>

                    @php
                        $details = [
                            ['icon' => 'calendar', 'label' => 'Date', 'value' => \Carbon\Carbon::parse($program->start_date)->format('M d, Y')],
                            ['icon' => 'clock-three', 'label' => 'Time', 'value' => \Carbon\Carbon::parse($program->start_time)->format('h:i A')],
                            ['icon' => 'marker', 'label' => 'Location', 'value' => $program->location],
                            ['icon' => 'users-alt', 'label' => 'Volunteers Needed', 'value' => $program->volunteer_count],
                            ['icon' => 'arrow-progress-alt', 'label' => 'Progress', 'value' => ucfirst($program->progress)],
                        ];
                    @endphp

                    @foreach ($details as $detail)
                        <div class="space-y-1">
                            <div class="flex items-center gap-2 text-[#ffb51b] font-medium">
                                <i class="fi fi-rr-{{ $detail['icon'] }} text-sm"></i>
                                <span class="text-sm text-zinc-600">{{ $detail['label'] }}</span>
                            </div>
                            <p class="text-gray-800 font-semibold pl-6 text-[15px]">{{ $detail['value'] }}</p>
                        </div>
                    @endforeach
                </aside>
            </div>

            <form method="dialog" class="modal-backdrop flex justify-end px-6 py-4 bg-white border-t border-gray-200">
                <button class="py-2.5 px-6 text-sm font-semibold text-white bg-[#ffb51b] hover:bg-[#e6a600] rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#ffb51b]/50">
                    Close
                </button>
            </form>
        </section>
    </div>
</dialog>


                        </tr>
                    @endforeach
                </tbody>
            </table>



        </div>


        <div class="mt-6">
            {{-- {{ $programs->links() }} --}}
            {{ $programs->appends(Request::except('page'))->links() }}

        </div>
    </div>


@endsection