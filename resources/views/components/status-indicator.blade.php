@php
$variant = [
    'success'     => 'bg-green-100 text-green-500 rounded-sm',
    'neutral'     => 'bg-indigo-50 text-gray-500 rounded-sm',
    'info'        => 'bg-blue-50 text-blue-500 rounded-sm',
    'warning'     => 'bg-yellow-50 text-yellow-500 rounded-sm',
    'danger'      => 'bg-red-50 text-red-500 rounded-sm',

    'approved'    => 'bg-green-100 text-green-500 rounded-sm',
    'denied'      => 'bg-red-50 text-red-500 rounded-sm',
    'completed'   => 'bg-green-100 text-green-500 rounded-sm',
    'in_progress' => 'bg-blue-50 text-blue-500 rounded-sm',
    'pending'     => 'bg-yellow-50 text-yellow-500 rounded-sm',
    'archived'    => 'bg-indigo-50 text-gray-500 rounded-sm',
    'published'   => 'bg-blue-50 text-blue-500 rounded-sm',
    'draft'       => 'bg-yellow-50 text-yellow-500 rounded-sm',
    'news'        => 'bg-red-50 text-red-600 rounded-sm',
    'program'     => 'bg-sky-50 text-sky-500 rounded-sm',
];

$style = $variant[$status] ?? 'bg-gray-300 text-black rounded-sm';
@endphp

<span class="inline-flex px-3 py-1 text-xs md:text-sm font-semibold leading-tight {{ $style }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
