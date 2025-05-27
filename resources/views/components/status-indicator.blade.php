@php
$variant = [
    'success'     => 'bg-green-100 text-green-500 rounded-sm', // approved, completed
    'neutral'     => 'bg-indigo-50 text-gray-500 rounded-sm', // archived
    'info'        => 'bg-blue-50 text-blue-500 rounded-sm', // in_progress, published, program
    'warning'     => 'bg-yellow-50 text-yellow-500 rounded-sm', // pending, draft
    'danger'      => 'bg-red-50 text-red-500 rounded-sm', // denied, news
];

$style = $variant[$status] ?? 'bg-gray-300 text-black rounded-sm';
@endphp

<span class="inline-flex px-3 py-1 text-xs md:text-sm font-semibold leading-tight {{ $style }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
    {{-- {{ ucfirst($status) }} --}}
</span>
