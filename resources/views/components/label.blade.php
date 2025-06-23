@props([
    'for' => null,
    'class' => '',
])

<label
    @if($for) for="{{ $for }}" @endif
    class="flex items-center text-sm font-medium sm:gap-2 text-gray-700 mb-2 {{ $class }}"
>
    {{ $slot }} {{-- for icon --}}
</label> 