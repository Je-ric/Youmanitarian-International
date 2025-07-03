@props([
    'name',
    'label' => '',
    'options' => [],
    'class' => '',
    'onchange' => null,
    'required' => false,
])

{{--
Usage: <x-form.select-option name="role" label="Select Role" 
           :options="[['value' => 'admin', 'label' => 'Administrator'], ['value' => 'user', 'label' => 'User']]" 
           required />
       <x-form.select-option name="program" onchange="handleProgramChange()">
           <option value="">Select Program</option>
           <option value="1">Program 1</option>
       </x-form.select-option>

Used in:
- resources/views/volunteers/modals/invitationModal.blade.php
- resources/views/programs_volunteers/partials/programTasks.blade.php
--}}

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-800 mb-2">{{ $label }}</label>
    @endif
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if($required) required @endif
        @if($onchange) onchange="{{ $onchange }}" @endif
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors ' . $class]) }}
    >
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @else
            @foreach($options as $option)
                <option value="{{ $option['value'] }}" @if(!empty($option['selected'])) selected @endif>
                    {{ $option['label'] }}
                </option>
            @endforeach
        @endif
    </select> 
</div> 