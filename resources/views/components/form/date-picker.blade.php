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
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors {{ $class }}"
        />
    </div>
</div> 