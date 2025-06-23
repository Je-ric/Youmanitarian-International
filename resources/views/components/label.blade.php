@props([
    'for' => null,
    'class' => '',
])

{{-- Pass an icon in the slot before the text for icon labels --}}
<label
    @if($for) for="{{ $for }}" @endif
    class="flex items-center gap-1 sm:gap-3 text-sm sm:text-base font-medium text-gray-700 mb-2 {{ $class }}"
>
    {{ $slot }}
</label> 