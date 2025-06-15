@props(['program'])

@php
    $status = $program->progress_status_with_style;
@endphp

<span class="inline-flex px-3 py-1 text-xs md:text-sm rounded font-semibold leading-tight {{ $status['style'] }}">
    {{ $status['label'] }}
</span>
