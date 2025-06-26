@props([
    'icon' => null, // Boxicons class, e.g. 'bx-user'
    'title', // Page title
    'desc' => null, // Optional subtitle
    'class' => '',
])

<div class="w-full bg-[#f4f5f7] flex flex-col sm:flex-row justify-between items-center gap-4 px-6 py-4 border-y border-gray-200 {{ $class }}">
    <!-- Title Group -->
    <div class="flex items-center gap-4">
        @if($icon)
            <span class="flex-shrink-0 inline-flex items-center justify-center shadow-lg rounded-lg bg-white text-[#ffb51b] w-12 h-12 text-2xl">
                <i class="bx {{ $icon }}"></i>
            </span>
        @endif
        <div>
            <h1 class="text-xl font-bold text-[#1a2235]">{{ $title }}</h1>
            @if($desc)
                <p class="text-sm text-gray-500 mt-1">{{ $desc }}</p>
            @endif
        </div>
    </div>
    
    <!-- Slot for actions -->
    <div class="flex-shrink-0">
        {{ $slot }}
    </div>
</div> 