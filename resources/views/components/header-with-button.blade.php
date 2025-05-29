@props([
    'title',
    'description',
])

<div class="w-full mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-6 md:gap-0 py-6 px-4 md:px-6">
    <div class="flex flex-col flex-grow">
        <h2 class="text-black text-2xl md:text-3xl font-semibold tracking-tight mb-2">
            {{ $title }}
        </h2>
        <p class="text-black text-base md:text-lg font-light tracking-tight leading-relaxed">
            {{ $description }}
        </p>
    </div>
    <div class="mt-4 md:mt-0">
        {{ $slot }} {{-- Anything, HAHAHAHA atleast hindi nagcecenter  --}}
    </div>
</div>
