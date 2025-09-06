@props([
    'first' => '',
    'second' => '',
])

<h2 class="text-4xl lg:text-5xl font-bold text-center text-balance mb-16">
    <span class="text-[#1A2235]">{{ $first }}</span>
    <span class="text-[#FFB51B]">{{ $second }}</span>
</h2>

{{--
    Usage:
    <x-section-title first="Meet the" second="Team" />
    <x-section-title first="Our" second="Programs" />
    <x-section-title first="About" second="Us" />
--}}
