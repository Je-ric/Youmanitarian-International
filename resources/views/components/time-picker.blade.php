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
            type="time"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            placeholder="{{ $placeholder }}"
            class="input input-bordered w-full pl-12 pr-10 cursor-pointer {{ $class }}"
        />
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <i class="bx bx-time-five text-xl"></i>
        </span>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="bx bx-chevron-down text-xl text-gray-300"></i>
        </span>
    </div>
</div> 