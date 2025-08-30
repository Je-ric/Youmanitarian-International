<x-modal.dialog :id="$modalId" maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <h2 id="delete-task-title-{{ $task->id }}" class="text-lg sm:text-xl font-bold text-red-600 flex items-center gap-2">
            <i class='bx bx-trash'></i> Delete Task
        </h2>
    </x-modal.header>
    <x-modal.body>
        <div class="flex flex-col items-center text-center gap-3 max-w-md mx-auto w-full">
            <div class="bg-red-100 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2">
                <i class='bx bx-error text-2xl sm:text-3xl text-red-500'></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-red-700">
                Are you sure you want to delete this task?
            </h3>
            <p class="text-gray-600 text-xs sm:text-sm">
                This action cannot be undone.
            </p>

            <!-- Centered box -->
            <div class="bg-gray-50 rounded p-2 mt-2 text-center max-w-sm w-full">
                <span class="font-semibold text-gray-800 text-xs sm:text-sm">
                    {{ Str::limit($task->task_description, 120) }}
                </span>
            </div>
        </div>
    </x-modal.body>
    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="$modalId" text="Cancel" />
            <form action="{{ route('programs.tasks.destroy', [$program, $task]) }}"
                    method="POST"
                    class="inline-flex"
                    data-ajax="delete-task"
                    data-modal-id="{{ $modalId }}">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger" class="w-full sm:w-auto">
                    <i class='bx bx-trash'></i> Delete
                </x-button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog>
