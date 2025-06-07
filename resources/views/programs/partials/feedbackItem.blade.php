<div class="p-4 border rounded-md shadow-sm bg-white">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
        <div class="mb-2 sm:mb-0">
            <p class="font-semibold text-gray-800">
                {{ $feedback->volunteer->user->name ?? 'Anonymous Volunteer' }}
            </p>

            <div class="flex items-center space-x-4">
                <div class="rating rating-sm text-yellow-400">
                    @for ($i = 1; $i <= 5; $i++)
                        <input 
                            type="radio" 
                            name="rating-{{ $feedback->id }}" 
                            class="mask mask-star-2 bg-yellow-400" 
                            {{ $i == $feedback->rating ? 'checked' : '' }} 
                            disabled 
                        />
                    @endfor
                </div>

                <p class="text-sm text-gray-500 mt-1">
                    {{ \Carbon\Carbon::parse($feedback->submitted_at)->format('F j, Y g:i A') }}
                </p>
            </div>
        </div>

        {{-- Star count text on the right --}}
        <div>
            @php
                $rating = $feedback->rating ?? 0;
                $colorClass = match($rating) {
                    5 => 'text-green-600',
                    4 => 'text-green-500',
                    3 => 'text-yellow-500',
                    2 => 'text-orange-500',
                    1 => 'text-red-600',
                    default => 'text-gray-500',
                };
            @endphp
            <p class="font-semibold {{ $colorClass }}">
                {{ $rating }} star{{ $rating !== 1 ? 's' : '' }}
            </p>
        </div>
    </div>

    <p class="text-gray-700 whitespace-pre-line">{{ $feedback->feedback ?? 'No written feedback.' }}</p>
</div>
