@extends('layouts.sidebar_final')

@section('content')
    <div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-6 sm:text-left">
            Feedback for "{{ $program->title }}"
        </h1>

        <div class="md:flex md:space-x-8">
            {{-- Left: Summary Card --}}
            <div class="md:w-1/3 bg-white p-6 rounded-lg shadow-md mb-8 md:mb-0">
                <h3 class="text-xl font-semibold mb-4">Feedback Summary</h3>

                <p class="text-gray-700 mb-1">Overall program rating</p>
                <div class="flex items-center space-x-2 mb-2">
                    @php
                        $fullStars = floor($averageRating);
                        $halfStar = $averageRating - $fullStars >= 0.5;
                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                    @endphp

                    {{-- Full stars --}}
                    @for ($i = 0; $i < $fullStars; $i++)
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.165c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.034 9.384c-.783-.57-.38-1.81.588-1.81h4.165a1 1 0 00.95-.69l1.286-3.957z" />
                        </svg>
                    @endfor

                    {{-- Half star --}}
                    @if ($halfStar)
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <defs>
                                <linearGradient id="half-grad">
                                    <stop offset="50%" stop-color="currentColor" />
                                    <stop offset="50%" stop-color="transparent" />
                                </linearGradient>
                            </defs>
                            <path fill="url(#half-grad)"
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.165c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.034 9.384c-.783-.57-.38-1.81.588-1.81h4.165a1 1 0 00.95-.69l1.286-3.957z" />
                        </svg>
                    @endif

                    {{-- Empty stars --}}
                    @for ($i = 0; $i < $emptyStars; $i++)
                        <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.165c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.034 9.384c-.783-.57-.38-1.81.588-1.81h4.165a1 1 0 00.95-.69l1.286-3.957z" />
                        </svg>
                    @endfor
                </div>

                <p class="text-gray-900 font-semibold mb-2">Average rating ({{ $averageRating }})</p>
                <p class="text-gray-700 mb-4">{{ $totalFeedbacks }} review{{ $totalFeedbacks !== 1 ? 's' : '' }}</p>

                <div class="space-y-2">
                    @foreach(array_reverse($ratingCounts, true) as $stars => $count)
                        @php
                            $percent = $totalFeedbacks ? round(($count / $totalFeedbacks) * 100) : 0;
                        @endphp
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center space-x-1"
                                aria-label="{{ $stars }} star{{ $stars > 1 ? 's' : '' }}">
                                <span class="text-sm font-medium text-gray-800">{{ $stars }}</span>
                                <span class="mask mask-star w-6 h-6 bg-yellow-400" aria-hidden="true"></span>
                            </span>
                            <div class="flex-grow h-4 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-4 bg-yellow-400 rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="w-8 text-sm text-gray-600 text-right">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Feedback list with tabs --}}
            <div class="md:w-2/3" x-data="{ tab: 'all' }">

                <nav class="flex space-x-4 mb-6 border-b border-gray-200">
                    <button :class="tab === 'all' ? 'border-b-2 border-yellow-500 font-semibold text-yellow-600' : 'text-gray-600 hover:text-yellow-500'" @click="tab = 'all'">
                        All Feedbacks ({{ $totalFeedbacks }})
                    </button>

                    <button :class="tab === 'positive' ? 'border-b-2 border-yellow-500 font-semibold text-yellow-600' : 'text-gray-600 hover:text-yellow-500'" @click="tab = 'positive'">
                        Positive (4-5 stars)
                    </button>

                    <button :class="tab === 'neutral' ? 'border-b-2 border-yellow-500 font-semibold text-yellow-600' : 'text-gray-600 hover:text-yellow-500'" @click="tab = 'neutral'">
                        Neutral (3 stars)
                    </button>

                    <button :class="tab === 'needs_improvement' ? 'border-b-2 border-yellow-500 font-semibold text-yellow-600' : 'text-gray-600 hover:text-yellow-500'" @click="tab = 'needs_improvement'">
                        Needs Improvement (1-2 stars)
                    </button>
                </nav>

                <div class="space-y-6">

                    @if($feedbacks->isEmpty())
                        <p class="text-gray-500 text-center md:text-left">No feedback submitted for this program yet.</p>
                    @endif

                    <template x-if="tab === 'all'">
                        <div>
                            @foreach($feedbacks as $feedback)
                                @include('programs.partials.feedbackItem', ['feedback' => $feedback])
                            @endforeach
                        </div>
                    </template>

                    <template x-if="tab === 'positive'">
                        <div>
                            @foreach($feedbacks->whereIn('rating', [4, 5]) as $feedback)
                                @include('programs.partials.feedbackItem', ['feedback' => $feedback])
                            @endforeach
                        </div>
                    </template>

                    <template x-if="tab === 'neutral'">
                        <div>
                            @foreach($feedbacks->where('rating', 3) as $feedback)
                                @include('programs.partials.feedbackItem', ['feedback' => $feedback])
                            @endforeach
                        </div>
                    </template>

                    <template x-if="tab === 'needs_improvement'">
                        <div>
                            @foreach($feedbacks->whereIn('rating', [1, 2]) as $feedback)
                                {{-- <x-feedback-item :feedback="$feedback" /> --}}
                                @include('programs.partials.feedbackItem', ['feedback' => $feedback])
                            @endforeach
                        </div>
                    </template>

                </div>
            </div>

        </div>
@endsection