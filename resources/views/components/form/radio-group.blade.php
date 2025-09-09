@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => null,
    'inline' => false,
])

{{--
Usage: <x-form.radio-group name="gender" label="Gender"
            :options="['male' => 'Male', 'female' => 'Female']"
            :selected="old('gender')" />
        <x-form.radio-group name="status"
            :options="['active' => 'Active', 'inactive' => 'Inactive']" />

        <x-form.radio-group
                name="status"
                :options="['active' => 'Active', 'inactive' => 'Inactive']"
                :selected="old('status', 'active')"
                inline="true"
            />
Used in:
- resources/views/volunteers/form.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
--}}

<div>
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    @endif
    <div class="flex {{ $inline ? 'flex-row gap-4' : 'flex-col gap-2' }}">
        @foreach($options as $value => $optionLabel)
            @php
                $id = $name . '_' . \Illuminate\Support\Str::slug($value, '_');
            @endphp
            <div class="flex items-center">
                <input
                    id="{{ $id }}"
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    @checked($selected == $value)
                    class="w-4 h-4 text-[#ffb51b] bg-white border-2 border-gray-300 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] checked:bg-[#ffb51b] transition-colors"
                >
                <label for="{{ $id }}" class="ms-2 text-sm font-medium text-gray-900">{{ $optionLabel }}</label>
            </div>
        @endforeach
    </div>
</div>
