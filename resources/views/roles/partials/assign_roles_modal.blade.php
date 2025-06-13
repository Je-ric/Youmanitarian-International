<!-- Role Assignment Modal -->
<dialog id="assignRolesModal_{{ $user->id }}" class="modal backdrop:bg-black/50">
    <div class="modal-box w-11/12 max-w-2xl p-0 overflow-hidden rounded-xl bg-white border border-slate-200 shadow-xl">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        @if($user->profile_pic)
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $user->profile_pic }}" alt="{{ $user->name }}">
                        @else
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-800 font-medium">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Assign Roles
                        </h3>
                        <p class="text-sm text-gray-500">{{ $user->name }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('assignRolesModal_{{ $user->id }}').close()" 
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form method="POST" action="{{ route('roles.assign') }}" class="p-6">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            
            <!-- Current Roles Section -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Current Roles</h4>
                <div class="flex flex-wrap gap-2">
                    @forelse($user->roles as $role)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            {{ $role->role_name }}
                        </span>
                    @empty
                        <span class="text-gray-500 text-sm">No roles assigned</span>
                    @endforelse
                </div>
            </div>

            <!-- Volunteer Role Section (Always Visible, Non-editable) -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <i class='bx bx-user-check text-green-600'></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Volunteer</h4>
                            <p class="text-xs text-gray-500">Base role for all volunteers</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class='bx bx-lock-alt mr-1'></i>
                            Always Assigned
                        </span>
                    </div>
                </div>
            </div>

            <!-- Additional Roles Section -->
            <div>
                <h4 class="text-sm font-medium text-gray-700 mb-3">Additional Roles</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($roles->where('role_name', '!=', 'Volunteer') as $role)
                        <div class="relative flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-indigo-300 transition-colors duration-200">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                           id="role_{{ $user->id }}_{{ $role->id }}"
                                           {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition-colors duration-200">
                                    <label for="role_{{ $user->id }}_{{ $role->id }}" 
                                           class="ml-3 block text-sm font-medium text-gray-900">
                                        {{ $role->role_name }}
                                    </label>
                                </div>
                                @if($role->description)
                                    <p class="mt-1 text-xs text-gray-500">{{ $role->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                <button type="button" 
                        onclick="document.getElementById('assignRolesModal_{{ $user->id }}').close()"
                        class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <i class='bx bx-save mr-2'></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<style>
    /* Modal Animation */
    .modal {
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Custom Scrollbar for Role List */
    .modal-box {
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-box::-webkit-scrollbar {
        width: 8px;
    }

    .modal-box::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .modal-box::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .modal-box::-webkit-scrollbar-thumb:hover {
        background: #666;
    }

    /* Checkbox Animation */
    input[type="checkbox"] {
        transition: all 0.2s ease-in-out;
    }

    input[type="checkbox"]:checked {
        animation: checkboxPop 0.2s ease-in-out;
    }

    @keyframes checkboxPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
</style> 