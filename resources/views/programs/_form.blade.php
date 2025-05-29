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
            <label class="block text-sm font-medium text-[#1a2235] mb-1">Volunteer Count</label>
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

<form action="{{ $route }}" method="POST" class="mx-auto bg-white min-h-screen flex flex-col justify-center">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <x-header-with-button title="Any Title" description="Description that match with the shown content.">
            <x-button variant="primary" type="submit">
                {{ $method === 'PUT' ? 'Update Program' : 'Create Program' }}
            </x-button>
    </x-header-with-button>
    
    <!-- Program Title -->
    <div class="mb-8">
        <label for="title" class="block text-lg font-semibold text-[#1a2235] mb-2">Program Title</label>
        <input
            type="text"
            id="title"
            name="title"
            placeholder="Enter program title"
            class="w-full p-4 border border-gray-300 rounded-xl text-[#1a2235] placeholder-gray-400 focus:border-[#ffb51b] focus:ring-4 focus:ring-[#ffb51b]/40 transition"
            value="{{ old('title', $program->title ?? '') }}"
            required
        >
    </div>

    <!-- Date, Start Time, End Time -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div>
            <label for="date" class="block text-lg font-semibold text-[#1a2235] mb-2">Date</label>
            <input
                type="date"
                id="date"
                name="date"
                placeholder="Select date"
                class="w-full p-4 border border-gray-300 rounded-xl text-[#1a2235] placeholder-gray-400 focus:border-[#ffb51b] focus:ring-4 focus:ring-[#ffb51b]/40 transition"
                value="{{ old('date', isset($program) ? \Carbon\Carbon::parse($program->date)->format('Y-m-d') : '') }}"
                required
            >
        </div>

        <div>
            <label for="start_time" class="block text-lg font-semibold text-[#1a2235] mb-2">Start Time</label>
            <input
                type="time"
                id="start_time"
                name="start_time"
                placeholder="Start time"
                class="w-full p-4 border border-gray-300 rounded-xl text-[#1a2235] placeholder-gray-400 focus:border-[#ffb51b] focus:ring-4 focus:ring-[#ffb51b]/40 transition"
                value="{{ old('start_time', isset($program) ? \Carbon\Carbon::parse($program->start_time)->format('H:i') : '') }}"
                required
            >
        </div>

        <div>
            <label for="end_time" class="block text-lg font-semibold text-[#1a2235] mb-2">End Time</label>
            <input
                type="time"
                id="end_time"
                name="end_time"
                placeholder="End time"
                class="w-full p-4 border border-gray-300 rounded-xl text-[#1a2235] placeholder-gray-400 focus:border-[#ffb51b] focus:ring-4 focus:ring-[#ffb51b]/40 transition"
                value="{{ old('end_time', isset($program) ? \Carbon\Carbon::parse($program->end_time)->format('H:i') : '') }}"
                required
            >
        </div>
    </div>

    <!-- Location & Volunteer Count -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div>
            <label for="location" class="block text-lg font-semibold text-[#1a2235] mb-2">Location (Optional)</label>
            <input
                type="text"
                id="location"
                name="location"
                placeholder="Enter location"
                class="w-full p-4 border border-gray-300 rounded-xl text-[#1a2235] placeholder-gray-400 focus:border-[#ffb51b] focus:ring-4 focus:ring-[#ffb51b]/40 transition"
                value="{{ old('location', $program->location ?? '') }}"
            >
        </div>

        <div>
            <label for="volunteer_count" class="block text-lg font-semibold text-[#1a2235] mb-2">Volunteers Needed</label>
            <input
                type="number"
                id="volunteer_count"
                name="volunteer_count"
                placeholder="Number of volunteers"
                min="0"
                class="w-full p-4 border border-gray-300 rounded-xl text-[#1a2235] placeholder-gray-400 focus:border-[#ffb51b] focus:ring-4 focus:ring-[#ffb51b]/40 transition"
                value="{{ old('volunteer_count', $program->volunteer_count ?? '') }}"
            >
        </div>
    </div>

    <!-- Description -->
    <div class="mb-10">
        <label for="description" class="block text-lg font-semibold text-[#1a2235] mb-2">Description</label>
        <textarea
            id="description"
            name="description"
            placeholder="Write a detailed description of the program"
            rows="6"
            class="w-full p-4 border border-gray-300 rounded-xl text-[#1a2235] placeholder-gray-400 resize-y focus:border-[#ffb51b] focus:ring-4 focus:ring-[#ffb51b]/40 transition"
            required
        >{{ old('description', $program->description ?? '') }}</textarea>
    </div>

    <!-- Buttons -->
    <div class="flex flex-wrap gap-4 justify-start">
        <button
            type="submit"
            class="px-8 py-3 bg-[#ffb51b] text-[#1a2235] font-semibold rounded-xl hover:bg-[#e6a017] transition"
        >
            {{ $method === 'PUT' ? 'Update Program' : 'Create Program' }}
        </button>

        @if($method === 'PUT')
        <a
            href="{{ route('programs.index') }}"
            class="px-8 py-3 bg-gray-500 text-white font-semibold rounded-xl hover:bg-gray-600 transition"
        >
            Cancel
        </a>
        @endif
    </div>
</form>
