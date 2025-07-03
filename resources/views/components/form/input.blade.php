@props([
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'class' => '',
    'label' => null,
    'pattern' => null,
])

{{--
Usage: <x-form.input name="email" type="email" label="Email Address" required />
       <x-form.input name="phone" type="tel" placeholder="Enter phone number" />
       <x-form.input name="name" type="name" label="Full Name" pattern="[A-Za-z\s]+" />

Used in:
- resources/views/auth/login.blade.php
- resources/views/auth/register.blade.php
- resources/views/volunteers/form.blade.php
- resources/views/programs/create.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
--}}

@php
    $inputId = $id ?? $name;
    $inputType = $type === 'name' ? 'text' : $type;
    $inputPattern = $pattern;
    if ($type === 'name' && !$pattern) {
        $inputPattern = '[A-Za-z\s]+';
    }
    // pattern="^(https?://)?([a-zA-Z0-9]([a-zA-Z0-9\-].*[a-zA-Z0-9])?\.)+[a-zA-Z].*$"
@endphp

@if($label)
    <label for="{{ $inputId }}" class="block text-sm font-semibold text-[#1a2235] mb-2">{{ $label }}</label>
@endif
<input
    name="{{ $name }}"
    id="{{ $inputId }}"
    type="{{ $inputType }}"
    value="{{ old($name, $value) }}"
    placeholder="{{ $placeholder }}"
    @if($required) required @endif
    @if($inputPattern) pattern="{{ $inputPattern }}" @endif
    {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] focus:ring-offset-0 transition-colors ' . $class]) }}
/>
@error($name)
    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
@enderror 