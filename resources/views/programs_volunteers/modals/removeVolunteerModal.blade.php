<x-modal.dialog
    :id="$modalId"
    maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs"
    width="w-full"
    maxHeight="max-h-[90vh]"
>
    <x-modal.header>
        <h2 id="remove-volunteer-title-{{ $task->id }}-{{ $assignment->id }}"
            class="text-lg sm:text-xl font-bold text-red-600 flex items-center gap-2">
            <i class='bx bx-user-x'></i> Remove Volunteer
        </h2>
    </x-modal.header>

    <x-modal.body>
        <div class="flex flex-col items-center text-center gap-3">
            <div class="bg-red-100 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2">
                <i class='bx bx-x text-2xl sm:text-3xl text-red-500'></i>
            </div>

            <h3 class="text-base text-center sm:text-lg font-semibold text-red-700">
                Remove <span class="text-gray-900">{{ $assignment->volunteer->user->name }}</span>
                from task <span class="text-gray-900">“{{ Str::limit($task->task_description, 80) }}”</span>?
            </h3>

            <p class="text-gray-600 text-xs sm:text-sm">
                This volunteer will no longer be assigned to this task.
            </p>
        </div>
    </x-modal.body>

    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="$modalId" text="Cancel" />

            <form
                action="{{ route('programs.tasks.assignments.destroy', [$program, $task, $assignment]) }}"
                method="POST"
                class="inline-flex"
                data-ajax="delete-assignment"
                data-modal-id="{{ $modalId }}"
            >
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger" class="w-full sm:w-auto">
                    <i class='bx bx-x'></i> Remove
                </x-button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog>
