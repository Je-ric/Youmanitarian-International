@props([
    'id',
    'maxWidth' => 'max-w-2xl',
    'width' => 'w-11/12',
    'maxHeight' => 'max-h-[90vh]',
    'class' => '',
])

<dialog id="{{ $id }}" class="modal" {{ $attributes }}>
    <div class="modal-box {{ $width }} {{ $maxWidth }} {{ $maxHeight }} p-0 overflow-hidden rounded-xl bg-white border border-slate-200 shadow-xl flex flex-col {{ $class }}">
        {{ $slot }}
    </div>
</dialog> 