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
        'class' => 'w-4 h-4 text-[#ffb51b] bg-white border-2 border-gray-300 rounded focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] checked:bg-[#ffb51b] transition-colors'
    ]) }}
    @if($checked) checked="checked" @endif
>
