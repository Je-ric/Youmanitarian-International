<!-- Role Assignment Modal -->
<dialog id="assignRolesModal_{{ $user->id }}" class="modal">
    <div class="modal-box max-w-2xl w-full p-0 rounded-lg bg-white">
        
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        @if($user->profile_pic)
                            <img class="w-10 h-10 rounded-full object-cover border-2 border-white" 
                                 src="{{ $user->profile_pic }}" 
                                 alt="{{ $user->name }}">
                        @else
                            <div class="w-10 h-10 rounded-full bg-[#1a2235] flex items-center justify-center">
                                <span class="text-white font-medium text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Header Text -->
                    <div>
                        <h3 class="text-lg font-semibold text-[#1a2235] flex items-center">
                            <i class='bx bx-user-check mr-2 text-[#ffb51b]'></i>
                            Assign Roles
                        </h3>
                        <p class="text-sm text-gray-600">{{ $user->name }}</p>
                    </div>
                </div>
                
                <!-- Close Button -->
                <button 
                    type="button"
                    onclick="document.getElementById('assignRolesModal_{{ $user->id }}').close()" 
                    class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <form method="POST" action="{{ route('roles.assign') }}" id="roleForm_{{ $user->id }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                
                <!-- Current Roles Section -->
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class='bx bx-shield-check mr-2 text-[#ffb51b]'></i>
                        Current Roles
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @forelse($user->roles as $role)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#1a2235] text-white">
                                <i class='bx bx-check-circle mr-1 text-xs'></i>
                                {{ $role->role_name }}
                            </span>
                        @empty
                            <div class="flex items-center text-gray-500 text-sm bg-gray-50 px-3 py-2 rounded-lg">
                                <i class='bx bx-info-circle mr-2'></i>
                                No roles assigned
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-6"></div>

                <!-- Base Role Section -->
                <div class="mb-6">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class='bx bx-user text-green-600'></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-green-800">Volunteer</h4>
                                    <p class="text-xs text-green-600">Base role for all users</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                <i class='bx bx-lock-alt mr-1'></i>
                                Default
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Additional Roles Section -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                        <i class='bx bx-user-plus mr-2 text-[#ffb51b]'></i>
                        Additional Roles
                    </h4>
                    
                    @php
                        $additionalRoles = $roles->where('role_name', '!=', 'Volunteer');
                    @endphp
                    
                    @if($additionalRoles->isEmpty())
                        <div class="text-center py-8">
                            <i class='bx bx-user-x text-3xl text-gray-300 mb-2'></i>
                            <p class="text-gray-500 text-sm">No additional roles available</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($additionalRoles as $role)
                                <label for="role_{{ $user->id }}_{{ $role->id }}" 
                                       class="relative flex items-start p-4 bg-white border border-gray-200 rounded-lg hover:border-[#ffb51b] hover:bg-gray-50 transition-all duration-200 cursor-pointer group">
                                    
                                    <!-- Checkbox -->
                                    <div class="flex items-center h-5">
                                        <input 
                                            type="checkbox" 
                                            name="roles[]" 
                                            value="{{ $role->id }}" 
                                            id="role_{{ $user->id }}_{{ $role->id }}"
                                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                            class="w-4 h-4 text-[#ffb51b] bg-white border-gray-300 rounded focus:ring-[#ffb51b] focus:ring-2 transition-colors">
                                    </div>
                                    
                                    <!-- Role Info -->
                                    <div class="ml-3 flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            @php
                                                $roleIcon = match(strtolower($role->role_name)) {
                                                    'admin' => 'bx-crown',
                                                    'program coordinator' => 'bx-user-voice',
                                                    'coordinator' => 'bx-user-voice',
                                                    'manager' => 'bx-briefcase',
                                                    default => 'bx-user-circle'
                                                };
                                            @endphp
                                            <i class='bx {{ $roleIcon }} text-[#ffb51b] group-hover:text-[#e6a319] transition-colors'></i>
                                            <span class="text-sm font-medium text-gray-900 group-hover:text-[#1a2235]">
                                                {{ $role->role_name }}
                                            </span>
                                        </div>
                                        @if($role->description)
                                            <p class="mt-1 text-xs text-gray-500 leading-relaxed">
                                                {{ $role->description }}
                                            </p>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                <button 
                    type="button" 
                    onclick="document.getElementById('assignRolesModal_{{ $user->id }}').close()"
                    class="w-full sm:w-auto px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    <i class='bx bx-x mr-2'></i>
                    Cancel
                </button>
                <button 
                    type="submit" 
                    form="roleForm_{{ $user->id }}"
                    class="w-full sm:w-auto px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors font-medium">
                    <i class='bx bx-save mr-2'></i>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</dialog>
