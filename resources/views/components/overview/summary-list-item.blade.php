@props([
    'imageUrl' => null,
    'icon' => null,
    'fallbackIcon' => 'bx-user',
])

<div {{ $attributes->merge(['class' => 'flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0']) }}>
    <div class="flex items-center gap-3 sm:gap-4">
        @if($imageUrl)
            <img src="{{ $imageUrl }}" class="w-10 h-10 rounded-full object-cover">
        @elseif($icon)
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                <i class='bx {{ $icon }} text-xl sm:text-2xl text-gray-500'></i>
            </div>
        @else
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                <i class='bx {{ $fallbackIcon }} text-xl sm:text-2xl text-gray-500'></i>
            </div>
        @endif
        
        <div class="flex-grow">
            @if(isset($title))
                <div class="text-sm font-semibold text-gray-800">{{ $title }}</div>
            @endif
            @if(isset($subtitle))
                <div class="text-xs sm:text-sm text-gray-500">{{ $subtitle }}</div>
            @endif
        </div>
    </div>

    @if(isset($action))
        <div class="text-xs sm:text-sm text-gray-600 whitespace-nowrap">
            {{ $action }}
        </div>
    @endif
</div> 