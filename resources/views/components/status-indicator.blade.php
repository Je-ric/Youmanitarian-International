@php
$variant = [
    'success'     => 'bg-green-100 text-green-500', // approved, completed, active
    'neutral'     => 'bg-indigo-50 text-gray-500', // archived, done, inactive
    'info'        => 'bg-blue-50 text-blue-500', // in_progress, published, program
    'warning'     => 'bg-yellow-50 text-yellow-500', // pending, draft
    'danger'      => 'bg-red-50 text-red-500', // denied, news
];

$style = $variant[$status] ?? 'bg-gray-300 text-black';
@endphp

<span class="inline-flex px-3 py-1 text-xs md:text-sm rounded font-semibold leading-tight {{ $style }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
    {{-- {{ ucfirst($status) }} --}}
</span>
