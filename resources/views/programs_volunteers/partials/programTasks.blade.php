<div class="w-full bg-white border border-indigo-100 rounded-xl p-6 mb-6  transition-all duration-200 shadow-lg hover:shadow-sm backdrop-blur-sm">
    <form action="{{ route('programs.tasks.store', $program) }}" method="POST" x-data="{ expanded: false }">
        @csrf
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-800 flex items-center tracking-tight">
                <i class='bx bx-task text-indigo-600 w-5 h-5 mr-2'></i>
                Add New Task
            </h3>
            <x-button type="button" variant="primary" @click="expanded = !expanded">
                <i class='bx bx-plus w-4 h-4'></i>
                <span x-text="expanded ? 'Cancel' : 'New Task'"></span>
            </x-button>
        </div>

        <div x-show="expanded"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mt-4">
            <div class="flex flex-col gap-3">
                <x-form.textarea name="task_description" rows="2" placeholder="Describe the task…" required />
                <div class="flex justify-end">
                    <x-button type="submit" variant="save-entry">
                        <i class='bx bx-check w-4 h-4 mr-1'></i>
                        Add Task
                    </x-button>
                </div>
            </div>
            @error('task_description')
                <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </form>
</div>

@if($tasks->isEmpty())
    <x-empty-state 
        icon="circle-check" 
        title="No tasks created yet"    
        description="Create your first task to get started" />
