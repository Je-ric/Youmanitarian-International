@props([
    'id',
    'name',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'class' => '',
    'placeholder' => '',
])

<div class="form-control w-full">
    <div class="relative">
        <input
            type="date"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            placeholder="{{ $placeholder }}"
            class="input input-bordered w-full pr-10 cursor-pointer {{ $class }} focus:!border-[#ffb51b] focus:!ring-2 focus:!ring-[#ffb51b]/20"
        />
    </div>
</div> 