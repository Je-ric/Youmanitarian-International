@extends('layouts.sidebar_final')

@section('content')
    <x-page-header 
        icon="bx-user"
        title="Volunteer Details"
        desc="Complete information about {{ $volunteer->user->name }}">
    </x-page-header>

    <div x-data="{
        openModal(id) {
            document.getElementById('modal_' + id).showModal();
        }
    }">

    <x-navigation-layout.tabs-modern 
        :tabs="[
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-user-circle'],
            ['id' => 'application', 'label' => 'Application Details', 'icon' => 'bx-file-text'],
            ['id' => 'programs', 'label' => 'Programs & Attendance', 'icon' => 'bx-calendar']
        ]" 
        defaultTab="overview"
        :preserveState="false"
        class="mb-6">

        <!-- Overview Tab -->
        <x-slot name="slot_overview">
            <div class="space-y-6">
                
                <!-- Profile Header Card -->
                <div class="relative bg-gradient-to-br from-white via-slate-50 to-gray-50 rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <!-- Decorative Background -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[#ffb51b]/10 to-[#1a2235]/5 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-[#1a2235]/5 to-[#ffb51b]/10 rounded-full translate-y-12 -translate-x-12"></div>
                    
                    <div class="relative p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                                <!-- Profile Photo -->
                                <div class="relative">
                                    @if($volunteer->user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $volunteer->user->profile_photo_path) }}"
                                             alt="Profile Photo"
                                             class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-lg">
                                    @elseif($volunteer->user->profile_pic)
                                        <img src="{{ $volunteer->user->profile_pic }}"
                                             alt="Profile Photo"
                                             class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-4 border-white shadow-lg">
                                    @else
                                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-[#ffb51b] to-[#e6a017] flex items-center justify-center border-4 border-white shadow-lg">
                                            <i class='bx bx-user text-white text-3xl sm:text-4xl'></i>
                                        </div>
                                    @endif
                                    {{-- <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-md">
                                        <div class="w-3 h-3 rounded-full 
                                            @if($volunteer->application_status === 'approved') bg-emerald-500
                                            @elseif($volunteer->application_status === 'denied') bg-red-500
                                            @else bg-amber-500 @endif">
                                        </div>
                                    </div> --}}
                                </div>
                                
                                <!-- Profile Info -->
                                <div class="space-y-2">
                                    <h1 class="text-2xl sm:text-3xl font-bold text-[#1a2235] tracking-tight">{{ $volunteer->user->name }}</h1>
                                    <p class="text-gray-600 text-sm sm:text-base">{{ $volunteer->user->email }}</p>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            <div class="flex flex-col items-start sm:items-end gap-3">
                                <x-feedback-status.status-indicator 
                                    :status="$volunteer->application_status" 
                                    :label="ucfirst($volunteer->application_status)" />
                                
                                <!-- Quick Stats -->
                                <div class="flex gap-4 text-center">
                                    <div class="text-center">
                                        <div class="text-lg sm:text-xl font-bold text-[#1a2235]">{{ $volunteer->calculated_total_hours }}</div>
                                        <div class="text-xs text-gray-500">Hours</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg sm:text-xl font-bold text-[#1a2235]">{{ $volunteer->attendanceLogs->count() }}</div>
                                        <div class="text-xs text-gray-500">Programs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                                    <!-- User Information Card -->
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

                    <!-- Volunteer Information Card -->
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

                <!-- Member Information Card -->
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

                            <!-- Payment Summary -->
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
        </x-slot>

        <!-- Application Details Tab -->
        <x-slot name="slot_application">
            @if ($volunteer->application)
                <x-overview.card title="Application Form Details" icon="bx-file-text" variant="default">
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Why Volunteer:</label>
                                    <p class="text-gray-700 leading-relaxed">{{ $volunteer->application->why_volunteer ?? 'Not specified' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Interested Programs:</label>
                                    <p class="text-gray-700 leading-relaxed">{{ $volunteer->application->interested_programs ?? 'Not specified' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Skills & Experience:</label>
                                    <p class="text-gray-700 leading-relaxed">{{ $volunteer->application->skills_experience ?? 'Not specified' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Availability:</label>
                                    <p class="text-gray-700 leading-relaxed">{{ $volunteer->application->availability ?? 'Not specified' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Commitment Hours:</label>
                                    <p class="text-gray-700 leading-relaxed">{{ $volunteer->application->commitment_hours ?? 'Not specified' }}</p>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Physical Limitations:</label>
                                    <p class="text-gray-700 leading-relaxed">{{ $volunteer->application->physical_limitations ?? 'None specified' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Emergency Contact:</label>
                                    <p class="text-gray-700 leading-relaxed">{{ $volunteer->application->emergency_contact ?? 'Not specified' }}</p>
                                </div>
                                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-4 border border-gray-200">
                                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Short Bio:</label>
                                    <p class="text-gray-700 leading-relaxed">{{ $volunteer->application->short_bio ?? 'Not specified' }}</p>
                                </div>
                                
                                <!-- Quick Info Cards -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200 text-center">
                                        <div class="text-sm font-medium text-blue-700 mb-1">Contact Consent</div>
                                        <x-feedback-status.status-indicator 
                                            :status="$volunteer->application->contact_consent === 'yes' ? 'success' : 'danger'" 
                                            :label="ucfirst($volunteer->application->contact_consent)" />
                                    </div>
                                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200 text-center">
                                        <div class="text-sm font-medium text-green-700 mb-1">Volunteered Before</div>
                                        <x-feedback-status.status-indicator 
                                            :status="$volunteer->application->volunteered_before === 'yes' ? 'success' : 'neutral'" 
                                            :label="ucfirst($volunteer->application->volunteered_before)" />
                                    </div>
                                    <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl p-4 border border-amber-200 text-center col-span-2">
                                        <div class="text-sm font-medium text-amber-700 mb-1">Outdoor Activities OK</div>
                                        <x-feedback-status.status-indicator 
                                            :status="$volunteer->application->outdoor_ok === 'yes' ? 'success' : ($volunteer->application->outdoor_ok === 'depends' ? 'warning' : 'danger')" 
                                            :label="ucfirst($volunteer->application->outdoor_ok)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Application Status Footer -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-600">Application Status:</span>
                                    <x-feedback-status.status-indicator 
                                        :status="$volunteer->application->is_active ? 'success' : 'danger'" 
                                        :label="$volunteer->application->is_active ? 'Active' : 'Inactive'" />
                                </div>
                                <div class="flex items-center gap-2 text-gray-500">
                                    <i class='bx bx-calendar'></i>
                                    <span>Submitted: {{ $volunteer->application->submitted_at ? \Carbon\Carbon::parse($volunteer->application->submitted_at)->format('M d, Y') : 'Not specified' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-overview.card>
            @else
                <x-overview.card title="Application Form Details" icon="bx-file-text" variant="default">
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-file-text text-gray-400 text-2xl'></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No Application Data</h3>
                        <p class="text-gray-500">This volunteer hasn't submitted an application form yet.</p>
                    </div>
                </x-overview.card>
            @endif
        </x-slot>

        <!-- Programs & Attendance Tab -->
        <x-slot name="slot_programs">
                    <div class="p-6">
                        <h1>Programs Participated?</h1>
                        @if ($volunteer->programs->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach ($volunteer->programs as $program)
                                    @php
                                        // Get attendance record for this program
                                        $attendance = $volunteer->attendanceLogs->where('program_id', $program->id)->first();
                                        $hasAttendance = $attendance !== null;
                                    @endphp
                                    
                                    <div class="bg-gradient-to-br from-white to-slate-50 border border-gray-200 rounded-xl p-5 hover:shadow-lg transition-all duration-200">
                                        <!-- Program Header -->
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-semibold text-[#1a2235] truncate">
                                                    {{ $program->title }}
                                                </h3>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <x-feedback-status.status-indicator 
                                                        :status="$program->progress_status" 
                                                        :label="ucfirst($program->progress_status)" />
                                                    @if($hasAttendance)
                                                        <x-feedback-status.status-indicator 
                                                            :status="$attendance->approval_status" 
                                                            :label="ucfirst($attendance->approval_status)" />
                                                    @else
                                                        <x-feedback-status.status-indicator 
                                                            status="no_record" 
                                                            label="No Attendance" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Program Details -->
                                        <div class="space-y-3 mb-4">
                                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                                <span class="text-sm font-medium text-gray-600">Date</span>
                                                <span class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($program->date)->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                                <span class="text-sm font-medium text-gray-600">Time</span>
                                                <span class="text-sm text-gray-900 font-medium">
                                                    {{ \Carbon\Carbon::parse($program->start_time)->format('h:i A') }}
                                                    @if($program->end_time)
                                                        - {{ \Carbon\Carbon::parse($program->end_time)->format('h:i A') }}
                                                    @endif
                                                </span>
                                            </div>
                                            @if($hasAttendance)
                                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                                    <span class="text-sm font-medium text-gray-600">Time In</span>
                                                    <span class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($attendance->clock_in)->format('h:i A') }}</span>
                                                </div>
                                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                                    <span class="text-sm font-medium text-gray-600">Time Out</span>
                                                    @if ($attendance->clock_out)
                                                        <span class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($attendance->clock_out)->format('h:i A') }}</span>
                                                    @else
                                                        <span class="text-sm text-amber-600 font-medium">Still Clocked In</span>
                                                    @endif
                                                </div>
                                                <div class="flex justify-between items-center py-2">
                                                    <span class="text-sm font-medium text-gray-600">Total Hours</span>
                                                    @if ($attendance->clock_out)
                                                        @php
                                                            $diff = \Carbon\Carbon::parse($attendance->clock_in)->diff(\Carbon\Carbon::parse($attendance->clock_out));
                                                        @endphp
                                                        <span class="text-sm font-bold text-[#1a2235]">{{ $diff->h }}h {{ $diff->i }}m</span>
                                                    @else
                                                        <span class="text-sm text-amber-600 font-medium">Ongoing</span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="bg-amber-50 rounded-lg p-3 mt-3">
                                                    <div class="flex items-center gap-2">
                                                        <i class='bx bx-time text-amber-500'></i>
                                                        <span class="text-sm text-amber-700 font-medium">No attendance record yet</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>



                                        <!-- Action Buttons -->
                                        <div class="flex gap-2">
                                            <button
                                                @click="openModal({{ $program->id }})"
                                                class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <i class='bx bx-show mr-1'></i>
                                                View Details
                                            </button>
                                            @if($hasAttendance)
                                                <button
                                                    onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}_{{ $program->id }}').showModal()"
                                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                    <i class='bx bx-clipboard-check mr-1'></i>
                                                    Review
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class='bx bx-calendar text-gray-400 text-2xl'></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">No Programs Joined</h3>
                                <p class="text-gray-500">This volunteer hasn't joined any programs yet.</p>
                            </div>
                        @endif
                    </div>

                <!-- Program Modals -->
                @foreach ($volunteer->programs as $program)
                    @include('programs.modals.program-modal', ['program' => $program])
                @endforeach

                <!-- Attendance Approval Modals -->
                @foreach ($volunteer->attendanceLogs as $log)
                    @if($log->program)
                        @php
                            $programLogs = $volunteer->attendanceLogs->where('program_id', $log->program->id);
                        @endphp
                        @include('programs_volunteers.modals.attendanceApproval', [
                            'volunteer' => $volunteer, 
                            'volunteerLogs' => $programLogs,
                            'program' => $log->program,
                            'readOnly' => true,
                            'modalId' => 'attendanceModal_' . $volunteer->id . '_' . $log->program->id
                        ])
                    @endif
                @endforeach
        </x-slot>
    </x-navigation-layout.tabs-modern>
    </div>
    </div>
@endsection
