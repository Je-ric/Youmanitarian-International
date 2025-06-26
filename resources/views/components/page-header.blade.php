@props([
    'icon' => null, 
    'title',
    'desc' => null, 
    'class' => '',
])

<div class="w-full bg-[#f4f5f7] flex flex-col md:flex-row justify-between items-start md:items-center gap-4 px-4 sm:px-6 py-4 border-y border-gray-200 {{ $class }}">

    <div class="flex items-start md:items-center gap-3 sm:gap-4">
        @if($icon)
            <span class="flex-shrink-0 inline-flex items-center justify-center shadow-lg rounded-lg bg-white text-[#ffb51b] w-10 h-10 sm:w-12 sm:h-12 text-xl sm:text-2xl">
                <i class="bx {{ $icon }}"></i>
            </span>
        @endif
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-[#1a2235]">{{ $title }}</h1>
            @if($desc)
                <p class="text-sm text-gray-500 mt-1">{{ $desc }}</p>
            @endif
        </div>
    </div>
    
    <div class="flex-shrink-0 w-full md:w-auto flex flex-row md:justify-end gap-2 mt-2 md:mt-0">
        {{ $slot }}
    </div>
</div> 