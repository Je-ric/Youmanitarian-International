@props([
    'id',
    'name',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'class' => '',
    'placeholder' => '',
    'min' => null,
    'max' => null,
])

{{--
Usage: <x-form.time-picker id="start_time" name="start_time" value="{{ old('start_time') }}" required />
       <x-form.time-picker id="end_time" name="end_time" class="mt-2" />

Used in:
- resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php
- resources/views/programs_volunteers/partials/programDetails.blade.php
- resources/views/programs/create.blade.php
--}}

<div class="form-control w-full">
    <div class="relative">
        <input
            type="time"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            @if($required) required @endif
            @if($readonly) readonly @endif
            @if($min) min="{{ $min }}" @endif
            @if($max) max="{{ $max }}" @endif
            placeholder="{{ $placeholder }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors {{ $class }}"
        />
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="bx bx-chevron-down text-xl text-gray-300"></i>
        </span>
    </div>
</div>
