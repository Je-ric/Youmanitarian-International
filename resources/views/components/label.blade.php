@props([
    'for' => null,
    'class' => '',
])

<label
    @if($for) for="{{ $for }}" @endif
    class="flex items-center text-sm font-medium sm:gap-2 text-gray-700 mb-2 {{ $class }}"
>
    {{ $slot }} {{-- for icon --}}
</label>

{{--
Usage: <x-label for="email">Email Address</x-label>
       <x-label for="name" class="text-lg">
           <i class="bx bx-user"></i> Full Name
       </x-label>
       <x-label><i class="bx bx-time mr-1 text-yellow-500"></i>Time Information</x-label>

Used in:
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/profile/update-profile-information-form.blade.php
- resources/views/profile/update-password-form.blade.php
- resources/views/profile/two-factor-authentication-form.blade.php
- resources/views/auth/reset-password.blade.php
- resources/views/auth/two-factor-challenge.blade.php
- resources/views/auth/register.blade.php
- resources/views/auth/forgot-password.blade.php
- resources/views/auth/login.blade.php
- resources/views/auth/confirm-password.blade.php
- resources/views/api/api-token-manager.blade.php
--}} 