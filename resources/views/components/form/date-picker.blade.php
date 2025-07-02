@props([
    'id',
    'name',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'class' => '',
    'placeholder' => '',
])

{{--
Usage: <x-form.date-picker id="start_date" name="start_date" value="{{ old('start_date') }}" required />
       <x-form.date-picker id="end_date" name="end_date" class="mt-2" />

Used in:
- resources/views/programs_volunteers/partials/programDetails.blade.php
- resources/views/programs/create.blade.php
--}}

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
            class="input input-bordered w-full pr-10 cursor-pointer {{ $class }} border-[#1a2235] focus:!border-[#ffb51b] focus:!ring-2 focus:!ring-[#ffb51b]/20"
        />
    </div>
</div> 