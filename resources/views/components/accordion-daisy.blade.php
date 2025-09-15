@props([
    'title' => 'Accordion Title',
    'active' => false,
])

<div tabindex="0"
     class="collapse collapse-plus border border-base-300 bg-base-100 rounded-box">
    <div class="collapse-title text-lg font-semibold">
        {{ $title }}
    </div>
    <div class="collapse-content text-gray-700 leading-relaxed">
        {{ $slot }}
    </div>
</div>
