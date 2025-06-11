<div class="bg-white border border-gray-200 rounded-lg p-6 hover:border-gray-300 transition-colors duration-200">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <div class="flex items-center space-x-3 mb-2 sm:mb-0">
            <!-- Avatar -->
            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                <i class='bx bx-user text-gray-500 text-lg'></i>
            </div>
            
            <!-- User Info -->
            <div>
                <p class="font-medium text-gray-900">
                    {{-- {{ $feedback->volunteer->user->name ?? 'Anonymous Volunteer' }} --}}
                    @if($feedback->user_type === 'guest')
                        {{ $feedback->guest_name ?? 'Guest' }} <span class="text-xs text-gray-500">(Guest)</span>
                    @elseif(isset($feedback->volunteer->user->name))
                        {{ $feedback->volunteer->user->name }}
                    @else
                        Anonymous Volunteer
                    @endif
                </p>
                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($feedback->submitted_at)->format('M j, Y \a\t g:i A') }}
                </p>
            </div>
        </div>

        <!-- Rating Badge -->
        <div class="flex items-center space-x-2">
            @php
                $rating = $feedback->rating ?? 0;
                $badgeClass = match($rating) {
                    5 => 'bg-green-50 text-green-700 border-green-200',
                    4 => 'bg-green-50 text-green-600 border-green-200',
                    3 => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                    2 => 'bg-orange-50 text-orange-700 border-orange-200',
                    1 => 'bg-red-50 text-red-700 border-red-200',
                    default => 'bg-gray-50 text-gray-700 border-gray-200',
                };
            @endphp
            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $badgeClass }}">
                <div class="flex items-center space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $rating)
                            <i class='bx bxs-star text-yellow-400 text-xs'></i>
                        @else
                            <i class='bx bx-star text-gray-300 text-xs'></i>
                        @endif
                    @endfor
                </div>
                <span class="ml-2">{{ $rating }}/5</span>
            </div>
        </div>
    </div>

    <!-- Feedback Content -->
    @if($feedback->feedback)
        <div class="prose prose-sm max-w-none">
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $feedback->feedback }}</p>
        </div>
    @else
        <p class="text-gray-500 italic">No written feedback provided.</p>
    @endif
</div>
