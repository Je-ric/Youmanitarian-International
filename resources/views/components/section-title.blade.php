@props([
    'first' => '',
    'second' => '',
    'firstColor' => '#1A2235',
    'mb' => true,
    'textAlign' => 'center', // left, center, right
])

@php
    $mbClass = filter_var($mb, FILTER_VALIDATE_BOOLEAN) ? 'mb-10' : '';
    $textAlignClass = match($textAlign) {
        'left' => 'text-left',
        'right' => 'text-right',
        default => 'text-center',
    };
@endphp

<h2 class="text-3xl lg:text-4xl font-bold mt-6 {{ $textAlignClass }} {{ $mbClass }}">
    <span class="text-[{{ $firstColor }}]">{{ $first }}</span>
    <span class="text-[#FFB51B]">{{ $second }}</span>
</h2>

{{-- Usage Examples:

<x-section-title first="Meet the" second="Team" /> <!-- has mb -->
<x-section-title first="Our" second="Programs" mb="false" /> <!-- no mb -->
<x-section-title first="About" second="Us" firstColor="#FFFFFF" textAlign="left" />

--}}
