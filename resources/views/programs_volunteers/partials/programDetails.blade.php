{{-- <div class="container mx-auto p-6">
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
</script> --}}

<div class="container w-full bg-white border border-gray-200 rounded-xl p-6 lg:p-8 mb-8 px-4 sm:px-6 py-6">
    <form action="{{ route('programs.update', $program) }}" method="POST" id="programForm">
        @csrf
        @method('PUT')

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                {{-- <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-[#1a2235] mb-2">
                        Program Details
                    </h1>
                    <p class="text-gray-600">View and manage program information</p>
                </div> --}}
                <div class="flex gap-3 w-full lg:w-auto">
                    <button type="button" id="editBtn" 
                        class="flex-1 lg:flex-none inline-flex items-center justify-center px-6 py-3 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-all duration-200 font-medium">
                        <i class='bx bx-edit mr-2'></i> Edit Program
                    </button>
                    <button type="submit" id="saveBtn" 
                        class="hidden flex-1 lg:flex-none inline-flex items-center justify-center px-6 py-3 bg-[#1a2235] text-white rounded-lg hover:bg-[#2a3245] transition-all duration-200 font-medium">
                        <i class='bx bx-save mr-2'></i> Save Changes
                    </button>
                    <button type="button" id="cancelBtn" 
                        class="hidden flex-1 lg:flex-none inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200">
                        <i class='bx bx-x mr-2'></i> Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Program Overview Card -->
        <div>
            <!-- Program Title Section -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-[#1a2235] rounded-lg flex items-center justify-center">
                        <i class='bx bx-calendar-event text-white text-xl'></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-[#1a2235]">Program Title</h2>
                        <p class="text-sm text-gray-600">The main identifier for this program</p>
                    </div>
                </div>
                
                <!-- View Mode -->
                <div id="title-view" class="view-mode">
                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-[#ffb51b]">
                        <h3 class="text-xl font-bold text-[#1a2235]">{{ $program->title }}</h3>
                    </div>
                </div>
                
                <!-- Edit Mode -->
                <div id="title-edit" class="edit-mode hidden">
                    <input type="text" id="title" name="title" 
                        class="w-full p-4 border-2 border-gray-300 rounded-lg text-[#1a2235] focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-all duration-200"
                        value="{{ old('title', $program->title) }}" required>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-time text-blue-600 text-xl'></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-[#1a2235]">Schedule</h2>
                        <p class="text-sm text-gray-600">Date and time information</p>
                    </div>
                </div>

                <!-- View Mode -->
                <div id="schedule-view" class="view-mode">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i class='bx bx-calendar text-[#ffb51b]'></i>
                                <span class="text-sm font-medium text-gray-600">Date</span>
                            </div>
                            <p class="font-semibold text-[#1a2235]">
                                {{ \Carbon\Carbon::parse($program->date)->format('F j, Y') }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i class='bx bx-time text-green-500'></i>
                                <span class="text-sm font-medium text-gray-600">Start Time</span>
                            </div>
                            <p class="font-semibold text-[#1a2235]">
                                {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i class='bx bx-time text-red-500'></i>
                                <span class="text-sm font-medium text-gray-600">End Time</span>
                            </div>
                            <p class="font-semibold text-[#1a2235]">
                                {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="schedule-edit" class="edit-mode hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input type="date" id="date" name="date" 
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-all duration-200"
                                value="{{ old('date', \Carbon\Carbon::parse($program->date)->format('Y-m-d')) }}" required>
                        </div>
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                            <input type="time" id="start_time" name="start_time" 
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-all duration-200"
                                value="{{ old('start_time', \Carbon\Carbon::parse($program->start_time)->format('H:i')) }}" required>
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                            <input type="time" id="end_time" name="end_time" 
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-all duration-200"
                                value="{{ old('end_time', \Carbon\Carbon::parse($program->end_time)->format('H:i')) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location & Capacity -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-map text-purple-600 text-xl'></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-[#1a2235]">Location & Capacity</h2>
                        <p class="text-sm text-gray-600">Where and how many volunteers needed</p>
                    </div>
                </div>

                <!-- View Mode -->
                <div id="location-view" class="view-mode">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i class='bx bx-map-pin text-[#ffb51b]'></i>
                                <span class="text-sm font-medium text-gray-600">Location</span>
                            </div>
                            <p class="font-semibold text-[#1a2235]">
                                {{ $program->location ?: 'Not specified' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i class='bx bx-group text-blue-500'></i>
                                <span class="text-sm font-medium text-gray-600">Volunteers Needed</span>
                            </div>
                            <p class="font-semibold text-[#1a2235]">
                                {{ $program->volunteer_count ?: 'No limit' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="location-edit" class="edit-mode hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" id="location" name="location" 
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-all duration-200"
                                value="{{ old('location', $program->location) }}" placeholder="Enter location">
                        </div>
                        <div>
                            <label for="volunteer_count" class="block text-sm font-medium text-gray-700 mb-2">Volunteers Needed</label>
                            <input type="number" id="volunteer_count" name="volunteer_count" min="0"
                                class="w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-all duration-200"
                                value="{{ old('volunteer_count', $program->volunteer_count) }}" placeholder="Number of volunteers">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-file-blank text-green-600 text-xl'></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-[#1a2235]">Description</h2>
                        <p class="text-sm text-gray-600">Detailed information about the program</p>
                    </div>
                </div>

                <!-- View Mode -->
                <div id="description-view" class="view-mode">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $program->description }}</p>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="description-edit" class="edit-mode hidden">
                    <textarea id="description" name="description" rows="6"
                        class="w-full p-4 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-all duration-200 resize-y"
                        placeholder="Enter program description..." required>{{ old('description', $program->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-between">
            <a href="{{ route('programs.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200">
                <i class='bx bx-arrow-back mr-2'></i> Back to Programs
            </a>
            
            <div id="edit-actions" class="flex flex-col sm:flex-row gap-3">
                <button type="button" id="discardBtn"
                    class="inline-flex items-center justify-center px-6 py-3 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-all duration-200">
                    <i class='bx bx-trash mr-2'></i> Discard Changes
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const discardBtn = document.getElementById('discardBtn');
    const editActions = document.getElementById('edit-actions');
    
    const viewModes = document.querySelectorAll('.view-mode');
    const editModes = document.querySelectorAll('.edit-mode');
    
    // Store original values
    const originalValues = {};
    document.querySelectorAll('#programForm input, #programForm textarea').forEach(input => {
        originalValues[input.name] = input.value;
    });

    function enterEditMode() {
        // Hide view modes, show edit modes
        viewModes.forEach(el => el.classList.add('hidden'));
        editModes.forEach(el => el.classList.remove('hidden'));
        
        // Toggle buttons
        editBtn.classList.add('hidden');
        saveBtn.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
        editActions.classList.remove('hidden');
        
        // Add animation class
        document.querySelector('.bg-white').classList.add('ring-2', 'ring-[#ffb51b]', 'ring-opacity-50');
        
        // Focus first input
        document.getElementById('title').focus();
    }

    function exitEditMode() {
        // Show view modes, hide edit modes
        viewModes.forEach(el => el.classList.remove('hidden'));
        editModes.forEach(el => el.classList.add('hidden'));
        
        // Toggle buttons
        editBtn.classList.remove('hidden');
        saveBtn.classList.add('hidden');
        cancelBtn.classList.add('hidden');
        editActions.classList.add('hidden');
        
        // Remove animation class
        document.querySelector('.bg-white').classList.remove('ring-2', 'ring-[#ffb51b]', 'ring-opacity-50');
    }

    function restoreOriginalValues() {
        Object.keys(originalValues).forEach(name => {
            const input = document.querySelector(`[name="${name}"]`);
            if (input) {
                input.value = originalValues[name];
            }
        });
    }

    // Event listeners
    editBtn.addEventListener('click', enterEditMode);
    
    cancelBtn.addEventListener('click', function() {
        restoreOriginalValues();
        exitEditMode();
    });
    
    discardBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to discard all changes?')) {
            restoreOriginalValues();
            exitEditMode();
        }
    });

    // Add smooth transitions
    document.querySelectorAll('.view-mode, .edit-mode').forEach(el => {
        el.style.transition = 'all 0.3s ease-in-out';
    });
});
</script>

<style>
.view-mode {
    animation: fadeIn 0.3s ease-in-out;
}

.edit-mode {
    animation: slideIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.ring-2 {
    transition: all 0.3s ease-in-out;
}
</style>

