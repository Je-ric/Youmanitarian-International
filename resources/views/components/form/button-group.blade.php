@props([
    'class' => ''
])

<div {{ $attributes->merge(['class' => 'flex flex-wrap gap-2 ' . $class]) }}>
    {{ $slot }}
</div> 