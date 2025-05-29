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
</form>  --}}





@props(['program' => null, 'route', 'method'])

<form action="{{ $route }}" method="POST" class="mx-auto">
    @csrf
    @method($method)

    <x-header-with-button title="Add New Program" description="Create a new program by filling out the information below.">
        <x-button
            variant="primary"
            type="submit">
            {{ $method == 'POST' ? 'Create Program' : 'Update Program' }}
        </x-button>
    </x-header-with-button>

    <!-- Program Name -->
    <div class="mb-6">
        <label for="program" class="block text-gray-700 font-semibold mb-2">Program</label>
        <input
            type="text"
            name="title"
            id="title"
            placeholder="Enter program name"
            value="{{ old('title', $program->title ?? '') }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
            required
        >
    </div>

    <!-- Date, Start Time, End Time Row -->
    <div class="flex flex-col md:flex-row md:space-x-6 mb-6">
        <div class="flex-1 mb-4 md:mb-0">
            <label for="date" class="block text-gray-700 font-semibold mb-2">Date</label>
            <input
                type="date"
                name="date"
                id="date"
                placeholder="Select date"
                value="{{ old('date', isset($program->date) ? $program->date->format('Y-m-d') : '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                required
            >
        </div>
        <div class="flex-1 mb-4 md:mb-0">
            <label for="start_time" class="block text-gray-700 font-semibold mb-2">Start Time</label>
            <input
                type="time"
                name="start_time"
                id="start_time"
                placeholder="Start time"
                value="{{ old('start_time', $program->start_time ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                required
            >
        </div>
        <div class="flex-1">
            <label for="end_time" class="block text-gray-700 font-semibold mb-2">End Time</label>
            <input
                type="time"
                name="end_time"
                id="end_time"
                placeholder="End time"
                value="{{ old('end_time', $program->end_time ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                required
            >
        </div>
    </div>

    <!-- Location, Volunteers Needed Row -->
    <div class="flex flex-col md:flex-row md:space-x-6 mb-6">
        <div class="flex-1 mb-4 md:mb-0">
            <label for="location" class="block text-gray-700 font-semibold mb-2">Location</label>
            <input
                type="text"
                name="location"
                id="location"
                placeholder="Enter location"
                value="{{ old('location', $program->location ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                required
            >
        </div>
        <div class="flex-1">
    <label for="volunteer_count" class="block text-gray-700 font-semibold mb-2">
        Volunteers Count
    </label>
    <input
        type="number"
        name="volunteer_count"
        id="volunteer_count"
        placeholder="Number of volunteers"
        min="1"
        value="{{ old('volunteer_count', $program->volunteer_count ?? '') }}"
        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
        required
    >
</div>

    </div>

    <!-- Description -->
    <div class="mb-6">
        <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
        <textarea
            name="description"
            id="description"
            rows="5"
            placeholder="Enter program description"
            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition resize-none"
            required
        >{{ old('description', $program->description ?? '') }}</textarea>
    </div>

    <!-- Submit Button -->
    <div class="text-right">
        <button
            type="submit"
            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-md shadow-md transition"
        >
            {{ $method == 'POST' ? 'Create Program' : 'Update Program' }}
        </button>
    </div>
</form>
