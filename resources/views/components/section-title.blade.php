@props([
    'first' => '',
    'second' => '',
    'firstColor' => '#1A2235',
    'mb' => true,
])

@php
    $mbClass = filter_var($mb, FILTER_VALIDATE_BOOLEAN) ? 'mb-10' : '';
@endphp

<h2 class="text-4xl lg:text-5xl font-bold text-center {{ $mbClass }}">
    <span class="text-[{{ $firstColor }}]">{{ $first }}</span>
    <span class="text-[#FFB51B]">{{ $second }}</span>
</h2>

{{-- Usage Examples:

<x-section-title first="Meet the" second="Team" /> <!-- has mb -->
<x-section-title first="Our" second="Programs" mb="false" /> <!-- no mb -->
<x-section-title first="About" second="Us" firstColor="#FFFFFF" />

--}}
