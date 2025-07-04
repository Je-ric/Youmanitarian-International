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
                <x-card 
                    title="Basic Information" 
                    icon="bx-info-circle"
                    headerColor="bg-[#1a2235] text-white"
                    borderColor="border-[#ffb51b]"
                >
                    <div class="space-y-6">
                        <!-- Program Title -->
                        <div>
                            <x-form.label for="title"><i class='bx bx-info-circle mr-1 text-blue-500'></i>Program Title</x-form.label>
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
                            <x-form.label for="description"><i class='bx bx-info-circle mr-1 text-blue-500'></i>Description</x-form.label>
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
                            <x-form.label for="location"><i class='bx bx-map mr-1 text-green-600'></i>Location <span class='text-gray-400 text-xs'>(Optional)</span></x-form.label>
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
                </x-card>
            </div>

            <!-- Right Column - Schedule & Settings -->
            <div class="xl:col-span-1 space-y-6">
                
                <!-- Schedule -->
                <x-card 
                    title="Schedule" 
                    icon="bx-calendar"
                    headerColor="bg-[#ffb51b] text-[#1a2235]"
                    borderColor="border-[#1a2235]"
                >
                    <div class="space-y-4">
                        <!-- Date -->
                        <div>
                            <x-form.label for="date"><i class='bx bx-calendar mr-1 text-purple-600'></i>Date</x-form.label>
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
                                <x-form.label for="start_time"><i class='bx bx-time-five mr-1 text-green-600'></i>Start</x-form.label>
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
                                <x-form.label for="end_time"><i class='bx bx-time-five mr-1 text-red-600'></i>End</x-form.label>
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
                </x-card>

                <!-- Program Settings -->
                <x-card 
                    title="Settings" 
                    icon="bx-cog"
                    headerColor="bg-[#1a2235] text-white"
                    borderColor="border-[#ffb51b]"
                >
                        <div>
                            <x-form.label for="volunteer_count"><i class='bx bx-group mr-1 text-pink-500'></i>Volunteers Needed</x-form.label>
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
                </x-card>

                <!-- Program Status (Read-only info) -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Program Status</h4>
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

