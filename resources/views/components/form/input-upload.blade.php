@props([
    'name' => 'file',
    'id' => 'file',
    'accept' => 'image/*,.pdf',
    'class' => '',
])

{{--
Usage: <x-form.input-upload name="proof_file" accept="image/*" required />
       <x-form.input-upload name="documents" accept=".pdf,.doc,.docx" multiple>
           PDF, DOC, DOCX files up to 5MB
       </x-form.input-upload>

Used in:
- resources/views/programs/modals/proofModal.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
--}}

<div x-data="{ files: [] }" class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-[#ffb51b] transition-colors {{ $class }}">
    <div class="text-center">
        <i class='bx bx-cloud-upload text-3xl text-gray-400 mb-2 group-hover:text-[#ffb51b]'></i>
        <div class="mb-2">
            <label for="{{ $id }}" class="cursor-pointer group">
                <span class="text-sm font-medium text-[#ffb51b] group-hover:text-[#1a2235]">Upload a file</span>
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
                x-on:change="files = Array.from($event.target.files).map(f => f.name)"
            >
        </div>
        <p class="text-xs text-gray-500">
            {{ $slot->isEmpty() ? 'PNG, JPG, PDF up to 10MB' : $slot }}
        </p>
    </div>
    
    <!-- Show selected files -->
    <template x-if="files.length">
        <p class="text-xs text-[#1a2235] mt-2" x-text="files.join(', ')"></p>
    </template>
</div> 