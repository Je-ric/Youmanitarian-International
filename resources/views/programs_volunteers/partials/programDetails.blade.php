<div class="container mx-auto p-6">
    <form action="{{ route('programs.update', $program) }}" method="POST" class="mx-auto min-h-screen flex flex-col justify-center" id="programForm">
        @csrf
        @method('PUT')

        <x-header-with-button title="Program Details" description="View or update the program information.">
            <div class="flex gap-3">
                <x-button variant="ghost" type="button" id="editBtn">
                    Edit
                </x-button>
                <x-button variant="primary" type="submit" id="saveBtn" class="hidden">
                    Update Program
                </x-button>
            </div>
        </x-header-with-button>

        <!-- Program Title -->
        <div class="mb-8">
            <label for="title" class="block text-lg font-semibold text-[#1a2235] mb-2">Program Title</label>
            <input
                type="text"
                id="title"
                name="title"
                class="w-full p-4 border border-transparent bg-gray-100 rounded-xl text-[#1a2235] placeholder-gray-400 transition"
                value="{{ old('title', $program->title) }}"
                readonly
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
                    class="w-full p-4 border border-transparent bg-gray-100 rounded-xl text-[#1a2235] transition"
                    value="{{ old('date', \Carbon\Carbon::parse($program->date)->format('Y-m-d')) }}"
                    readonly
                    required
                >
            </div>

            <div>
                <label for="start_time" class="block text-lg font-semibold text-[#1a2235] mb-2">Start Time</label>
                <input
                    type="time"
                    id="start_time"
                    name="start_time"
                    class="w-full p-4 border border-transparent bg-gray-100 rounded-xl text-[#1a2235] transition"
                    value="{{ old('start_time', \Carbon\Carbon::parse($program->start_time)->format('H:i')) }}"
                    readonly
                    required
                >
            </div>

            <div>
                <label for="end_time" class="block text-lg font-semibold text-[#1a2235] mb-2">End Time</label>
                <input
                    type="time"
                    id="end_time"
                    name="end_time"
                    class="w-full p-4 border border-transparent bg-gray-100 rounded-xl text-[#1a2235] transition"
                    value="{{ old('end_time', \Carbon\Carbon::parse($program->end_time)->format('H:i')) }}"
                    readonly
                    required
                >
            </div>
        </div>

        <!-- Location and Volunteers Needed -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
            <div>
                <label for="location" class="block text-lg font-semibold text-[#1a2235] mb-2">Location (Optional)</label>
                <input
                    type="text"
                    id="location"
                    name="location"
                    class="w-full p-4 border border-transparent bg-gray-100 rounded-xl text-[#1a2235] transition"
                    value="{{ old('location', $program->location) }}"
                    readonly
                >
            </div>

            <div>
                <label for="volunteer_count" class="block text-lg font-semibold text-[#1a2235] mb-2">Volunteers Needed</label>
                <input
                    type="number"
                    id="volunteer_count"
                    name="volunteer_count"
                    min="0"
                    class="w-full p-4 border border-transparent bg-gray-100 rounded-xl text-[#1a2235] transition"
                    value="{{ old('volunteer_count', $program->volunteer_count) }}"
                    readonly
                >
            </div>
        </div>

        <!-- Description -->
        <div class="mb-10">
            <label for="description" class="block text-lg font-semibold text-[#1a2235] mb-2">Description</label>
            <textarea
                id="description"
                name="description"
                rows="6"
                class="w-full p-4 border border-transparent bg-gray-100 rounded-xl text-[#1a2235] resize-y transition"
                readonly
                required
            >{{ old('description', $program->description) }}</textarea>
        </div>

        <div class="flex flex-wrap gap-4 justify-start">
            <x-button variant="close" href="{{ route('programs.index') }}">
                Cancel
            </x-button>
        </div>
    </form>
</div>

<script>
    document.getElementById('editBtn').addEventListener('click', () => {
        document.querySelectorAll('#programForm input, #programForm textarea').forEach(input => {
            input.removeAttribute('readonly');
            input.classList.remove('bg-gray-100');
            input.classList.add('border-gray-300', 'focus:ring-4', 'focus:ring-[#ffb51b]/40');
        });

        document.getElementById('saveBtn').classList.remove('hidden');
        document.getElementById('editBtn').classList.add('hidden');
    });
</script>