@else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($tasks as $task)
            <div class="bg-white/80 border border-indigo-100 rounded-xl hover:border-indigo-200 transition-all duration-200 shadow-lg hover:shadow-sm overflow-hidden backdrop-blur-sm" data-animate>

                <div class="p-5 border-b border-slate-600 bg-gradient-to-br from-gray-900 via-slate-800 to-indigo-900">
                    <div class="flex items-center justify-between mb-3">
                        <x-feedback-status.status-indicator :status="$task->status" />

                        <div class="flex items-center gap-1">
                            <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST" class="inline-flex">
                                @csrf
                                @method('PUT')
                                <x-form.select-option name="status"
                                    class="text-xs border border-slate-600 rounded px-2 py-1 bg-slate-800 text-slate-100 focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400"
                                    onchange="this.form.submit()" :options="[
                                        ['value' => 'pending', 'label' => 'Pending', 'selected' => $task->status === 'pending'],
                                        ['value' => 'in_progress', 'label' => 'In Progress', 'selected' => $task->status === 'in_progress'],
                                        ['value' => 'completed', 'label' => 'Completed', 'selected' => $task->status === 'completed'],
                                    ]" />
                            </form>

                            <form action="{{ route('programs.tasks.destroy', [$program, $task]) }}" method="POST" onsubmit="return confirm('Delete this task?')" class="inline-flex">
                                @csrf
                                @method('DELETE')
                                <button class="text-slate-400 hover:text-red-400 p-1 hover:bg-red-900/20 rounded transition-colors">
                                    <i class='bx bx-trash w-4 h-4'></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div x-data="{ editing: false }">
                        <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div x-show="!editing" class="cursor-pointer group" @click="editing = true">
                                <p class="text-slate-100 text-sm leading-relaxed font-medium"
                                   style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $task->task_description }}
                                </p>
                                <p class="text-xs text-slate-300 mt-2 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                                    <i class='bx bx-edit w-3 h-3'></i>
                                    Click to edit
                                </p>
                            </div>
                            <div x-show="editing" class="space-y-2">
                                <x-form.textarea name="task_description" rows="3" required :value="$task->task_description" class="bg-slate-800 text-slate-100 border-slate-600" />
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

                <div class="p-4">
                    <div class="mb-4">
                        <h4 class="text-xs font-medium text-slate-600 mb-2 flex items-center">
                            <i class='bx bx-group w-3 h-3 mr-1'></i>
                            Assigned Volunteers
                        </h4>

                        @if($task->assignments->isNotEmpty())
                            <div class="space-y-2">
                                @foreach($task->assignments as $assignment)
                                    @php
                                        $assignmentStatusConfig = match ($assignment->status) {
                                            'completed'   => ['bg-emerald-50', 'text-emerald-700', 'border-emerald-200', 'bg-emerald-500'],
                                            'in_progress' => ['bg-sky-50',     'text-sky-700',     'border-sky-200',     'bg-sky-500'],
                                            default       => ['bg-amber-50',   'text-amber-700',   'border-amber-200',   'bg-amber-500'],
                                        };
                                    @endphp
                                    <div class="flex items-center justify-between p-2 rounded border {{ $assignmentStatusConfig[0] }} {{ $assignmentStatusConfig[2] }}">
                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            <div class="w-1.5 h-1.5 rounded-full {{ $assignmentStatusConfig[3] }} flex-shrink-0"></div>
                                            <span class="text-xs font-medium {{ $assignmentStatusConfig[1] }} truncate">
                                                {{ $assignment->volunteer->user->name }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('programs.tasks.assignments.update-status', [$program, $task, $assignment]) }}" method="POST" class="inline-flex">
                                                @csrf
                                                @method('PUT')
                                                <x-form.select-option name="status"
                                                    class="text-xs border border-indigo-200 rounded px-2 py-1 bg-white focus:ring-1"
                                                    onchange="this.form.submit()" :options="[
                                                        ['value' => 'pending', 'label' => 'Pending', 'selected' => $assignment->status === 'pending'],
                                                        ['value' => 'in_progress', 'label' => 'In Progress', 'selected' => $assignment->status === 'in_progress'],
                                                        ['value' => 'completed', 'label' => 'Completed', 'selected' => $assignment->status === 'completed'],
                                                    ]" />
                                            </form>
                                            <form action="{{ route('programs.tasks.assignments.destroy', [$program, $task, $assignment]) }}" method="POST" onsubmit="return confirm('Remove this volunteer from the task?')" class="inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-indigo-300 hover:text-red-600 hover:bg-red-50 rounded transition-colors">
                                                    <i class='bx bx-x w-4 h-4'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-400 text-xs italic">No volunteers assigned</p>
                        @endif
                    </div>

                    <div x-data="{ showAssign: false }">
                        <x-button @click="showAssign = !showAssign" variant="assign">
                            <i class='bx bx-user-plus w-4 h-4'></i>
                            <span x-text="showAssign ? 'Cancel' : 'Assign Volunteer'"></span>
                        </x-button>

                        <div x-show="showAssign"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="mt-2">
                            <form action="{{ route('programs.tasks.assign', [$program, $task]) }}" method="POST" class="space-y-2">
                                @csrf
                                <select name="volunteer_id" required
                                        class="w-full border border-indigo-200 rounded px-3 py-2 text-xs bg-white">
                                    <option value="">Select Volunteer</option>
                                    @foreach($program->volunteers as $volunteer)
                                        <option value="{{ $volunteer->id }}">
                                            {{ $volunteer->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-button type="submit" variant="assign" class="w-full">
                                    <i class='bx bx-check w-4 h-4 mr-1'></i>
                                    Assign
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
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

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

    @media (min-width: 1024px) and (max-width: 1279px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1536px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            gap: 1rem;
        }
    }
</style>


{{-- <div class="w-full bg-white border border-indigo-100 rounded-xl p-6 mb-6  transition-all duration-200 shadow-lg hover:shadow-sm backdrop-blur-sm">
    <form action="{{ route('programs.tasks.store', $program) }}" method="POST" x-data="{ expanded: false }">
        @csrf
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-800 flex items-center tracking-tight">
                <i class='bx bx-task text-indigo-600 w-5 h-5 mr-2'></i>
                Add New Task
            </h3>
            <x-button type="button" variant="primary" @click="expanded = !expanded">
                <i class='bx bx-plus w-4 h-4'></i>
                <span x-text="expanded ? 'Cancel' : 'New Task'"></span>
            </x-button>
        </div>

        <div x-show="expanded"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mt-4">
            <div class="flex flex-col gap-3">
                <x-form.textarea name="task_description" rows="2" placeholder="Describe the task…" required />
                <div class="flex justify-end">
                    <x-button type="submit" variant="save-entry">
                        <i class='bx bx-check w-4 h-4 mr-1'></i>
                        Add Task
                    </x-button>
                </div>
            </div>
            @error('task_description')
                <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </form>
</div>

@if($tasks->isEmpty())
    <x-empty-state 
        icon="circle-check" 
        title="No tasks created yet"    
        description="Create your first task to get started" />
@else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($tasks as $task)
            <div class="bg-white/80 border border-indigo-100 rounded-xl hover:border-indigo-200 transition-all duration-200 shadow-lg hover:shadow-sm overflow-hidden backdrop-blur-sm" data-animate>

                <div class="p-5 border-b border-slate-600 bg-gradient-to-br from-gray-900 via-slate-800 to-indigo-900">
                    <div class="flex items-center justify-between mb-3">
                        <x-feedback-status.status-indicator :status="$task->status" />

                        <div class="flex items-center gap-1">
                            <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST" class="inline-flex">
                                @csrf
                                @method('PUT')
                                <x-form.select-option name="status"
                                    class="text-xs border border-slate-600 rounded px-2 py-1 bg-slate-800 text-slate-100 focus:ring-1 focus:ring-indigo-400 focus:border-indigo-400"
                                    onchange="this.form.submit()" :options="[
                                        ['value' => 'pending', 'label' => 'Pending', 'selected' => $task->status === 'pending'],
                                        ['value' => 'in_progress', 'label' => 'In Progress', 'selected' => $task->status === 'in_progress'],
                                        ['value' => 'completed', 'label' => 'Completed', 'selected' => $task->status === 'completed'],
                                    ]" />
                            </form>

                            <form action="{{ route('programs.tasks.destroy', [$program, $task]) }}" method="POST" onsubmit="return confirm('Delete this task?')" class="inline-flex">
                                @csrf
                                @method('DELETE')
                                <button class="text-slate-400 hover:text-red-400 p-1 hover:bg-red-900/20 rounded transition-colors">
                                    <i class='bx bx-trash w-4 h-4'></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div x-data="{ editing: false }">
                        <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div x-show="!editing" class="cursor-pointer group" @click="editing = true">
                                <p class="text-slate-100 text-sm leading-relaxed font-medium"
                                   style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $task->task_description }}
                                </p>
                                <p class="text-xs text-slate-300 mt-2 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1">
                                    <i class='bx bx-edit w-3 h-3'></i>
                                    Click to edit
                                </p>
                            </div>
                            <div x-show="editing" class="space-y-2">
                                <x-form.textarea name="task_description" rows="3" required :value="$task->task_description" class="bg-slate-800 text-slate-100 border-slate-600" />
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

                <div class="p-4">
                    <div class="mb-4">
                        <h4 class="text-xs font-medium text-slate-600 mb-2 flex items-center">
                            <i class='bx bx-group w-3 h-3 mr-1'></i>
                            Assigned Volunteers
                        </h4>

                        @if($task->assignments->isNotEmpty())
                            <div class="space-y-2">
                                @foreach($task->assignments as $assignment)
                                    @php
                                        $assignmentStatusConfig = match ($assignment->status) {
                                            'completed'   => ['bg-emerald-50', 'text-emerald-700', 'border-emerald-200', 'bg-emerald-500'],
                                            'in_progress' => ['bg-sky-50',     'text-sky-700',     'border-sky-200',     'bg-sky-500'],
                                            default       => ['bg-amber-50',   'text-amber-700',   'border-amber-200',   'bg-amber-500'],
                                        };
                                    @endphp
                                    <div class="flex items-center justify-between p-2 rounded border {{ $assignmentStatusConfig[0] }} {{ $assignmentStatusConfig[2] }}">
                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            <div class="w-1.5 h-1.5 rounded-full {{ $assignmentStatusConfig[3] }} flex-shrink-0"></div>
                                            <span class="text-xs font-medium {{ $assignmentStatusConfig[1] }} truncate">
                                                {{ $assignment->volunteer->user->name }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('programs.tasks.assignments.update-status', [$program, $task, $assignment]) }}" method="POST" class="inline-flex">
                                                @csrf
                                                @method('PUT')
                                                <x-form.select-option name="status"
                                                    class="text-xs border border-indigo-200 rounded px-2 py-1 bg-white focus:ring-1 focus:ring-[#6366F1] focus:border-[#6366F1]"
                                                    onchange="this.form.submit()" :options="[
                                                        ['value' => 'pending', 'label' => 'Pending', 'selected' => $assignment->status === 'pending'],
                                                        ['value' => 'in_progress', 'label' => 'In Progress', 'selected' => $assignment->status === 'in_progress'],
                                                        ['value' => 'completed', 'label' => 'Completed', 'selected' => $assignment->status === 'completed'],
                                                    ]" />
                                            </form>
                                            <form action="{{ route('programs.tasks.assignments.destroy', [$program, $task, $assignment]) }}" method="POST" onsubmit="return confirm('Remove this volunteer from the task?')" class="inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-indigo-300 hover:text-red-600 hover:bg-red-50 rounded transition-colors">
                                                    <i class='bx bx-x w-4 h-4'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-400 text-xs italic">No volunteers assigned</p>
                        @endif
                    </div>

                    <div x-data="{ showAssign: false }">
                        <x-button @click="showAssign = !showAssign" variant="assign">
                            <i class='bx bx-user-plus w-4 h-4'></i>
                            <span x-text="showAssign ? 'Cancel' : 'Assign Volunteer'"></span>
                        </x-button>

                        <div x-show="showAssign"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="mt-2">
                            <form action="{{ route('programs.tasks.assign', [$program, $task]) }}" method="POST" class="space-y-2">
                                @csrf
                                <select class="volunteer-select w-full border border-indigo-200 rounded px-3 py-2 text-xs bg-white focus:ring-1 focus:ring-[#6366F1] focus:border-[#6366F1]" name="volunteer_id" required>
                                    <option value="">Select Volunteer</option>
                                    @foreach($program->volunteers as $volunteer)
                                        <option value="{{ $volunteer->id }}">
                                            {{ $volunteer->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-button type="submit" variant="assign" class="w-full">
                                    <i class='bx bx-check w-4 h-4 mr-1'></i>
                                    Assign
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- <style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

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

    @media (min-width: 1024px) and (max-width: 1279px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1536px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .grid-cols-1.md\:grid-cols-2.xl\:grid-cols-3 {
            gap: 1rem;
        }
    }
</style> --}}

{{-- <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.volunteer-select').forEach(function(el) {
            new TomSelect(el, {
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                }
            });
        });
    });
</script> --}}
