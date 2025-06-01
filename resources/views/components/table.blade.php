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
            'tbody' => 'divide-y divide-gray-200',
        ],
        'bordered' => [
            'container' => 'bg-white rounded-lg border border-gray-200 overflow-hidden',
            'table' => 'min-w-full',
            'thead' => 'bg-gray-50',
            'tbody' => 'divide-y divide-gray-200',
        ],
        'striped' => [
            'container' => 'bg-white rounded-lg shadow-lg overflow-hidden',
            'table' => 'min-w-full',
            'thead' => 'bg-[#1a2235] text-white',
            'tbody' => 'divide-y divide-gray-200 [&>tr:nth-child(even)]:bg-gray-50',
        ],
    ];

    $selectedVariant = $variants[$variant] ?? $variants['default'];

    // Add responsive overflow-x-auto to container for mobile horizontal scroll
    $containerClasses = ($containerClass ?: $selectedVariant['container']) . ' overflow-x-auto';

    // Add responsive font size to table
    $tableClasses = ($tableClass ?: $selectedVariant['table']) . ' text-sm md:text-base lg:text-lg';

    $theadClasses = $theadClass ?: $selectedVariant['thead'];
    $tbodyClasses = $tbodyClass ?: $selectedVariant['tbody'];
@endphp

<div class="{{ $containerClasses }}">
    <table class="{{ $tableClasses }}">
        <thead class="{{ $theadClasses }}">
            <tr>
                @foreach($headers as $header)
                
                    @php
                        $label = is_array($header) ? $header['label'] : $header;
                        $hideOnSmall = is_array($header) && ($header['hideOnSmall'] ?? false);
                        $thClasses = 'px-6 py-3 text-left font-semibold';
                        if ($hideOnSmall) {
                            $thClasses .= ' hidden sm:table-cell';
                        }
                    @endphp
                    <th class="{{ $thClasses }}">
                        {{ $label }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="{{ $tbodyClasses }}">
            {{ $slot }}
        </tbody>
    </table>
</div>
