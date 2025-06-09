<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                "{{ $program->title }}"
            </h1>
            <p class="text-gray-600">Review and analyze participant feedback for this program</p>
        </div>

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
            <div class="lg:col-span-2" x-data="{ activeTab: 'all' }">
                <!-- Tab Navigation -->
                <div class="mb-6">
                    <div class="bg-gray-50 p-1 rounded-lg inline-flex space-x-1">
                        <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-white text-gray-900 border border-gray-200' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                            <i class='bx bx-list-ul mr-1'></i>
                            All ({{ $totalFeedbacks }})
                        </button>

                        <button @click="activeTab = 'positive'" :class="activeTab === 'positive' ? 'bg-white text-gray-900 border border-gray-200' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                            <i class='bx bx-smile mr-1'></i>
                            Positive
                        </button>

                        <button @click="activeTab = 'neutral'" :class="activeTab === 'neutral' ? 'bg-white text-gray-900 border border-gray-200' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                            <i class='bx bx-meh mr-1'></i>
                            Neutral
                        </button>

                        <button @click="activeTab = 'needs_improvement'" :class="activeTab === 'needs_improvement' ? 'bg-white text-gray-900 border border-gray-200' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                            <i class='bx bx-sad mr-1'></i>
                            Needs Improvement
                        </button>
                    </div>
                </div>

                <!-- Feedback Content -->
                <div class="space-y-4">
                    @if($feedbacks->isEmpty())
                        <div class="text-center py-12">
                            <i class='bx bx-message-dots text-4xl text-gray-300 mb-4'></i>
                            <p class="text-gray-500 text-lg">No feedback submitted for this program yet.</p>
                            <p class="text-gray-400 text-sm mt-2">Feedback will appear here once participants submit their
                                reviews.</p>
                        </div>
                    @endif

                    <!-- All Feedbacks -->
                    <div x-show="activeTab === 'all'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @foreach($feedbacks as $feedback)
                            @include('programs.partials.feedbackItem', ['feedback' => $feedback])
                        @endforeach
                    </div>

                    <!-- Positive Feedbacks -->
                    <div x-show="activeTab === 'positive'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @foreach($feedbacks->whereIn('rating', [4, 5]) as $feedback)
                            @include('programs.partials.feedbackItem', ['feedback' => $feedback])
                        @endforeach
                        @if($feedbacks->whereIn('rating', [4, 5])->isEmpty())
                            <div class="text-center py-8">
                                <i class='bx bx-smile text-3xl text-gray-300 mb-2'></i>
                                <p class="text-gray-500">No positive feedback yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Neutral Feedbacks -->
                    <div x-show="activeTab === 'neutral'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @foreach($feedbacks->where('rating', 3) as $feedback)
                            @include('programs.partials.feedbackItem', ['feedback' => $feedback])
                        @endforeach
                        @if($feedbacks->where('rating', 3)->isEmpty())
                            <div class="text-center py-8">
                                <i class='bx bx-meh text-3xl text-gray-300 mb-2'></i>
                                <p class="text-gray-500">No neutral feedback yet.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Needs Improvement Feedbacks -->
                    <div x-show="activeTab === 'needs_improvement'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @foreach($feedbacks->whereIn('rating', [1, 2]) as $feedback)
                            @include('programs.partials.feedbackItem', ['feedback' => $feedback])
                        @endforeach
                        @if($feedbacks->whereIn('rating', [1, 2])->isEmpty())
                            <div class="text-center py-8">
                                <i class='bx bx-sad text-3xl text-gray-300 mb-2'></i>
                                <p class="text-gray-500">No critical feedback yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>