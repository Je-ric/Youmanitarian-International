@props(['status', 'label' => null])

@php
$variant = [
    'success' => 'bg-green-100 text-green-500',
    'neutral' => 'bg-indigo-50 text-gray-500',
    'info'    => 'bg-blue-50 text-blue-500',
    'warning' => 'bg-yellow-50 text-yellow-500',
    'danger'  => 'bg-red-50 text-red-500',
];

$style = $variant[$status] ?? 'bg-gray-300 text-black';
@endphp

<span class="inline-flex px-3 py-1 text-xs md:text-sm rounded font-semibold leading-tight {{ $style }}">
    {{ $label ?? ucfirst(str_replace('_', ' ', $status)) }}
</span>
