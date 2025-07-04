<!-- Add New Task - Compact Design -->
<div
    class="w-full bg-white border border-gray-200 rounded-xl p-6 mb-6 shadow-sm">
    <form action="{{ route('programs.tasks.store', $program) }}" method="POST" x-data="{ expanded: false }">
        @csrf
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-[#1a2235] flex items-center">
                <i class='bx bx-plus-circle mr-2' style="color:#1a2235;"></i>
                Add New Task
            </h3>
            <x-button type="button" variant="primary" @click="expanded = !expanded">
                <i class='bx bx-plus mr-1'></i>
                <span x-text="expanded ? 'Cancel' : 'New Task'"></span>
            </x-button>
        </div>

        <div x-show="expanded" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-4">
            <div class="flex flex-col gap-3">
                <textarea name="task_description" rows="2"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] bg-slate-50 text-[#1a2235] placeholder-gray-400 resize-none"
                    placeholder="Describe the task..." required></textarea>
                <div class="flex justify-end">
                    <x-button type="submit" variant="save-entry">
                        <i class='bx bx-check mr-1'></i> Add Task
                    </x-button>
                </div>
            </div>
            @error('task_description')
                <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </form>
</div>

<!-- Tasks Grid -->
@if($tasks->isEmpty())
    <x-empty-state 
        icon="bx bx-task" 
        title="No tasks created yet"    
        description="Create your first task to get started" />
@else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($tasks as $task)
            <div
                class="bg-white border border-slate-200 rounded-xl hover:border-slate-300 transition-all duration-200 hover:shadow-lg shadow-sm overflow-hidden">

                <!-- Card Header -->
                <div class="p-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <!-- Status Badge -->
                        <x-feedback-status.status-indicator :status="$task->status" />

                        <!-- Actions Menu -->
                        <div class="flex items-center gap-1">
                            <!-- Status Update -->
                            <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST"
                                class="inline-flex">
                                @csrf
                                @method('PUT')
                                <x-form.select-option name="status"
                                    class="text-xs border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-[#ffb51b] focus:border-[#ffb51b] bg-white"
                                    onchange="this.form.submit()" :options="[
                        ['value' => 'pending', 'label' => 'Pending', 'selected' => $task->status === 'pending'],
                        ['value' => 'in_progress', 'label' => 'In Progress', 'selected' => $task->status === 'in_progress'],
                        ['value' => 'completed', 'label' => 'Completed', 'selected' => $task->status === 'completed'],
                    ]" />
                            </form>

                            <!-- Delete Button -->
                            <form action="{{ route('programs.tasks.destroy', [$program, $task]) }}" method="POST"
                                onsubmit="return confirm('Delete this task?')" class="inline-flex">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-400 hover:text-red-600 p-1 hover:bg-red-50 rounded transition-colors">
                                    <i class='bx bx-trash text-sm'></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Task Description -->
                    <div x-data="{ editing: false }">
                        <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div x-show="!editing" class="cursor-pointer group" @click="editing = true">
                                <p class="text-slate-700 text-sm leading-relaxed line-clamp-3 font-medium">
                                    {{ $task->task_description }}</p>
                                <p
                                    class="text-xs text-slate-400 mt-2 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                                    <i class='bx bx-edit-alt'></i>
                                    Click to edit
                                </p>
                            </div>
                            <div x-show="editing" class="space-y-2">
                                <textarea name="task_description"
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] resize-none"
                                    rows="3" required>{{ $task->task_description }}</textarea>
                                <div class="flex gap-2">
                                    <x-button type="submit" variant="save-entry">
                                        Save
                                    </x-button>
                                    <x-button type="button" variant="cancel" @click="editing = false">
                                        Cancel
                                    </x-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Card Body - Assignments -->
                <div class="p-4">
                    <!-- Current Assignments -->
                    <div class="mb-4">
                        <h4 class="text-xs font-medium text-gray-600 mb-2 flex items-center">
                            <i class='bx bx-users mr-1'></i>
                            Assigned Volunteers
                        </h4>

                        @if($task->assignments->isNotEmpty())
                            <div class="space-y-2">
                                @foreach($task->assignments as $assignment)
                                    @php
                                        $assignmentStatusConfig = match ($assignment->status) {
                                            'completed' => ['bg-green-50', 'text-green-700', 'border-green-200', 'bg-green-500'],
                                            'in_progress' => ['bg-blue-50', 'text-blue-700', 'border-blue-200', 'bg-blue-500'],
                                            default => ['bg-amber-50', 'text-amber-700', 'border-amber-200', 'bg-amber-500'],
                                        };
                                    @endphp
                                    <div
                                        class="flex items-center justify-between p-2 rounded border {{ $assignmentStatusConfig[0] }} {{ $assignmentStatusConfig[2] }}">
                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            <div class="w-1.5 h-1.5 rounded-full {{ $assignmentStatusConfig[3] }} flex-shrink-0"></div>
                                            <span class="text-xs font-medium {{ $assignmentStatusConfig[1] }} truncate">
                                                {{ $assignment->volunteer->user->name }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <!-- Status Dropdown -->
                                            <form
                                                action="{{ route('programs.tasks.assignments.update-status', [$program, $task, $assignment]) }}"
                                                method="POST" class="inline-flex">
                                                @csrf
                                                @method('PUT')
                                                <x-form.select-option name="status"
                                                    class="text-xs border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-[#ffb51b] focus:border-[#ffb51b] bg-white"
                                                    onchange="this.form.submit()" :options="[
                                        ['value' => 'pending', 'label' => 'Pending', 'selected' => $assignment->status === 'pending'],
                                        ['value' => 'in_progress', 'label' => 'In Progress', 'selected' => $assignment->status === 'in_progress'],
                                        ['value' => 'completed', 'label' => 'Completed', 'selected' => $assignment->status === 'completed'],
                                    ]" />
                                            </form>
                                            <!-- Remove Button -->
                                            <form
                                                action="{{ route('programs.tasks.assignments.destroy', [$program, $task, $assignment]) }}"
                                                method="POST" onsubmit="return confirm('Remove this volunteer from the task?')"
                                                class="inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors">
                                                    <i class='bx bx-x text-xs'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-xs italic">No volunteers assigned</p>
                        @endif
                    </div>

                    <!-- Assign New Volunteer -->
                    <div x-data="{ showAssign: false }">
                        <x-button @click="showAssign = !showAssign" variant="test">
                            <i class='bx bx-plus'></i>
                            <span x-text="showAssign ? 'Cancel' : 'Assign Volunteer'"></span>
                        </x-button>

                        <div x-show="showAssign" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-2">
                            <form action="{{ route('programs.tasks.assign', [$program, $task]) }}" method="POST"
                                class="space-y-2">
                                @csrf
                                <select name="volunteer_id" required
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-xs focus:ring-1 focus:ring-[#ffb51b] focus:border-[#ffb51b]">
                                    <option value="">Select Volunteer</option>
                                    @foreach($program->volunteers as $volunteer)
                                        <option value="{{ $volunteer->id }}">
                                            {{ $volunteer->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-button type="submit" variant="test" class="w-full">
                                    <i class='bx bx-check mr-1'></i> Assign
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<style>
    /* Line clamp utility for task descriptions */
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Responsive grid adjustments */
    @media (min-width: 768px) and (max-width: 1279px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1280px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    /* Sidebar-friendly responsive adjustments */
    @media (min-width: 1024px) and (max-width: 1279px) {

        /* For systems with sidebar, 2 columns work better on laptop screens */
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1536px) {

        /* On very large screens with sidebar, 3 columns work well */
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    /* Mobile optimizations */
    @media (max-width: 640px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            gap: 1rem;
        }
    }
</style>