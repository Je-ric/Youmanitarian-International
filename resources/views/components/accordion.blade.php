@props([
    // items: array of ['id'=>string, 'title'=>HTML, 'content'=>HTML, 'open'=>bool]
    'items' => [],
    'flush' => false, // optional: if true, removes bg/shadow for a minimal look
])

@php
    $base = $flush
        ? 'collapse collapse-arrow border-b border-gray-200'
        : 'collapse collapse-arrow bg-white border border-gray-200 shadow-sm';
@endphp

<div class="space-y-2">
    @foreach($items as $i)
        @php
            $open    = $i['open']   ?? false;
            $title   = $i['title']  ?? 'Item';
            $content = $i['content'] ?? '';
            $id      = $i['id']     ?? 'acc-'.uniqid();
        @endphp

        <div class="{{ $base }} rounded-xl overflow-hidden">
            <input type="checkbox" id="{{ $id }}" @if($open) checked @endif>
            <div class="collapse-title flex items-center gap-3 font-medium text-sm text-[#1a2235]">
                {!! $title !!}
            </div>
            <div class="collapse-content text-sm text-gray-600 leading-relaxed">
                {!! $content !!}
            </div>
        </div>
    @endforeach
</div>


{{-- Usage:

<x-accordion :items="[
    ['id'=>'first','title'=>'First Item','content'=>'<p>Hello</p>','open'=>true],
    ['id'=>'second','title'=>'Second Item','content'=>'<p>World</p>'],
]" />


--}}
