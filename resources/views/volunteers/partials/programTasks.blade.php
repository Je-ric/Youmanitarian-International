<div class="max-w-5xl mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold text-gray-900 mb-6">Program Tasks - {{ $program->title }}</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)" 
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
        >
            {{ session('success') }}
        </div>
    @endif

    {{-- Add New Task --}}
    <form action="{{ route('programs.tasks.store', $program) }}" method="POST" class="bg-white rounded-lg shadow p-4 mb-6">
        @csrf
        <div class="flex flex-col sm:flex-row gap-3">
            <textarea 
                name="task_description" 
                rows="2"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                placeholder="New task description..." 
                required
            ></textarea>
            <button 
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition w-full sm:w-auto"
            >
                Add Task
            </button>
        </div>
        @error('task_description')
            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
        @enderror
    </form>

    {{-- Tasks Table --}}
    @if($tasks->isEmpty())
        <p class="text-gray-600 text-center">No tasks added yet.</p>
    @else
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-left text-gray-700">
                    <tr>
                        <th class="px-4 py-3 w-1/2">Task</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Assign Volunteer</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            {{-- Editable Description --}}
                            <td class="px-4 py-3 align-top">
                                <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST" class="flex flex-col gap-2">
                                    @csrf
                                    @method('PUT')
                                    <textarea 
                                        name="task_description" 
                                        class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        rows="2"
                                        required
                                    >{{ $task->task_description }}</textarea>
                                    <button type="submit" class="text-sm text-blue-600 hover:underline self-start">
                                        Save
                                    </button>
                                </form>

                                {{-- Assigned Volunteers --}}
                                @if($task->assignments->isNotEmpty())
                                    <div class="mt-2 text-xs text-gray-600">
                                        Assigned:
                                        <ul class="list-disc list-inside ml-2">
                                            @foreach($task->assignments as $assignment)
                                                <li>{{ $assignment->volunteer->user->name }} ({{ ucfirst($assignment->status) }})</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </td>

                            {{-- Status Dropdown --}}
                            <td class="px-4 py-3 align-top">
                                <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select 
                                        name="status" 
                                        onchange="this.form.submit()" 
                                        class="border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>

                            {{-- Assign Volunteer --}}
                            <td class="px-4 py-3 align-top">
                                <form action="{{ route('programs.tasks.assign', [$program, $task]) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <select 
                                        name="volunteer_id" 
                                        required
                                        class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                                        class="text-sm bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700"
                                    >
                                        Assign
                                    </button>
                                </form>
                            </td>

                            {{-- Delete Button --}}
                            <td class="px-4 py-3 align-top">
                                <form action="{{ route('programs.tasks.destroy', [$program, $task]) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>