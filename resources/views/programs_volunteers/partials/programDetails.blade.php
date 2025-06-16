<div class="w-full">
    <form action="{{ route('programs.update', $program) }}" method="POST" id="programForm">
        @csrf
        @method('PUT')

        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Program Details</h1>
                    <p class="text-gray-600">View and manage program information</p>
                </div>
                
                <div class="flex gap-3 w-full lg:w-auto">
                    <button
                        type="button"
                        id="editBtn"
                        class="flex-1 lg:flex-none inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                        <i class='bx bx-edit mr-2'></i> Edit Program
                    </button>
                    <button
                        type="button"
                        id="discardBtn"
                        class="hidden flex-1 lg:flex-none items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
                    >
                        <i class='bx bx-x mr-2'></i> Discard
                    </button>
                    <button
                        type="submit"
                        id="saveBtn"
                        class="hidden flex-1 lg:flex-none items-center justify-center px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors font-medium"
                    >
                        <i class='bx bx-save mr-2'></i> Save Changes
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Left Column - Main Information -->
            <div class="xl:col-span-2 space-y-6">
                
                <!-- Basic Information -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[#1a2235] flex items-center">
                            <i class='bx bx-info-circle mr-2 text-[#ffb51b]'></i>
                            Basic Information
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Program Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Program Title</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                value="{{ old('title', $program->title) }}"
                                readonly
                                required
                            >
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] resize-none transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                readonly
                                required
                            >{{ old('description', $program->description) }}</textarea>
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                Location 
                                <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <input
                                type="text"
                                id="location"
                                name="location"
                                class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                value="{{ old('location', $program->location) }}"
                                placeholder="Enter program location"
                                readonly
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Schedule & Settings -->
            <div class="xl:col-span-1 space-y-6">
                
                <!-- Schedule -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[#1a2235] flex items-center">
                            <i class='bx bx-calendar mr-2 text-[#ffb51b]'></i>
                            Schedule
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input
                                type="date"
                                id="date"
                                name="date"
                                class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                value="{{ old('date', \Carbon\Carbon::parse($program->date)->format('Y-m-d')) }}"
                                readonly
                                required
                            >
                        </div>

                        <!-- Time Range -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start</label>
                                <input
                                    type="time"
                                    id="start_time"
                                    name="start_time"
                                    class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                    value="{{ old('start_time', \Carbon\Carbon::parse($program->start_time)->format('H:i')) }}"
                                    readonly
                                    required
                                >
                            </div>

                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End</label>
                                <input
                                    type="time"
                                    id="end_time"
                                    name="end_time"
                                    class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                    value="{{ old('end_time', \Carbon\Carbon::parse($program->end_time)->format('H:i')) }}"
                                    readonly
                                    required
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program Settings -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-[#1a2235] flex items-center">
                            <i class='bx bx-cog mr-2 text-[#ffb51b]'></i>
                            Settings
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Volunteers Needed -->
                        <div>
                            <label for="volunteer_count" class="block text-sm font-medium text-gray-700 mb-2">Volunteers Needed</label>
                            <input
                                type="number"
                                id="volunteer_count"
                                name="volunteer_count"
                                min="0"
                                class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                value="{{ old('volunteer_count', $program->volunteer_count) }}"
                                placeholder="0"
                                readonly
                            >
                        </div>
                    </div>
                </div>

                <!-- Program Status (Read-only info) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Program Status</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Status:</span>
                                <x-programProgress :program="$program" />
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created:</span>
                                <span class="text-gray-900">{{ $program->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Last Updated:</span>
                                <span class="text-gray-900">{{ $program->updated_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Volunteers:</span>
                                <span class="text-gray-900">{{ $program->volunteers->count() }} participants</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row gap-3 justify-between">
                <a href="{{ route('programs.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class='bx bx-arrow-back mr-2'></i> Back to Programs
                </a>
                
                <div class="flex gap-3">
                    <button
                        type="button"
                        id="cancelBtn"
                        class="hidden items-center justify-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const discardBtn = document.getElementById('discardBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const fields = document.querySelectorAll('.program-field');
    
    let originalValues = {};
    
    // Store original values
    fields.forEach(field => originalValues[field.id] = field.value);

    editBtn.addEventListener('click', () => {
        fields.forEach(field => {
            field.removeAttribute('readonly');
            field.classList.remove('bg-gray-50');
            field.classList.add('bg-white');
        });
        
        editBtn.classList.add('hidden');
        saveBtn.classList.remove('hidden');
        discardBtn.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
    });

    [discardBtn, cancelBtn].forEach(btn => {
        btn.addEventListener('click', () => {
            fields.forEach(field => {
                field.value = originalValues[field.id];
                field.setAttribute('readonly', true);
                field.classList.add('bg-gray-50');
                field.classList.remove('bg-white');
            });
            
            editBtn.classList.remove('hidden');
            saveBtn.classList.add('hidden');
            discardBtn.classList.add('hidden');
            cancelBtn.classList.add('hidden');
        });
    });
});
</script>

<style>
.program-field:read-only {
    cursor: default;
}

.program-field:not([readonly]):hover {
    border-color: #ffb51b;
}

.program-field:focus {
    outline: none;
}

/* Responsive grid adjustments */
@media (max-width: 1279px) {
    .xl\:col-span-2 {
        grid-column: span 1;
    }
    .xl\:col-span-1 {
        grid-column: span 1;
    }
}
</style>
