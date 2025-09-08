@extends('layouts.sidebar_final')

@section('content')
    <div class="py-10 px-6">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">
            Consultation Hours
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Left --}}
            <div class="bg-white shadow-md rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Your Schedule</h2>

                @forelse ($consultationHours as $hour)
                    <div class="border-b border-gray-200 py-3 flex items-center justify-between">
                        <div>
                            <p class="text-gray-800 font-medium">
                                {{ $hour->specialization }}
                                <span class="text-sm text-gray-500">({{ ucfirst($hour->status) }})</span>
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $hour->day }} — {{ $hour->start_time }} to {{ $hour->end_time }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('consultation-hours.index', ['edit' => $hour->id]) }}"
                                class="text-yellow-500 hover:text-yellow-700">
                                <i class="bx bx-pencil"></i>
                            </a>

                            <form action="{{ route('consultation-hours.destroy', $hour->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this consultation hour?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No consultation hours available.</p>
                @endforelse
            </div>

            {{-- Right --}}
            <div class="bg-white shadow-md rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">
                    {{ isset($editingHour) ? 'Update Consultation Hour' : 'Add Consultation Hour' }}
                </h2>

                <form
                    action="{{ isset($editingHour)
                        ? route('consultation-hours.update', $editingHour->id)
                        : route('consultation-hours.store') }}"
                    method="POST" class="space-y-4">
                    @csrf
                    @if (isset($editingHour))
                        @method('PUT')
                    @endif

                    <div>
                        <x-form.label for="specialization" variant="title">Specialization</x-form.label>
                        <x-form.input name="specialization" id="specialization"
                            value="{{ old('specialization', $editingHour->specialization ?? '') }}" required />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-form.label for="day" variant="date">Day of Week</x-form.label>
                            <select id="day" name="day" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors">
                                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <option value="{{ $day }}" @selected(old('day', $editingHour->day ?? '') === $day)>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-form.label for="status" variant="status">Status</x-form.label>
                            <x-form.radio-group inline="true" name="status" :options="['active' => 'Active', 'inactive' => 'Inactive']" :selected="old('status', $editingHour->status ?? 'active')" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-form.label for="start_time" variant="start-time">Start Time</x-form.label>
                            <x-form.time-picker id="start_time" name="start_time"
                                value="{{ old('start_time', $editingHour->start_time ?? '') }}" required />
                        </div>

                        <div>
                            <x-form.label for="end_time" variant="end-time">End Time</x-form.label>
                            <x-form.time-picker id="end_time" name="end_time"
                                value="{{ old('end_time', $editingHour->end_time ?? '') }}" required />
                        </div>
                    </div>

                    <x-button type="submit" variant="primary" class="w-full">
                        {{ isset($editingHour) ? 'Update Consultation Hour' : 'Add Consultation Hour' }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
@endsection
