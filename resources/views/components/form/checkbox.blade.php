@props([
    'checked' => false
])

{{--
Usage: <x-form.checkbox name="terms" checked="{{ old('terms') }}" required />
       <x-form.checkbox name="newsletter" checked="true" />

Used in:
- resources/views/roles/partials/assign_rolesModal.blade.php
- resources/views/auth/register.blade.php
--}}

<input 
    type="checkbox"
    {{ $attributes->merge([
        'class' => 'w-4 h-4 text-[#ffb51b] bg-white border-[#1a2235] rounded focus:ring-[#ffb51b] focus:ring-2 transition-colors'
    ]) }}
    @if($checked) checked="checked" @endif
>
