@props([
    'name' => 'file',
    'id' => 'file',
    'accept' => 'image/*,.pdf',
    'class' => '',
])
<div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-gray-400 transition-colors {{ $class }}">
    <div class="text-center">
        <i class='bx bx-cloud-upload text-3xl text-gray-400 mb-2'></i>
        <div class="mb-2">
            <label for="{{ $id }}" class="cursor-pointer">
                <span class="text-sm font-medium text-blue-600 hover:text-blue-800">Upload a file</span>
                <span class="text-sm text-gray-500"> or drag and drop</span>
            </label>
            <input
                type="file"
                name="{{ $name }}"
                id="{{ $id }}"
                accept="{{ $accept }}"
                {{ $attributes->get('required') ? 'required' : '' }}
                {{ $attributes->get('multiple') ? 'multiple' : '' }}
                class="hidden"
            >
        </div>
        <p class="text-xs text-gray-500">
            {{ $slot->isEmpty() ? 'PNG, JPG, PDF up to 10MB' : $slot }}
        </p>
    </div>
</div>

{{--
Used in:
- resources/views/programs/modals/proofModal.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
--}} 