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
                    <x-button
                        variant="primary"
                        type="button"
                        id="editBtn">
                        <i class='bx bx-edit mr-2'></i> Edit Program
                    </x-button>
                    <x-button variant="discard" type="button" id="discardBtn" class="hidden">
                        <i class='bx bx-x mr-2'></i>Discard
                    </x-button>
                    <x-button variant="save-entry" type="submit" id="saveBtn" class="hidden">
                        <i class='bx bx-save mr-2'></i> Save Changes
                    </x-button>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Left Column - Main Information -->
            <div class="xl:col-span-2 space-y-6">
                
                <!-- Basic Information -->
                <x-overview.card title="Basic Information" icon="bx-info-circle" variant="midnight-header">
                    <div class="space-y-6">
                        <!-- Program Title -->
                        <div>
                            <x-form.label for="title"><i class='bx bx-bookmark mr-1 text-blue-500'></i>Program Title</x-form.label>
                            <x-form.input
                                id="title"
                                name="title"
                                :value="old('title', $program->title)"
                                required
                                readonly
                                class="program-field"
                            />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-form.label for="description"><i class='bx bx-text mr-1 text-green-500'></i>Description</x-form.label>
                            <x-form.textarea
                                id="description"
                                name="description"
                                rows="6"
                                :value="old('description', $program->description)"
                                required
                                readonly
                                class="program-field resize-none"
                            />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-form.label for="location"><i class='bx bx-map-pin mr-1 text-red-500'></i>Location <span class='text-gray-400 text-xs'>(Optional)</span></x-form.label>
                            <x-form.input
                                id="location"
                                name="location"
                                :value="old('location', $program->location)"
                                placeholder="Enter program location"
                                readonly
                                class="program-field"
                            />
                        </div>
                    </div>
                </x-overview.card>
            </div>

            <!-- Right Column - Schedule & Settings -->
            <div class="xl:col-span-1 space-y-6">
                
                <!-- Schedule -->
                <x-overview.card title="Schedule" icon="bx-calendar" variant="elevated">
                    <div class="space-y-4">
                        <!-- Date -->
                        <div>
                            <x-form.label for="date"><i class='bx bx-calendar-check mr-1 text-purple-500'></i>Date</x-form.label>
                            <x-form.date-picker
                                id="date"
                                name="date"
                                :value="old('date', \Carbon\Carbon::parse($program->date)->format('Y-m-d'))"
                                readonly="true"
                                required="true"
                                class="program-field"
                            />
                        </div>

                        <!-- Time Range -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-form.label for="start_time"><i class='bx bx-play-circle mr-1 text-green-500'></i>Start</x-form.label>
                                <x-form.time-picker
                                    id="start_time"
                                    name="start_time"
                                    :value="old('start_time', \Carbon\Carbon::parse($program->start_time)->format('H:i'))"
                                    readonly="true"
                                    required="true"
                                    class="program-field"
                                />
                            </div>

                            <div>
                                <x-form.label for="end_time"><i class='bx bx-stop-circle mr-1 text-red-500'></i>End</x-form.label>
                                <x-form.time-picker
                                    id="end_time"
                                    name="end_time"
                                    :value="old('end_time', \Carbon\Carbon::parse($program->end_time)->format('H:i'))"
                                    readonly="true"
                                    required="true"
                                    class="program-field"
                                />
                            </div>
                        </div>
                    </div>
                </x-overview.card>

                <!-- Program Settings -->
                <x-overview.card title="Settings" icon="bx-cog" variant="elevated">
                    <div>
                        <!-- Volunteers Needed -->
                        <div>
                            <x-form.label for="volunteer_count"><i class='bx bx-user-plus mr-1 text-indigo-500'></i>Volunteers Needed</x-form.label>
                            <x-form.input
                                id="volunteer_count"
                                name="volunteer_count"
                                type="number"
                                min="0"
                                :value="old('volunteer_count', $program->volunteer_count)"
                                placeholder="0"
                                readonly
                                class="program-field"
                            />
                        </div>
                    </div>
                </x-overview.card>

                <!-- Program Status (Read-only info) -->
                <x-overview.card title="Program Status" icon="bx-bar-chart" variant="minimal">
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Status:</span>
                            <x-feedback-status.programProgress :program="$program" />
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
                </x-overview.card>
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
                    <x-button
                    variant="ca"
                        type="button"
                        id="cancelBtn"
                        class="hidden items-center justify-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
                    >
                        Cancel
                    </x-button>
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
