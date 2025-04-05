@php
    $styles = [
        'primary' => 'text-blue-500 hover:underline',
        'secondary' => 'text-gray-500 hover:text-gray-700',
        'danger' => 'text-red-500 hover:text-red-700',
        'success' => 'text-green-500 hover:text-green-700',
        'outline' => 'border border-gray-500 px-3 py-1 rounded-md hover:bg-gray-100',

        'nextPrevious' => 'flex items-center gap-2 px-4 py-2 bg-[#1a2235] text-white rounded-lg hover:bg-[#0e1425] transition-colors shadow-md',
    ];

    $sizes = [
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg font-semibold',
    ];
@endphp

<a {{ $attributes->merge(['class' => "inline-flex items-center gap-2 " . 
    ($styles[$variant] ?? $styles['primary']) . " " . 
    ($sizes[$size] ?? $sizes['md'])]) }}>
    {{ $slot }}
</a>