@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1a2235] mb-2">Card Component Showcase</h1>
        <p class="text-gray-600">Professional card designs for organizational use</p>
    </div>

    <!-- Card Variants Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-12">
        
        <!-- Default Variant -->
        <x-card title="Default Professional" icon="bx-info-circle" variant="default">
            <div class="space-y-3">
                <p class="text-gray-700 text-sm leading-relaxed">
                    Clean, professional design with subtle gradients and proper contrast ratios.
                </p>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class='bx bx-check-circle text-green-500'></i>
                    <span>Perfect for general content</span>
                </div>
            </div>
        </x-card>

        <!-- Gradient Variant -->
        <x-card title="Gradient Accent" icon="bx-palette" variant="gradient">
            <div class="space-y-3">
                <p class="text-gray-700 text-sm leading-relaxed">
                    Eye-catching gradient design that draws attention while maintaining professionalism.
                </p>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class='bx bx-star text-[#ffb51b]'></i>
                    <span>Great for featured content</span>
                </div>
            </div>
        </x-card>

        <!-- Minimal Variant -->
        <x-card title="Minimal Clean" icon="bx-minimize" variant="minimal">
            <div class="space-y-3">
                <p class="text-gray-700 text-sm leading-relaxed">
                    Clean, minimal design with accent border for subtle emphasis.
                </p>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class='bx bx-layout text-blue-500'></i>
                    <span>Ideal for data displays</span>
                </div>
            </div>
        </x-card>

        <!-- Elevated Variant -->
        <x-card title="Elevated Premium" icon="bx-crown" variant="elevated" size="default">
            <div class="space-y-3">
                <p class="text-gray-700 text-sm leading-relaxed">
                    Premium design with enhanced shadows and decorative elements for important content.
                </p>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class='bx bx-award text-purple-500'></i>
                    <span>Perfect for highlights</span>
                </div>
            </div>
        </x-card>

        <!-- Bordered Variant -->
        <x-card title="Bordered Formal" icon="bx-border-all" variant="bordered">
            <div class="space-y-3">
                <p class="text-gray-700 text-sm leading-relaxed">
                    Formal design with defined borders, perfect for official documentation.
                </p>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class='bx bx-file text-indigo-500'></i>
                    <span>Great for forms & docs</span>
                </div>
            </div>
        </x-card>

        <!-- Custom Example -->
        <x-card 
            title="Custom Colors" 
            icon="bx-customize" 
            variant="default"
            headerColor="bg-gradient-to-r from-emerald-600 to-teal-600 text-white"
            bodyColor="bg-emerald-50"
        >
            <div class="space-y-3">
                <p class="text-gray-700 text-sm leading-relaxed">
                    Fully customizable with your own color schemes and branding.
                </p>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class='bx bx-color text-emerald-500'></i>
                    <span>Unlimited customization</span>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Size Variations -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-[#1a2235] mb-6">Size Variations</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <x-card title="Small Size" icon="bx-minus" variant="gradient" size="small">
                <p class="text-sm text-gray-600">Compact design for tight spaces and sidebar content.</p>
            </x-card>

            <x-card title="Default Size" icon="bx-square" variant="default" size="default">
                <p class="text-sm text-gray-600">Standard size perfect for most content areas and general use.</p>
            </x-card>

            <x-card title="Large Size" icon="bx-plus" variant="elevated" size="large">
                <p class="text-sm text-gray-600">Spacious design for important content that needs more visual weight.</p>
            </x-card>
        </div>
    </div>

    <!-- Real-world Examples -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-[#1a2235] mb-6">Real-world Examples</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Statistics Card -->
            <x-card title="Monthly Statistics" icon="bx-bar-chart" variant="gradient">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-[#1a2235]">1,247</div>
                        <div class="text-sm text-gray-500">Total Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-[#ffb51b]">89%</div>
                        <div class="text-sm text-gray-500">Satisfaction</div>
                    </div>
                </div>
            </x-card>

            <!-- Task Management -->
            <x-card title="Task Overview" icon="bx-task" variant="minimal">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Completed Tasks</span>
                        <span class="text-sm font-semibold text-green-600">24/30</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 80%"></div>
                    </div>
                    <div class="text-xs text-gray-500">6 tasks remaining</div>
                </div>
            </x-card>

            <!-- Notification Card -->
            <x-card title="Recent Activity" icon="bx-bell" variant="elevated">
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-[#ffb51b] rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="text-sm text-gray-700">New volunteer application received</p>
                            <p class="text-xs text-gray-500">2 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                        <div>
                            <p class="text-sm text-gray-700">Program schedule updated</p>
                            <p class="text-xs text-gray-500">1 hour ago</p>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Settings Card -->
            <x-card title="System Settings" icon="bx-cog" variant="bordered">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Email Notifications</span>
                        <div class="w-10 h-6 bg-[#ffb51b] rounded-full relative">
                            <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 shadow-sm"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Auto-save</span>
                        <div class="w-10 h-6 bg-gray-300 rounded-full relative">
                            <div class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 shadow-sm"></div>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Usage Guidelines -->
    <div class="bg-gradient-to-r from-slate-50 to-gray-50 rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-[#1a2235] mb-6">Usage Guidelines</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-[#1a2235] mb-3">When to Use Each Variant</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <i class='bx bx-check text-green-500 mt-0.5'></i>
                        <span><strong>Default:</strong> General content, forms, standard information</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-check text-green-500 mt-0.5'></i>
                        <span><strong>Gradient:</strong> Featured content, call-to-actions, highlights</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-check text-green-500 mt-0.5'></i>
                        <span><strong>Minimal:</strong> Data displays, statistics, clean layouts</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-check text-green-500 mt-0.5'></i>
                        <span><strong>Elevated:</strong> Important notices, premium content</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-check text-green-500 mt-0.5'></i>
                        <span><strong>Bordered:</strong> Forms, documentation, formal content</span>
                    </li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-[#1a2235] mb-3">Best Practices</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start gap-2">
                        <i class='bx bx-bulb text-[#ffb51b] mt-0.5'></i>
                        <span>Use consistent variants within the same section</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-bulb text-[#ffb51b] mt-0.5'></i>
                        <span>Choose appropriate sizes based on content importance</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-bulb text-[#ffb51b] mt-0.5'></i>
                        <span>Maintain proper spacing between cards</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-bulb text-[#ffb51b] mt-0.5'></i>
                        <span>Use icons that relate to the card content</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class='bx bx-bulb text-[#ffb51b] mt-0.5'></i>
                        <span>Test readability across different screen sizes</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

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
