@props([
    'title' => null,
    'icon' => null,
    'headerColor' => 'bg-[#1a2235] text-white', // main blue
    'bodyColor' => 'bg-white',
    'borderColor' => 'border-[#ffb51b]', // accent yellow
    'shadow' => 'shadow-md',
    'rounded' => 'rounded-xl',
    'headerClass' => '',
    'bodyClass' => '',
])

<div class="w-full {{ $borderColor }} border {{ $rounded }} {{ $shadow }} overflow-hidden">
    @if($title || $icon)
        <div class="flex items-center gap-2 px-6 py-4 {{ $headerColor }} {{ $headerClass }}">
            @if($icon)
                <span class="inline-flex items-center justify-center w-8 h-8 {{ $rounded }} bg-white/10">
                    <i class="bx {{ $icon }} text-xl"></i>
                </span>
            @endif
            <h3 class="text-lg font-semibold tracking-tight">{{ $title }}</h3>
        </div>
    @endif
    <div class="p-6 {{ $bodyColor }} {{ $bodyClass }}">
        {{ $slot }}
    </div>
</div>

{{--
Usage:
<x-card title="Basic Information" icon="bx-info-circle">
    ...
</x-card>

<x-card title="Schedule" icon="bx-calendar" headerColor="bg-[#ffb51b] text-[#1a2235]" borderColor="border-[#1a2235]">
    ...
</x-card>
--}} 