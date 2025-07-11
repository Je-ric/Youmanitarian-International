@props([
    'id' => null,
    'name' => null,
    'value' => '',
    'label' => null,
    'placeholder' => '',
    'rows' => 3,
    'disabled' => false,
    'required' => false,
    'class' => '',
])

{{--
Usage: <x-form.textarea name="description" label="Description" placeholder="Enter description" rows="5" />
       <x-form.textarea name="notes" value="{{ old('notes') }}" required />
       <x-form.textarea name="comment" disabled class="bg-gray-50" />

Used in:
- resources/views/volunteers/modals/invitationModal.blade.php
- resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
--}}

@if($label)
    <label for="{{ $id ?? $name }}" class="block text-sm font-semibold text-gray-700 mb-2">
        {{ $label }}
    </label>
@endif
<textarea
    id="{{ $id ?? $name }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    @if($disabled) disabled @endif
    @if($required) required @endif
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => (
        'w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors '.
        ($disabled ? 'bg-gray-50 text-gray-500 cursor-not-allowed ' : '').
        $class
    )]) }}
>{{ old($name, $value) }}</textarea>

@error($name)
    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
@enderror 