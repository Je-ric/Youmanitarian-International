{{--
<div id="modal-overlay-{{ $program->id }}" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm hidden z-40">
</div>

<dialog id="modal_{{ $program->id }}" class="modal" role="dialog" aria-modal="true"
    aria-labelledby="modal-title-{{ $program->id }}">
    <div
        class="modal-box w-11/12 max-w-7xl p-0 overflow-hidden rounded-2xl bg-white shadow-2xl border border-gray-200 transition-all">

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
                        <h3 class="text-xl font-semibold text-[#1a2235] mb-3 flex items-center gap-2">
                            <i class='bx bx-book-open text-[#2a3449]'></i>
                            Description
                        </h3>
                        <p
                            class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-gray-700 leading-relaxed text-base shadow-sm transition-all hover:bg-white">
                            {{ $program->description }}
                        </p>
                    </article>

                    <div class="pt-4">
                        <h4 class="text-xl font-semibold text-[#1a2235] mb-3 flex items-center gap-2">
                            <i class='bx bx-user-circle text-[#2a3449]'></i>
                            Program Coordinator
                        </h4>
                        <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <div class="relative">
                                <img src="https://placehold.co/60x60" alt="Coordinator"
                                    class="rounded-lg w-16 h-16 object-cover border-2 border-[#1a2235]" />
                                <div
                                    class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-[#1a2235]">{{ $program->creator->name }}</div>
                                <div class="text-gray-600 text-sm flex items-center gap-1">
                                    <i class='bx bx-check-circle text-green-500'></i>
                                    Program Coordinator
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->hasRole('Volunteer'))
                    @php
                    $volunteer = Auth::user()->volunteer;
                    $alreadyJoined = $program->volunteers->contains($volunteer?->id ?? 0);
                    @endphp

                    @if(!$alreadyJoined)
                    <form action="{{ route('programs.join', $program->id) }}" method="POST" class="mt-4">
                        @csrf
                        <x-button type="submit" variant="success" class="w-full">
                            <i class='bx bx-user-plus mr-2'></i> Join Program
                        </x-button>
                    </form>
                    @else
                    <div class="mt-4 text-green-600 font-semibold text-sm flex items-center gap-2">
                        <i class='bx bx-check-circle'></i> You are already joined in this program.
                    </div>
                    @endif
                    @endif

                </div>

                <!-- Right Details -->
                <aside class="lg:w-3/12 w-full bg-gray-50 p-6 space-y-5 rounded-r-xl border-l border-gray-100">
                    <h3 class="text-lg font-bold text-[#1a2235] flex items-center gap-2">
                        <i class='bx bx-detail text-[#2a3449]'></i>
                        Program Details
                    </h3>

                    @php
                    $progressComponent = view('components.programProgress', ['program' => $program])->render();

                    $details = [
                    ['icon' => 'calendar', 'label' => 'Date', 'value' =>
                    \Carbon\Carbon::parse($program->date)->format('M d, Y')],
                    ['icon' => 'time', 'label' => 'Time', 'value' =>
                    \Carbon\Carbon::parse($program->start_time)->format('h:i A') . ' - ' .
                    \Carbon\Carbon::parse($program->end_time)->format('h:i A')],
                    ['icon' => 'map-pin', 'label' => 'Location', 'value' => $program->location],
                    ['icon' => 'group', 'label' => 'Volunteers Needed', 'value' => $program->volunteer_count],
                    ['icon' => 'trending-up', 'label' => 'Progress', 'value' => $progressComponent]
                    ];
                    @endphp


                    @foreach ($details as $detail)
                    <div
                        class="space-y-1.5 bg-white p-3 rounded-lg border border-gray-100 transition-all hover:border-[#1a2235]/20">
                        <div class="flex items-center gap-2 text-[#1a2235] font-medium">
                            <i class='bx bx-{{ $detail[' icon'] }} text-[#2a3449]'></i>
                            <span class="text-sm text-gray-600">{{ $detail['label'] }}</span>
                        </div>
                        <p class="text-[#1a2235] font-semibold pl-6 text-[15px]">{!! $detail['value'] !!}</p>
                    </div>
                    @endforeach
                </aside>
            </div>

            <form method="dialog" class="modal-backdrop flex justify-end px-6 py-4 bg-white border-t border-gray-200">
                <button
                    class="py-2.5 px-6 text-sm font-semibold text-white bg-[#ffb51b] hover:bg-[#e6a600] rounded-lg shadow-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#ffb51b]/50">
                    Close
                </button>
            </form>
        </section>
    </div>
</dialog> --}}

