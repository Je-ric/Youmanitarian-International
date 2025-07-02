@props([
    'class' => ''
])

{{--
Usage: <x-form.button-group class="optional-class">
            <button>Button 1</button>
            <button>Button 2</button>
        </x-form.button-group>

Used in:
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
--}}

<div {{ $attributes->merge(['class' => 'flex flex-wrap gap-2 ' . $class]) }}>
    {{ $slot }}
</div> 