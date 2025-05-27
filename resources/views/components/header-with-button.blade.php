@props([
    'title',
    'description',
    'buttonText',
    'buttonVariant' => 'primary',
])

<div class="w-full flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0 py-4 px-4">
    <div class="flex flex-col">
        <h2 class="text-black text-2xl font-semibold tracking-tight">{{ $title }}</h2>
        <p class="text-black text-base md:text-lg font-light tracking-tight">
            {{ $description }}
        </p>
    </div>
    <x-button variant="{{ $buttonVariant }}">
        {{ $buttonText }}
    </x-button>
</div>


