@props([
    'title',
    'maxHeight' => 'none',
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg border border-gray-200 p-4 sm:p-6 shadow-sm flex flex-col']) }}>
    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">{{ $title }}</h3>
    <div 
        class="flex-grow space-y-4"
        @if($maxHeight !== 'none')
            style="max-height: {{ $maxHeight }};"
        @endif
    >
        {{ $slot }}
    </div>
</div> 