@props([
    'align' => 'end', // start, center, end
    'class' => '',
])

@php
    $alignmentClasses = [
        'start' => 'justify-start',
        'center' => 'justify-center',
        'end' => 'justify-end',
    ];
    
    $baseClasses = 'border-t border-slate-200 px-6 py-4 bg-slate-50 flex gap-3 flex-shrink-0';
    $alignmentClass = $alignmentClasses[$align] ?? $alignmentClasses['end'];
@endphp

<footer {{ $attributes->merge(['class' => "{$baseClasses} {$alignmentClass} {$class}"]) }}>
    {{ $slot }}
</footer>