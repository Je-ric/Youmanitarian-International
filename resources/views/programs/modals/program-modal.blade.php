{{-- <div id="modal-overlay-{{ $program->id }}" class="fixed inset-0 bg-slate-900/20 backdrop-blur-sm hidden z-40"></div> --}}

<x-modal.dialog id="modal_{{ $program->id }}" maxWidth="max-w-6xl" width="w-11/12" maxHeight="max-h-[90vh]">
        <x-modal.header>
            <h2 id="modal-title-{{ $program->id }}" class="text-2xl font-bold text-slate-900 tracking-tight">
                {{ $program->title }}
            </h2>
        </x-modal.header>
        <x-modal.body :padded="false">
            <div class="flex flex-col lg:flex-row flex-1 min-h-0 overflow-hidden">
                {{-- Left --}}
                <div class="lg:w-2/3 w-full p-6 space-y-6 overflow-y-auto">

                    <article>
                        <h3 class="text-lg font-semibold text-slate-900 mb-3 flex items-center gap-2">
                            <i class='bx bx-book-open text-slate-600'></i>
                            Description
                        </h3>
                        <div
                            class="bg-slate-50 border border-slate-200 rounded-lg p-4 max-h-36 overflow-y-auto custom-scrollbar-gold">
                            <p class="text-slate-700 leading-relaxed">
                                {{ $program->description }}
                            </p>
                        </div>
                    </article>

                    {{-- Program Coordinator --}}
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

                    {{-- Join Button --}}
                    @php
                        $volunteer = Auth::user()->volunteer ?? null;
                        $alreadyJoined = false;
                        if(Auth::user()->hasRole('Volunteer') && $volunteer) {
                            $alreadyJoined = $program->volunteers->contains($volunteer->id);
                        }
                        $isCoordinator = Auth::id() === $program->created_by;
                    @endphp

                    @if(Auth::user()->hasRole('Volunteer') && !$isCoordinator)
                        @php
                            $currentVolunteers = $program->volunteers->count();
                            $volunteer = Auth::user()->volunteer;
                            $alreadyJoined = $program->volunteers->contains($volunteer?->id ?? 0);
                            
                            // Check if the volunteer has any task assignments for this program
                            $hasTasks = $volunteer ? $volunteer->taskAssignments()
                                ->whereHas('task', function ($query) use ($program) {
                                    $query->where('program_id', $program->id);
                                })->exists() : false;
                        @endphp

                        <div class="border-t border-slate-200 pt-6">
                            @if($program->progress_status === 'done')
                                <x-feedback-status.alert type="success" icon="bx bx-check-circle" message="This program is already done." />
                            @elseif($currentVolunteers >= $program->volunteer_count)
                                <x-feedback-status.alert type="error" icon="bx bx-error-circle" message="All volunteer slots are filled, but you're welcome to join as a guest, viewer, or supporter!" />
                            @elseif($alreadyJoined)
                                <div class="space-y-4">
                                    <x-feedback-status.alert type="success" icon="bx bx-check-circle" message="You are already joined in this program." />
                                    
                                    @if($program->progress_status === 'incoming' && !$hasTasks)
                                        <form action="{{ route('programs.leave', [$program->id, $volunteer->id]) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to leave this program?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                                <i class='bx bx-log-out'></i>
                                                Leave Program
                                            </button>
                                        </form>
                                    @else
                                        @if($hasTasks)
                                            <x-feedback-status.alert type="error" icon="bx bx-task" message="You cannot leave this program because you have assigned tasks." />
                                        @elseif($program->progress_status !== 'incoming')
                                            <x-feedback-status.alert type="info" icon="bx bx-lock" message="You cannot leave this program because it is no longer in incoming status." />
                                        @endif
                                    @endif
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

                {{-- Right --}}
                <aside class="lg:w-1/3 w-full bg-slate-50 border-l border-slate-200 p-6 space-y-5 overflow-y-auto">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2 pb-2 border-b border-slate-300">
                        <i class='bx bx-detail text-slate-600'></i>
                        Program Details
                    </h3>

                    @php
                        $progressComponent = view('components.feedback-status.programProgress', ['program' => $program])->render();

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

            
                </aside>
            </div>
        </x-modal.body>

        <x-modal.footer>
            <x-modal.close-button :modalId="'modal_' . $program->id" />
        </x-modal.footer>

</x-modal.dialog>

<style>
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

    {{-- Firefox scrollbar --}}
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    {{-- Responsive adjustments --}}
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