<div id="modal-overlay-{{ $program->id }}" class="fixed inset-0 bg-slate-900/20 backdrop-blur-sm hidden z-40"></div>

<dialog id="modal_{{ $program->id }}" class="modal" role="dialog" aria-modal="true"
    aria-labelledby="modal-title-{{ $program->id }}">
    <div
        class="modal-box w-11/12 max-w-6xl p-0 overflow-hidden rounded-xl bg-white border border-slate-200 transition-all max-h-[90vh] flex flex-col">

        <!-- Header -->
        <header class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex-shrink-0">
            <div class="flex items-center justify-between">
                <h2 id="modal-title-{{ $program->id }}" class="text-2xl font-bold text-slate-900 tracking-tight">
                    {{ $program->title }}
                </h2>
                <x-x-button></x-x-button>
            </div>
        </header>

        <!-- Main Content - Scrollable -->
        <div class="flex flex-col lg:flex-row flex-1 min-h-0 overflow-hidden">
            <!-- Left Content -->
            <div class="lg:w-2/3 w-full p-6 space-y-6 overflow-y-auto">

                <!-- Description -->
                <article>
                    <h3 class="text-lg font-semibold text-slate-900 mb-3 flex items-center gap-2">
                        <i class='bx bx-book-open text-slate-600'></i>
                        Description
                    </h3>
                    <div
                        class="bg-slate-50 border border-slate-200 rounded-lg p-4 max-h-36 overflow-y-auto custom-scrollbar">
                        <p class="text-slate-700 leading-relaxed">
                            {{ $program->description }}
                        </p>
                    </div>
                </article>

                <!-- Program Coordinator -->
                <div class="border-t border-slate-200 pt-6">
                    <h4 class="text-lg font-semibold text-slate-900 mb-3 flex items-center gap-2">
                        <i class='bx bx-user-circle text-slate-600'></i>
                        Program Coordinator
                    </h4>
                    <div
                        class="flex items-center space-x-4 p-4 border border-slate-200 rounded-lg hover:border-blue-200 transition-colors duration-200">
                        <div class="relative">
                            <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg?auto=compress&cs=tinysrgb&w=150&h=150&fit=crop"
                                alt="Coordinator" class="rounded-lg w-16 h-16 object-cover border-2 border-slate-300" />
                            <div
                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full">
                            </div>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-slate-900">{{ $program->creator->name }}</div>
                            <div class="text-slate-600 text-sm flex items-center gap-1">
                                <i class='bx bx-check-circle text-green-500'></i>
                                Program Coordinator
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Join Button -->
                @if(Auth::user()->hasRole('Volunteer'))
                    @php
                        $volunteer = Auth::user()->volunteer;
                        $alreadyJoined = $program->volunteers->contains($volunteer?->id ?? 0);
                        $currentVolunteers = $program->volunteers->count();
                    @endphp

                    <div class="border-t border-slate-200 pt-6">
                        @if($program->progress == 'done')
                            <div
                                class="text-green-600 font-medium text-sm flex items-center gap-2 justify-center py-3 px-4 bg-green-50 border border-green-200 rounded-lg">
                                <i class='bx bx-check-circle'></i>
                                This program is already done.
                            </div>
                        @elseif($currentVolunteers >= $program->volunteer_count)
                            <div
                                class="text-red-600 font-medium text-sm flex items-center gap-2 justify-center py-3 px-4 bg-red-50 border border-red-200 rounded-lg">
                                <i class='bx bx-error-circle'></i>
                                All volunteer slots are filled, but you’re welcome to join as a guest, viewer, or supporter!
                            </div>
                        @elseif($alreadyJoined)
                            <div
                                class="text-green-600 font-medium text-sm flex items-center gap-2 justify-center py-3 px-4 bg-green-50 border border-green-200 rounded-lg">
                                <i class='bx bx-check-circle'></i>
                                You are already joined in this program.
                            </div>
                        @else
                            <form action="{{ route('programs.join', $program->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class='bx bx-user-plus'></i>
                                    Join Program
                                </button>
                            </form>
                        @endif
                    </div>
                @endif


            </div>

            <!-- Right Details -->
            <aside class="lg:w-1/3 w-full bg-slate-50 border-l border-slate-200 p-6 space-y-5 overflow-y-auto">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-2 border-b border-slate-300">
                    <i class='bx bx-detail text-slate-600'></i>
                    Program Details
                </h3>

                @php
                    $progressComponent = view('components.programProgress', ['program' => $program])->render();

                    $currentVolunteers = $program->volunteers->count();
                    // $progressPercentage = ($currentVolunteers / $program->volunteer_count) * 100;
                    $progressPercentage = ($program->volunteer_count > 0)
                    ? ($currentVolunteers / $program->volunteer_count) * 100
                    : 0;
                    $details = [
                        ['icon' => 'calendar', 'label' => 'Date', 'value' => \Carbon\Carbon::parse($program->date)->format('M d, Y')],
                        ['icon' => 'time', 'label' => 'Time', 'value' => \Carbon\Carbon::parse($program->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($program->end_time)->format('h:i A')],
                        ['icon' => 'map-pin', 'label' => 'Location', 'value' => $program->location],
                        // ['icon' => 'group', 'label' => 'Volunteers Needed', 'value' => $program->volunteer_count]
                        [
                            'icon' => 'group',
                            'label' => 'Volunteers Needed',
                            'value' => new \Illuminate\Support\HtmlString('
                                                <div class="space-y-2">
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-slate-700">' . $currentVolunteers . ' / ' . $program->volunteer_count . ' volunteers</span>
                                                        <span class="text-slate-600">' . round($progressPercentage) . '%</span>
                                                    </div>
                                                    <div class="w-full bg-slate-200 rounded-full h-2">
                                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: ' . min($progressPercentage, 100) . '%"></div>
                                                    </div>
                                                </div>
                                            ')
                        ],

                        ['icon' => 'trending-up', 'label' => 'Progress', 'value' => $progressComponent]
                    ];
                @endphp

                @foreach ($details as $detail)
                    <div
                        class="bg-white p-4 border border-slate-200 rounded-lg hover:border-blue-200 transition-colors duration-200">
                        <div class="flex items-center gap-2 text-slate-600 text-sm mb-2">
                            <i class='bx bx-{{ $detail['icon'] }}'></i>
                            <span>{{ $detail['label'] }}</span>
                        </div>
                        {{-- <p class="text-slate-900 font-medium text-sm">{{ $detail['value'] }}</p> --}}
                        <p class="text-slate-900 font-medium text-sm">{!! $detail['value'] !!}</p>
                    </div>
                @endforeach

                {{-- <!-- Progress -->
                <div class="bg-white p-4 border border-slate-200 rounded-lg">
                    <div class="flex items-center gap-2 text-slate-600 text-sm mb-2">
                        <i class='bx bx-trending-up'></i>
                        <span>Progress</span>
                    </div>
                    <div class="space-y-2">
                        @php
                        $currentVolunteers = $program->volunteers->count();
                        $progressPercentage = ($currentVolunteers / $program->volunteer_count) * 100;
                        @endphp
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-700">{{ $currentVolunteers }} / {{ $program->volunteer_count }}
                                volunteers</span>
                            <span class="text-slate-600">{{ round($progressPercentage) }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                style="width: {{ min($progressPercentage, 100) }}%"></div>
                        </div>
                    </div>
                </div> --}}
            </aside>
        </div>

        <!-- Footer - Always Visible -->
        <footer class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex justify-end flex-shrink-0">
            <button onclick="document.getElementById('modal_{{ $program->id }}').close()"
                class="px-6 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                Close
            </button>
        </footer>

    </div>
</dialog>

<style>
    /* Custom scrollbar for description area */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Firefox scrollbar */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .modal-box {
            max-width: 95vw;
        }
    }

    @media (max-width: 768px) {
        .modal-box {
            max-width: 98vw;
            margin: 1rem;
            max-height: 95vh;
        }

        .flex.flex-col.lg\\:flex-row {
            flex-direction: column;
        }

        .lg\\:w-2\\/3,
        .lg\\:w-1\\/3 {
            width: 100%;
        }

        .border-l.border-slate-200 {
            border-left: none;
            border-top: 1px solid #e2e8f0;
        }
    }

    @media (max-width: 480px) {
        .modal-box {
            max-width: 100vw;
            margin: 0.5rem;
            max-height: 98vh;
        }

        header .px-6 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .p-6 {
            padding: 1rem;
        }

        footer .px-6 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>