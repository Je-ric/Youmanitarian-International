<div class="space-y-6">
    
    <div class="relative bg-gradient-to-br from-white via-slate-50 to-gray-50 rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ffb51b]/10 to-[#1a2235]/5 rounded-full -translate-y-16 translate-x-16"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-[#1a2235]/5 to-[#ffb51b]/10 rounded-full translate-y-12 -translate-x-12"></div>
        
        <div class="relative p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                    
                    <div class="relative">
                        @php
                            $userModel = $volunteer->user;
                            $profilePic = $userModel->profile_pic; // stored as 'storage/uploads/profile_photo/...' or external URL
                            $legacyPic = $userModel->profile_photo_path; // jetstream style (optional)
                        @endphp

                        @if($profilePic)
                            <img src="{{ asset($profilePic) }}"
                                 alt="Profile Photo"
                                 class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-lg">
                        @elseif($legacyPic)
                            <img src="{{ asset('storage/' . $legacyPic) }}"
                                 alt="Profile Photo"
                                 class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-lg">
                        @else
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-[#ffb51b] to-[#e6a017] flex items-center justify-center border-4 border-white shadow-lg">
                                <i class='bx bx-user text-white text-3xl sm:text-4xl'></i>
                            </div>
                        @endif

                        @if(Auth::id() === $userModel->id)
                            <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data"
                                  class="absolute -bottom-2 -right-2">
                                @csrf
                                <input
                                    id="profilePicInput-{{ $volunteer->id }}"
                                    type="file"
                                    name="profile_pic"
                                    accept="image/*"
                                    class="hidden"
                                    onchange="this.form.submit();">
                                <button type="button"
                                        onclick="document.getElementById('profilePicInput-{{ $volunteer->id }}').click();"
                                        class="w-9 h-9 rounded-xl bg-white border border-gray-200 shadow flex items-center justify-center text-gray-600 hover:text-[#1a2235] hover:border-[#1a2235] transition"
                                        title="Change Photo">
                                    <i class='bx bx-camera text-lg'></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    
                    <div class="space-y-2">
                        <h1 class="text-2xl sm:text-3xl font-bold text-[#1a2235] tracking-tight">{{ $volunteer->user->name }}</h1>
                        <p class="text-gray-600 text-sm sm:text-base">{{ $volunteer->user->email }}</p>
                    </div>
                </div>
                
                
                <div class="flex flex-col items-start sm:items-end gap-3">
                    
                    <x-feedback-status.status-indicator 
                        :status="$volunteer->application_status" 
                        :label="ucfirst($volunteer->application_status)" />
                    
                
                    <div class="flex gap-4 text-center">
                        <div class="text-center">
                            <div class="text-lg sm:text-xl font-bold text-[#1a2235]">{{ $volunteer->calculated_total_hours }}</div>
                            <div class="text-xs text-gray-500">Hours</div>
                        </div>
                        {{-- what if pc? 
                            --}}
                        <div class="text-center">
                            <div class="text-lg sm:text-xl font-bold text-[#1a2235]">{{ $volunteer->attendanceLogs->count() }}</div>
                            <div class="text-xs text-gray-500">Programs</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- User Information --}}
        <x-overview.card title="User Information" icon="bx-user-circle" variant="default">
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Full Name</span>
                        <span class="text-gray-900 font-medium">{{ $volunteer->user->name }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Email Address</span>
                        <span class="text-gray-900 text-sm">{{ $volunteer->user->email }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Email Verified</span>
                        <span class="text-sm">
                            @if($volunteer->user->email_verified_at)
                                <x-feedback-status.status-indicator status="verified" label="Verified" />
                            @else
                                <x-feedback-status.status-indicator status="not_verified" label="Not Verified" />
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Account Created</span>
                        <span class="text-gray-900 text-sm">{{ $volunteer->user->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Google Account</span>
                        <span class="text-sm">
                            @if($volunteer->user->google_id)
                                <x-feedback-status.status-indicator status="connected" label="Connected" />
                            @else
                                <x-feedback-status.status-indicator status="not_connected" label="Not Connected" />
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </x-overview.card>

        {{-- Volunteer Information --}}
        <x-overview.card title="Volunteer Information" icon="bx-heart" variant="gradient">
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Application Status</span>
                        <x-feedback-status.status-indicator 
                            :status="$volunteer->application_status" 
                            :label="ucfirst($volunteer->application_status)" />
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Total Hours</span>
                        <span class="text-gray-900 font-bold text-lg">{{ $volunteer->calculated_total_hours }}h</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Joined Date</span>
                        <span class="text-gray-900 text-sm">
                            @if($volunteer->joined_at)
                                {{ \Carbon\Carbon::parse($volunteer->joined_at)->format('M d, Y') }}
                            @else
                                <span class="text-gray-500">Not specified</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700 text-sm">Volunteer Since</span>
                        <span class="text-gray-900 text-sm">{{ $volunteer->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-3">
                        <span class="font-medium text-gray-700 text-sm">User Roles</span>
                        <div class="flex flex-wrap gap-2">
                            @if($volunteer->user->roles && $volunteer->user->roles->count() > 0)
                                @foreach($volunteer->user->roles as $role)
                                    @php
                                        $variant = match($role->role_name) {
                                            'Volunteer' => 'volunteer',
                                            'Admin' => 'admin',
                                            'Program Coordinator' => 'program-coordinator',
                                            'Financial Coordinator' => 'financial-coordinator',
                                            'Content Manager' => 'content-manager',
                                            'Member' => 'member',
                                            default => 'role'
                                        };
                                    @endphp
                                    <x-feedback-status.status-indicator 
                                        :label="$role->role_name" 
                                        :status="$variant" />
                                @endforeach
                            @else
                                <span class="text-gray-500 text-sm">No roles assigned</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </x-overview.card>
    </div>

    {{-- Member Information - Only if volunteer is a member --}}
    @if($volunteer->member)
        <x-overview.card title="Member Information" icon="bx-crown" variant="bordered">
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    
                    <div class="space-y-4">
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Membership Type</span>
                            <x-feedback-status.status-indicator 
                                :status="$volunteer->member->membership_type === 'full_pledge' ? 'success' : 'info'" 
                                :label="ucwords(str_replace('_', ' ', $volunteer->member->membership_type))" />
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Membership Status</span>
                            <x-feedback-status.status-indicator 
                                :status="$volunteer->member->membership_status" 
                                :label="ucfirst($volunteer->member->membership_status)" />
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Invitation Status</span>
                            <x-feedback-status.status-indicator 
                                :status="$volunteer->member->invitation_status" 
                                :label="ucfirst($volunteer->member->invitation_status)" />
                        </div>
                    </div>

                    <div class="space-y-4">

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Start Date</span>
                            <span class="text-gray-900 text-sm">
                                @if($volunteer->member->start_date)
                                    {{ \Carbon\Carbon::parse($volunteer->member->start_date)->format('M d, Y') }}
                                @else
                                    <span class="text-gray-500">Not specified</span>
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Invited At</span>
                            <span class="text-gray-900 text-sm">
                                @if($volunteer->member->invited_at)
                                    {{ \Carbon\Carbon::parse($volunteer->member->invited_at)->format('M d, Y') }}
                                @else
                                    <span class="text-gray-500">Not specified</span>
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700 text-sm">Invited By</span>
                            <span class="text-gray-900 text-sm">
                                @if($volunteer->member->invited_by)
                                    {{ \App\Models\User::find($volunteer->member->invited_by)->name ?? 'Unknown' }}
                                @else
                                    <span class="text-gray-500">Not specified</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Payment Summary - Only if member has payments --}}
                @if($volunteer->member->payments && $volunteer->member->payments->count() > 0)
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-[#1a2235] mb-4 flex items-center">
                            <i class='bx bx-credit-card text-purple-600 mr-2'></i>
                            Payment Summary
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            
                            <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-4 rounded-xl border border-emerald-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-emerald-700 font-medium">Total Payments</div>
                                        <div class="text-2xl font-bold text-emerald-800">{{ $volunteer->member->payments->count() }}</div>
                                    </div>
                                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-receipt text-emerald-600'></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-blue-700 font-medium">Total Amount</div>
                                        <div class="text-2xl font-bold text-blue-800">₱{{ number_format($volunteer->member->payments->sum('amount'), 2) }}</div>
                                    </div>
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-money text-blue-600'></i>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-purple-50 to-violet-50 p-4 rounded-xl border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-sm text-purple-700 font-medium">Latest Payment</div>
                                        @php
                                            $latestPayment = $volunteer->member->payments->sortByDesc('payment_date')->first();
                                        @endphp
                                        <div class="text-sm font-bold text-purple-800">
                                            @if($latestPayment)
                                                {{ \Carbon\Carbon::parse($latestPayment->payment_date)->format('M d, Y') }}
                                            @else
                                                <span class="text-gray-500">None</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-calendar text-purple-600'></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </x-overview.card>
    @endif
</div>