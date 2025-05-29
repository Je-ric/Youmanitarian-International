{{-- @props(['program' => null, 'route', 'method'])

<form action="{{ $route }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Title -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-[#1a2235] mb-1">Title</label>
        <input type="text" name="title"
            class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors"
            value="{{ old('title', $program->title ?? '') }}" required>
    </div>

    <!-- Description -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-[#1a2235] mb-1">Description</label>
        <textarea name="description"
            class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors"
            rows="4" required>{{ old('description', $program->description ?? '') }}</textarea>
    </div>

    <!-- Dates and Times -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Date</label>
            <input type="date" name="date"
                class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors"
                value="{{ old('date', isset($program) ? \Carbon\Carbon::parse($program->date)->format('Y-m-d') : '') }}"
                required>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Start Time</label>
            <input type="time" name="start_time"
                class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors"
                value="{{ old('start_time', isset($program) ? \Carbon\Carbon::parse($program->start_time)->format('H:i') : '') }}"
                required>
        </div>
        <div>
            <label class="block text-sm font-medium text-[#1a2235] mb-1">End Time</label>
            <input type="time" name="end_time"
                class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors"
                value="{{ old('end_time', isset($program) ? \Carbon\Carbon::parse($program->end_time)->format('H:i') : '') }}"
                required>
        </div>
    </div>

    <!-- Location & Volunteer Count -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Location (Optional)</label>
            <input type="text" name="location"
                class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors"
                value="{{ old('location', $program->location ?? '') }}">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Volunteer Needed</label>
            <input type="number" name="volunteer_count"
                class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] transition-colors"
                value="{{ old('volunteer_count', $program->volunteer_count ?? '') }}">
        </div>
    </div>

    <div class="flex items-center gap-4">
        <button type="submit"
            class="px-6 py-3 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a017] transition-colors">
            {{ $method === 'PUT' ? 'Update Program' : 'Create Program' }}
        </button>
        @if($method === 'PUT')
        <a href="{{ route('programs.index') }}"
            class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
            Cancel
        </a>
        @endif
    </div>
</form> --}}

@props(['program' => null, 'route', 'method'])

<form action="{{ $route }}" method="POST">
    @csrf
    @method($method)

    <!-- Program Title -->
    <div class="mb-4">
        <label for="title" class="block font-semibold">Program Title</label>
        <input type="text" name="title" id="title"
            value="{{ old('title', $program->title ?? '') }}"
            class="w-full border rounded px-3 py-2" required>
    </div>

    <!-- Date, Start Time, End Time -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="date" class="block font-semibold">Date</label>
            <input type="date" name="date" id="date"
                value="{{ old('date', $program->date ?? '') }}"
                class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="start_time" class="block font-semibold">Start Time</label>
            <input type="time" name="start_time" id="start_time"
                value="{{ old('start_time', $program->start_time ?? '') }}"
                class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="end_time" class="block font-semibold">End Time</label>
            <input type="time" name="end_time" id="end_time"
                value="{{ old('end_time', $program->end_time ?? '') }}"
                class="w-full border rounded px-3 py-2" required>
        </div>
    </div>

    <!-- Location and Volunteers Needed -->
    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="location" class="block font-semibold">Location</label>
            <input type="text" name="location" id="location"
                value="{{ old('location', $program->location ?? '') }}"
                class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label for="volunteers_needed" class="block font-semibold">Volunteers Needed</label>
            <input type="number" name="volunteers_needed" id="volunteers_needed" min="1"
                value="{{ old('volunteers_needed', $program->volunteers_needed ?? '') }}"
                class="w-full border rounded px-3 py-2" required>
        </div>
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label for="description" class="block font-semibold">Description</label>
        <textarea name="description" id="description" rows="4"
            class="w-full border rounded px-3 py-2" required>{{ old('description', $program->description ?? '') }}</textarea>
    </div>

    <!-- Submit Button -->
    <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
            {{ $method === 'POST' ? 'Create' : 'Update' }} Program
        </button>
    </div>
</form>
