<div class="mt-8">
    <h2 class="text-2xl font-bold text-[#1a2235] mb-2 flex items-center gap-2">
        <i class="bx bx-list-check text-2xl text-indigo-600"></i>
        Your Assigned Tasks
    </h2>
    @if($volunteerTasks->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($taskData as $data)
                <div class="bg-white/80 border border-indigo-100 rounded-xl hover:border-indigo-200 transition-all duration-200 shadow-lg hover:shadow-sm overflow-hidden backdrop-blur-sm" data-animate>
                    <div class="p-5 border-b border-slate-600 bg-gradient-to-br from-gray-900 via-slate-800 to-indigo-900">
                        <div class="flex items-center justify-between mb-3">
                            <x-feedback-status.status-indicator :status="$data['assignment']->status"
                                :label="ucwords(str_replace('_', ' ', $data['assignment']->status))" />
                        </div>
                        <p class="text-slate-100 text-sm leading-relaxed font-medium"
                           style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $data['task']->task_description }}
                        </p>
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <form
                            action="{{ route('programs.tasks.assignments.update-status', [$program, $data['task'], $data['assignment']]) }}"
                            method="POST" class="inline-flex w-full">
                            @csrf
                            @method('PUT')
                            <div class="w-full">
                                <select name="status" onchange="this.form.submit()"
                                    class="w-full text-sm border border-gray-300 rounded px-3 py-2 focus:ring-1 focus:ring-[#ffb51b] focus:border-[#ffb51b] bg-white"
                                    @if($data['assignment']->status === 'completed') disabled @endif>
                                    <option value="pending" {{ $data['assignment']->status === 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="in_progress" {{ $data['assignment']->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $data['assignment']->status === 'completed' ? 'selected' : '' }} disabled>Completed (Program Coordinator Only)</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Note: Only program coordinators can mark tasks as
                                    complete</p>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <x-empty-state icon="bx bx-task" title="No Tasks Assigned"
            description="You have not been assigned any tasks for this program yet. Please check back later." />
    @endif
</div>