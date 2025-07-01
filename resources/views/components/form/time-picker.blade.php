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
            class="input input-bordered w-full pr-10 cursor-pointer {{ $class }} border-[#1a2235] focus:!border-[#ffb51b] focus:!ring-2 focus:!ring-[#ffb51b]/20"
        />
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <i class="bx bx-chevron-down text-xl text-gray-300"></i>
        </span>
    </div>
</div>

{{--
Used in:
- resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php
- resources/views/programs_volunteers/partials/programDetails.blade.php
- resources/views/programs/create.blade.php
--}} 