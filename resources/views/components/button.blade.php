{{-- Available for anchor links --}}

@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $variant = strval($variant);
    $styles = [
        'primary'   => 'btn bg-[#ffb51b] hover:bg-[#141a2b] text-white active:scale-95 transition-transform duration-200',
        'secondary' => 'btn bg-[#1a2235] hover:bg-[#e6a011] text-white active:scale-95 transition-transform duration-200',
        'success'   => 'btn btn-success text-white hover:bg-green-600 active:scale-95 transition-transform duration-200',
        'danger'    => 'btn bg-red-600 text-white hover:bg-red-400 active:scale-95 transition-transform duration-200',
        'warning'   => 'btn btn-warning text-white hover:bg-[#e6a011] active:scale-95 transition-transform duration-200',
        'info'      => 'btn btn-info text-white hover:bg-blue-600 active:scale-95 transition-transform duration-200',
        'manage'    => 'btn bg-emerald-500 text-white hover:bg-emerald-600 active:scale-95 transition-transform duration-200',

        'indigo'    => 'btn bg-indigo-500 text-white hover:bg-indigo-600 active:scale-95 transition-transform duration-200',
        'amber'     => 'btn bg-amber-500 text-white hover:bg-amber-600 active:scale-95 transition-transform duration-200',
        'lime'      => 'btn bg-lime-500 text-white hover:bg-lime-600 active:scale-95 transition-transform duration-200',
        'purple'    => 'btn bg-purple-500 text-white hover:bg-purple-600 active:scale-95 transition-transform duration-200',
        'pink'      => 'btn bg-pink-500 text-white hover:bg-pink-600 active:scale-95 transition-transform duration-200',
        
        'add-create'   => 'btn bg-[#ffb51b] hover:bg-[#141a2b] text-white active:scale-95 transition-transform duration-200',
        'save-submit'   => 'btn bg-[#ffb51b] hover:bg-[#141a2b] text-white active:scale-95 transition-transform duration-200',

        'restore'   => 'btn bg-blue-500 text-white hover:bg-blue-600 active:scale-95 transition-transform duration-200',
        'approve'   => 'btn bg-green-500 text-white hover:bg-green-600 active:scale-95 transition-transform duration-200',
        'deny'      => 'btn bg-red-500 text-white hover:bg-red-600 active:scale-95 transition-transform duration-200',
        
        'delete'    => 'text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center',
        'close'     => 'py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700',
    ];

    $class = "inline-flex items-center justify-center gap-1 px-4 py-2 rounded-md font-semibold transition duration-200 " . ($styles[$variant] ?? $styles['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif
