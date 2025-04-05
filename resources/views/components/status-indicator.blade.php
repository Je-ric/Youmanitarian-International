@php

    $styles = [
        'solid' => [
            'success'  => 'bg-green-500 text-white',  // completed, approved, ongoing, active
            'warning'  => 'bg-yellow-500 text-white',  // draft, pending
            'info'     => 'bg-blue-500 text-white',   // published, incoming, in-progress,
            'danger'   => 'bg-red-500 text-white',    // delete, reject
            'neutral'  => 'bg-gray-500 text-white',  // done, archived, inactive

            'news' => 'bg-red-600 text-white',
            'program'  => 'bg-sky-500 text-white',
        ],

        'outline' => [
            'success'  => 'border border-green-500 text-green-500 bg-green-50', // active, completed, approved
            'neutral'  => 'border border-gray-500 text-gray-500 bg-gray-50', // inactive, archived, done
            'info'     => 'border border-blue-500 text-blue-500 bg-blue-50', // published, incoming,in-progress,
            'warning'  => 'border border-yellow-500 text-yellow-500 bg-yellow-50', // draft, pending
            'danger'   => 'border border-red-500 text-red-500 bg-red-50', // rejected

            'approved'  => 'border border-green-500 text-green-500 bg-green-50',
            'denied'  => 'border border-red-500 text-red-500 bg-red-50',
            'completed'  => 'border border-green-500 text-green-500 bg-green-50',
            'in_progress'     => 'border border-blue-500 text-blue-500 bg-blue-50',
            'pending'  => 'border border-yellow-500 text-yellow-500 bg-yellow-50',
            'archived'  => 'border border-gray-500 text-gray-500 bg-gray-50',
            'published'     => 'border border-blue-500 text-blue-500 bg-blue-50',
            'draft' => 'border border-yellow-500 text-yellow-500 bg-yellow-50',
            'news' => 'border border-red-600 text-red-600 bg-red-50',
            'program'  => 'border border-sky-500 text-sky-500 bg-sky-50'
    ],
];


    $style = $styles[$variant][$status] ?? 'bg-gray-300 text-black';
@endphp

<span class="px-3 py-1 text-xs font-semibold rounded-lg {{ $style }}">
    {{ ucfirst($status) }}
</span>
