<div class="w-full">
    <!-- Header -->
    {{-- <div class="mb-8">
        <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
            "{{ $program->title }}"
        </h1>
        <p class="text-gray-600">Review and analyze participant feedback for this program</p>
    </div> --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left: Summary Card --}}
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-0.5">Feedback Summary</h2>
                <p class="text-gray-500 text-sm mb-2">Overall program rating</p>

                <!-- Overall Rating -->
                <div class="text-center mb-6 pb-6 border-b border-gray-100">
                    <div class="text-4xl font-bold text-gray-900 mb-2">{{ number_format($averageRating, 1) }}</div>
                    <div class="flex items-center justify-center space-x-1 mb-2">
                        @php
                            $fullStars = floor($averageRating);
                            $halfStar = $averageRating - $fullStars >= 0.5;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                        @endphp

                        {{-- Full stars --}}
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class='bx bxs-star text-yellow-400 text-xl'></i>
                        @endfor

                        {{-- Half star --}}
                        @if ($halfStar)
                            <i class='bx bxs-star-half text-yellow-400 text-xl'></i>
                        @endif

                        {{-- Empty stars --}}
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <i class='bx bx-star text-gray-300 text-xl'></i>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-600">Based on {{ $totalFeedbacks }}
                        review{{ $totalFeedbacks !== 1 ? 's' : '' }}</p>
                </div>

                <!-- Rating Breakdown -->
                <div class="space-y-3">
                    @foreach(array_reverse($ratingCounts, true) as $stars => $count)
                        @php
                            $percent = $totalFeedbacks ? round(($count / $totalFeedbacks) * 100) : 0;
                        @endphp
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-1 w-12">
                                <span class="text-sm font-medium text-gray-700">{{ $stars }}</span>
                                <i class='bx bxs-star text-yellow-400 text-sm'></i>
                            </div>
                            <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 rounded-full transition-all duration-300"
                                    style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="text-sm text-gray-600 w-8 text-right">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Feedback list with tabs --}}
        <div class="lg:col-span-2">
            @php
                $tabs = [
                    ['id' => 'all', 'label' => 'All (' . $totalFeedbacks . ')', 'icon' => 'bx-list-ul'],
                    ['id' => 'positive', 'label' => 'Positive', 'icon' => 'bx-smile'],
                    ['id' => 'neutral', 'label' => 'Neutral', 'icon' => 'bx-meh'],
                    ['id' => 'needs_improvement', 'label' => 'Needs Improvement', 'icon' => 'bx-sad']
                ];
            @endphp

            <x-navigation-layout.tabs
                :tabs="$tabs"
                default-tab="all"
            >
                <x-slot:slot_all>
                    <div class="space-y-4">
                        @forelse($feedbacks as $feedback)
                            <div class="bg-white rounded-lg p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                            <i class='bx bx-user text-primary text-xl'></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">
                                                @if($feedback->user_type === 'guest')
                                                    {{ $feedback->guest_name ?? 'Guest' }} <span class="text-xs text-gray-500">(Guest)</span>
                                                @elseif(isset($feedback->volunteer->user->name))
                                                    {{ $feedback->volunteer->user->name }}
                                                @else
                                                    Anonymous Volunteer
                                                @endif
                                            </h4>
                                            <p class="text-sm text-gray-500">{{ $feedback->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class='bx {{ $i <= $feedback->rating ? 'bxs-star text-yellow-400' : 'bx-star text-gray-300' }}'></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mt-3 text-gray-600">{{ $feedback->feedback }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class='bx bx-message-square-dots text-gray-400 text-2xl'></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">No Feedback Yet</h3>
                                <p class="text-gray-500">There are no feedback entries for this category.</p>
                            </div>
                        @endforelse
                    </div>
                </x-slot>

                <x-slot:slot_positive>
                    <div class="space-y-4">
                    @if($feedbacks->whereIn('rating', [4, 5])->isEmpty())
                        <div class="text-center py-8">
                            <i class='bx bx-smile text-3xl text-gray-300 mb-2'></i>
                            <p class="text-gray-500">No positive feedback yet.</p>
                        </div>
                        @else
                            @foreach($feedbacks->whereIn('rating', [4, 5]) as $feedback)
                                @include('programs_volunteers.partials.feedbackItem', ['feedback' => $feedback])
                            @endforeach
                    @endif
                </div>
                </x-slot>

                <x-slot:slot_neutral>
                    <div class="space-y-4">
                    @if($feedbacks->where('rating', 3)->isEmpty())
                        <div class="text-center py-8">
                            <i class='bx bx-meh text-3xl text-gray-300 mb-2'></i>
                            <p class="text-gray-500">No neutral feedback yet.</p>
                        </div>
                        @else
                            @foreach($feedbacks->where('rating', 3) as $feedback)
                                @include('programs_volunteers.partials.feedbackItem', ['feedback' => $feedback])
                            @endforeach
                    @endif
                </div>
                </x-slot>

                <x-slot:slot_needs_improvement>
                    <div class="space-y-4">
                    @if($feedbacks->whereIn('rating', [1, 2])->isEmpty())
                        <div class="text-center py-8">
                            <i class='bx bx-sad text-3xl text-gray-300 mb-2'></i>
                            <p class="text-gray-500">No critical feedback yet.</p>
                        </div>
                        @else
                            @foreach($feedbacks->whereIn('rating', [1, 2]) as $feedback)
                                @include('programs_volunteers.partials.feedbackItem', ['feedback' => $feedback])
                            @endforeach
                    @endif
                </div>
                </x-slot>
            </x-navigation-layout.tabs>
        </div>
    </div>
</div>