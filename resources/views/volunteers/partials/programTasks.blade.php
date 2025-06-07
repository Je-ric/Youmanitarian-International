<h2 class="text-xl font-semibold text-[#1a2235] mb-4">Program Tasks</h2>

{{-- Success Toast --}}
@if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => show = false, 3500)" 
        class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50"
    >
        {{ session('success') }}
    </div>
@endif

{{-- Add New Task --}}
<form action="{{ route('programs.tasks.store', $program) }}" method="POST" class="mb-6">
    @csrf
    <div class="flex gap-2">
        <textarea 
            name="task_description" 
            rows="2" 
            class="flex-grow border rounded p-2 focus:outline-none focus:ring-2 focus:ring-[#1a2235]" 
            placeholder="New task description..." 
            required
        ></textarea>
        <button type="submit" class="btn btn-primary px-4 py-2 rounded bg-[#1a2235] hover:bg-[#16202b] text-white transition">
            Add Task
        </button>
    </div>
    @error('task_description')
        <p class="text-red-600 mt-1">{{ $message }}</p>
    @enderror
</form>

{{-- Display Tasks --}}
@if($tasks->isEmpty())
    <p class="text-gray-600">No tasks created yet.</p>
@else
    <table class="min-w-full bg-white shadow rounded border border-gray-200">
        <thead class="bg-[#1a2235] text-white">
            <tr>
                <th class="p-3 text-left">Description</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">
                        {{-- Inline editable task description form --}}
                        <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <textarea 
                                name="task_description" 
                                rows="2" 
                                class="border rounded p-1 w-full resize-none focus:outline-none focus:ring-2 focus:ring-[#1a2235]"
                                required
                            >{{ $task->task_description }}</textarea>
                            <button type="submit" class="btn btn-secondary btn-sm px-3 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white transition" title="Update Description">
                                Save
                            </button>
                        </form>
                    </td>
                    <td class="p-3">
                        {{-- Update status form --}}
                        <form action="{{ route('programs.tasks.update', [$program, $task]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select 
                                name="status" 
                                onchange="this.form.submit()" 
                                class="border rounded p-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#1a2235]"
                                title="Change Status"
                            >
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td class="p-3 flex gap-2 items-center">
                        {{-- Delete --}}
                        <form action="{{ route('programs.tasks.destroy', [$program, $task]) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm px-3 py-1 rounded bg-red-600 hover:bg-red-700 text-white transition" title="Delete Task">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
