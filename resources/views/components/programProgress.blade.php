@props(['program'])

@php
    $status = $program->progress_status_with_style;
    
    // Define icons and colors for each status
    $statusConfig = [
        'incoming' => [
            'icon' => 'bx-calendar-event',
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-700',
            'border' => 'border-blue-200',
            'iconColor' => 'text-blue-500'
        ],
        'ongoing' => [
            'icon' => 'bx-play-circle',
            'bg' => 'bg-green-50',
            'text' => 'text-green-700',
            'border' => 'border-green-200',
            'iconColor' => 'text-green-500'
        ],
        'done' => [
            'icon' => 'bx-check-circle',
            'bg' => 'bg-gray-50',
            'text' => 'text-gray-700',
            'border' => 'border-gray-200',
            'iconColor' => 'text-gray-500'
        ]
    ];

    $config = $statusConfig[$program->progress_status] ?? $statusConfig['done'];
@endphp

<div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border {{ $config['bg'] }} {{ $config['border'] }} {{ $config['text'] }}">
    <i class='bx {{ $config['icon'] }} text-lg {{ $config['iconColor'] }}'></i>
    <span class="font-medium text-sm">{{ $status['label'] }}</span>
</div>
