@extends('layouts.sidebar_final')

@section('content')
@if (session('toast'))
    <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
@endif

<div x-data="{ 
    activeTab: new URLSearchParams(window.location.search).get('tab') || 'volunteers',
    setTab(tab) {
        this.activeTab = tab;
        const url = new URL(window.location);
        url.searchParams.set('tab', tab);
        window.history.pushState({}, '', url);
    }
}" class="container mx-auto px-4 sm:px-6 py-6">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#1a2235] mb-2">
            Manage Program
        </h1>
        <p class="text-gray-600">{{ $program->title }}</p>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-8">
        <div class="bg-gray-50 p-1 rounded-lg inline-flex space-x-1">
            <button 
                @click="setTab('volunteers')"
                :class="activeTab === 'volunteers' ? 'bg-white text-[#1a2235] border border-gray-200' : 'text-gray-600 hover:text-[#1a2235]'"
                class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                <i class='bx bx-group mr-1'></i>
                Volunteers
            </button>
            
            <button 
                @click="setTab('tasks')"
                :class="activeTab === 'tasks' ? 'bg-white text-[#1a2235] border border-gray-200' : 'text-gray-600 hover:text-[#1a2235]'"
                class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                <i class='bx bx-task mr-1'></i>
                Tasks & Assignments
            </button>
            
            <button 
                @click="setTab('program')"
                :class="activeTab === 'program' ? 'bg-white text-[#1a2235] border border-gray-200' : 'text-gray-600 hover:text-[#1a2235]'"
                class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                <i class='bx bx-cog mr-1'></i>
                Program Settings
            </button>
        </div>
    </div>

    <!-- Volunteers Tab -->
    <div x-show="activeTab === 'volunteers'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        
         <x-button href="{{ route('programs.feedback.view', $program->id) }}" variant="secondary" class="mb-6">
            View Feedbacks
        </x-button>
        <div class="text-end mb-4">
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                data-drawer-placement="right" aria-controls="drawer-right-example">
                Assign Volunteers
            </button>
        </div>
        @if($program->volunteers->isEmpty())
            <p class="text-gray-600 text-center py-4">No volunteers assigned to this program.</p>
        @else
            <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                <thead class="bg-[#1a2235] text-white">
                    <tr>
                        <th class="p-4 text-left text-sm font-medium">Name</th>
                        <th class="p-4 text-left text-sm font-medium">Clock In</th>
                        <th class="p-4 text-left text-sm font-medium">Clock Out</th>
                        <th class="p-4 text-left text-sm font-medium">Total Time</th>
                        <th class="p-4 text-left text-sm font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($program->volunteers as $volunteer)
                        @if($volunteer->pivot->status == 'approved')
                            <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                                <td class="p-4 text-sm text-[#1a2235] font-semibold">
                                    {{ $volunteer->user->name }}
                                    <span class="text-gray-500">({{ $volunteer->user->email }})</span>
                                </td>
                                <td class="p-4 text-sm">
                                    @php
                                        $volunteerLogs = $logs[$volunteer->id]['logs'] ?? collect();
                                    @endphp
                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        @foreach ($volunteerLogs as $log)
                                            <div class="flex gap-2">
                                                <span class="text-sm text-gray-600">
                                                    {{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="p-4 text-sm">
                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        @foreach ($volunteerLogs as $log)
                                            <div class="flex gap-2">
                                                <span class="text-sm text-gray-600">
                                                    @if ($log->clock_out)
                                                        {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                                                    @else
                                                        <span class="text-red-500">Still Clocked In</span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="p-4 text-sm">
                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        <p class="text-gray-600">{{ $logs[$volunteer->id]['totalTime'] ?? 'N/A' }}</p>
                                    @endif
                                </td>
                                <td class="p-4 flex items-center gap-2">
                                    @php
                                        $hasLogs = !$volunteerLogs->isEmpty();
                                        $allReviewed = $hasLogs && $volunteerLogs->every(fn($log) => in_array($log->approval_status, ['approved', 'rejected']));
                                    @endphp
                                    <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info">
                                        <i class='bx bx-show'></i> View
                                    </x-button>
                                    @if ($allReviewed)
                                        <button class="btn btn-outline text-green-600 border-green-300 hover:bg-green-50"
                                            title="Attendance already reviewed"
                                            onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()">
                                            <i class='bx bx-check-double'></i> Reviewed
                                        </button>
                                    @else
                                        <button class="btn btn-info"
                                            onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()">
                                            <i class='bx bx-show'></i> Review Attendance
                                        </button>
                                    @endif
                                    @include('volunteers.modals.attendanceApproval', ['volunteer' => $volunteer, 'volunteerLogs' => $volunteerLogs])
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
        @include('volunteers.partials.offCanvas')

    </div>

    <!-- Tasks & Assignments Tab -->
    <div x-show="activeTab === 'tasks'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        
        <!-- Add New Task -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-[#1a2235] mb-4 flex items-center">
                <i class='bx bx-plus-circle mr-2 text-[#ffb51b]'></i>
                Add New Task
            </h3>
            
            <form action="{{ route('programs.tasks.store', $program) }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <textarea 
                        name="task_description" 
                        rows="2"
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] resize-none" 
                        placeholder="Describe the task..." 
                        required
                    ></textarea>
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-[#1a2235] text-white rounded-lg hover:bg-[#2a3245] transition-colors font-medium whitespace-nowrap"
                    >
                        <i class='bx bx-plus mr-1'></i> Add Task
                    </button>
                </div>
                @error('task_description')
                    <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                @enderror
            </form>
        </div>

        <!-- Tasks List -->
        @if($tasks->isEmpty())
            <div class="text-center py-12">
                <i class='bx bx-task text-4xl text-gray-300 mb-4'></i>
                <p class="text-gray-500 text-lg">No tasks created yet.</p>
                <p class="text-gray-400 text-sm mt-2">Add your first task using the form above.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($tasks as $task)
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:border-gray-300 transition-colors">
                        
                        <!-- Task Header -->
                        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 mb-4">
                            <div class="flex-1">
                                <!-- Status Badge -->
                                <div class="flex items-center gap-3 mb-3">
                                    @php
                                        $statusConfig = match($task->status) {
                                            'completed' => ['bg-green-100', 'text-green-800', 'bx-check-circle', 'Completed'],
                                            'in_progress' => ['bg-blue-100', 'text-blue-800', 'bx-time', 'In Progress'],
                                            default => ['bg-gray-100', 'text-gray-800', 'bx-clock', 'Pending']
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusConfig[0] }} {{ $statusConfig[1] }}">
                                        <i class='bx {{ $statusConfig[2] }} mr-1'></i>
                                        {{ $statusConfig[3] }}
                                    </span>
                                    
                                    <!-- Quick Status Update -->
                                    <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('PUT')
                                        <select 
                                            name="status" 
                                            onchange="this.form.submit()" 
                                            class="text-sm border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-[#ffb51b] focus:border-[#ffb51b]"
                                        >
                                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </form>
                                </div>

                                <!-- Task Description -->
                                <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST" x-data="{ editing: false }">
                                    @csrf
                                    @method('PUT')
                                    <div x-show="!editing" class="cursor-pointer" @click="editing = true">
                                        <p class="text-gray-800 leading-relaxed">{{ $task->task_description }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Click to edit</p>
                                    </div>
                                    <div x-show="editing" class="space-y-2">
                                        <textarea 
                                            name="task_description" 
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] resize-none"
                                            rows="3"
                                            required
                                        >{{ $task->task_description }}</textarea>
                                        <div class="flex gap-2">
                                            <button type="submit" class="px-3 py-1 bg-[#1a2235] text-white rounded text-sm hover:bg-[#2a3245] transition-colors">
                                                Save
                                            </button>
                                            <button type="button" @click="editing = false" class="px-3 py-1 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200 transition-colors">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Delete Button -->
                            <form action="{{ route('programs.tasks.destroy', [$program, $task]) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded transition-colors">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </div>

                        <!-- Assignments Section -->
                        <div class="border-t border-gray-100 pt-4">
                            <div class="flex flex-col lg:flex-row gap-4">
                                
                                <!-- Current Assignments -->
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class='bx bx-users mr-1'></i>
                                        Assigned Volunteers
                                    </h4>
                                    
                                    @if($task->assignments->isNotEmpty())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($task->assignments as $assignment)
                                                @php
                                                    $assignmentStatusConfig = match($assignment->status) {
                                                        'completed' => ['bg-green-50', 'text-green-700', 'border-green-200'],
                                                        'in_progress' => ['bg-blue-50', 'text-blue-700', 'border-blue-200'],
                                                        default => ['bg-gray-50', 'text-gray-700', 'border-gray-200']
                                                    };
                                                @endphp
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm border {{ $assignmentStatusConfig[0] }} {{ $assignmentStatusConfig[1] }} {{ $assignmentStatusConfig[2] }}">
                                                    <div class="w-2 h-2 rounded-full mr-2 {{ $assignment->status === 'completed' ? 'bg-green-500' : ($assignment->status === 'in_progress' ? 'bg-blue-500' : 'bg-gray-400') }}"></div>
                                                    {{ $assignment->volunteer->user->name }}
                                                    <span class="ml-1 text-xs">({{ ucfirst($assignment->status) }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-sm">No volunteers assigned yet</p>
                                    @endif
                                </div>

                                <!-- Assign New Volunteer -->
                                <div class="lg:w-80">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Assign Volunteer</h4>
                                    <form action="{{ route('programs.tasks.assign', [$program, $task]) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <select 
                                            name="volunteer_id" 
                                            required
                                            class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm focus:ring-1 focus:ring-[#ffb51b] focus:border-[#ffb51b]"
                                        >
                                            <option value="">Select Volunteer</option>
                                            @foreach($program->volunteers as $volunteer)
                                                <option value="{{ $volunteer->id }}">
                                                    {{ $volunteer->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button 
                                            type="submit" 
                                            class="px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded hover:bg-[#e6a319] transition-colors text-sm font-medium whitespace-nowrap"
                                        >
                                            <i class='bx bx-plus mr-1'></i> Assign
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Program Settings Tab -->
    <div x-show="activeTab === 'program'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="text-center py-12">
            <i class='bx bx-cog text-4xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">Program settings coming soon.</p>
        </div>
    </div>
</div>

<script>
// Preserve tab state on page reload
document.addEventListener('DOMContentLoaded', function() {
    // Listen for form submissions and preserve tab state
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const activeTab = Alpine.store ? Alpine.store.activeTab : 'volunteers';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'preserve_tab';
            input.value = activeTab;
            this.appendChild(input);
        });
    });
});
</script>
@endsection
