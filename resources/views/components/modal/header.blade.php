@props([
    'class' => '',
])

@php
    $baseClasses = 'px-6 py-4 border-b border-slate-200 bg-slate-50 flex-shrink-0';
    $finalClasses = $class ? "{$baseClasses} {$class}" : $baseClasses;
@endphp

<header {{ $attributes->merge(['class' => $finalClasses]) }}>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            {{ $slot }}
        </div>
        <x-modal.x-button />
    </div>
</header> 