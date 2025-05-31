@props([
    'headers' => [],
    'variant' => 'default',
    'containerClass' => '',
    'tableClass' => '',
    'theadClass' => '',
    'tbodyClass' => '',
])

@php
    $variants = [
        'default' => [
            'container' => 'bg-white rounded-lg shadow-lg overflow-hidden',
            'table' => 'min-w-full',
            'thead' => 'bg-[#1a2235] text-white',
            'tbody' => 'divide-y divide-gray-200'
        ],
        'bordered' => [
            'container' => 'bg-white rounded-lg border border-gray-200 overflow-hidden',
            'table' => 'min-w-full',
            'thead' => 'bg-gray-50',
            'tbody' => 'divide-y divide-gray-200'
        ],
        'striped' => [
            'container' => 'bg-white rounded-lg shadow-lg overflow-hidden',
            'table' => 'min-w-full',
            'thead' => 'bg-[#1a2235] text-white',
            'tbody' => 'divide-y divide-gray-200 [&>tr:nth-child(even)]:bg-gray-50'
        ]
    ];

    $selectedVariant = $variants[$variant] ?? $variants['default'];

    $containerClasses = $containerClass ?: $selectedVariant['container'];
    $tableClasses = $tableClass ?: $selectedVariant['table'];
    $theadClasses = $theadClass ?: $selectedVariant['thead'];
    $tbodyClasses = $tbodyClass ?: $selectedVariant['tbody'];
@endphp

<div class="{{ $containerClasses }}">
    <table class="{{ $tableClasses }}">
        <thead class="{{ $theadClasses }}">
            <tr>
                @foreach($headers as $header)
                    <th class="px-6 py-3 text-left text-sm font-semibold">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="{{ $tbodyClasses }}">
            {{ $slot }}
        </tbody>
    </table>
</div>
