<div id="modal-overlay-{{ $program->id }}" class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm hidden z-40"></div>

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
                        <h3 class="text-xl font-semibold text-[#1a2235] mb-3 flex items-center gap-2">
                            <i class='bx bx-book-open text-[#2a3449]'></i>
                            Description
                        </h3>
                        <p class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-gray-700 leading-relaxed text-base shadow-sm transition-all hover:bg-white">
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
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-2 border-white rounded-full"></div>
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
                        $details = [
                            ['icon' => 'calendar', 'label' => 'Date', 'value' => \Carbon\Carbon::parse($program->date)->format('M d, Y')],
                            ['icon' => 'time', 'label' => 'Time', 'value' => \Carbon\Carbon::parse($program->start_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($program->end_time)->format('h:i A')],
                            ['icon' => 'map-pin', 'label' => 'Location', 'value' => $program->location],
                            ['icon' => 'group', 'label' => 'Volunteers Needed', 'value' => $program->volunteer_count],
                            ['icon' => 'trending-up', 'label' => 'Progress', 'value' => ucfirst($program->progress)],
                        ];
                    @endphp

                    @foreach ($details as $detail)
                        <div class="space-y-1.5 bg-white p-3 rounded-lg border border-gray-100 transition-all hover:border-[#1a2235]/20">
                            <div class="flex items-center gap-2 text-[#1a2235] font-medium">
                                <i class='bx bx-{{ $detail['icon'] }} text-[#2a3449]'></i>
                                <span class="text-sm text-gray-600">{{ $detail['label'] }}</span>
                            </div>
                            <p class="text-[#1a2235] font-semibold pl-6 text-[15px]">{{ $detail['value'] }}</p>
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