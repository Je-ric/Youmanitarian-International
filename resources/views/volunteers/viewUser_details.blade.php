@extends('layouts.sidebar_final')

@section('content')
    <x-page-header 
        icon="bx-user" 
        title="Volunteer Details"
        desc="Complete information about {{ $volunteer->user->name }}">
    </x-page-header>

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
                <!-- Profile Header -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            @if($volunteer->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $volunteer->user->profile_photo_path) }}" 
                                     alt="Profile Photo" 
                                     class="w-16 h-16 rounded-full object-cover border-2 border-[#ffb51b]">
                            @elseif($volunteer->user->profile_pic)
                                <img src="{{ $volunteer->user->profile_pic }}" 
                                     alt="Profile Photo" 
                                     class="w-16 h-16 rounded-full object-cover border-2 border-[#ffb51b]">
                            @else
                                <div class="w-16 h-16 rounded-full bg-[#ffb51b] flex items-center justify-center">
                                    <i class='bx bx-user text-white text-2xl'></i>
                                </div>
                            @endif
                            <div>
                                <h1 class="text-3xl font-bold text-[#1a2235]">{{ $volunteer->user->name }}</h1>
                                <p class="text-gray-600">{{ $volunteer->user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($volunteer->application_status === 'approved') bg-green-100 text-green-800
                                @elseif($volunteer->application_status === 'denied') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($volunteer->application_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- User Information -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-[#1a2235] mb-4 flex items-center">
                        <i class='bx bx-user-circle text-[#ffb51b] mr-2'></i>
                        User Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Full Name:</span>
                                <span class="text-gray-900">{{ $volunteer->user->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Email Address:</span>
                                <span class="text-gray-900">{{ $volunteer->user->email }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Email Verified:</span>
                                <span class="text-gray-900">
                                    @if($volunteer->user->email_verified_at)
                                        <span class="text-green-600">✓ Verified</span>
                                    @else
                                        <span class="text-red-600">✗ Not Verified</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Account Created:</span>
                                <span class="text-gray-900">{{ $volunteer->user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Last Updated:</span>
                                <span class="text-gray-900">{{ $volunteer->user->updated_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Google Account:</span>
                                <span class="text-gray-900">
                                    @if($volunteer->user->google_id)
                                        <span class="text-green-600">✓ Connected</span>
                                    @else
                                        <span class="text-gray-500">✗ Not Connected</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Volunteer Information -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-[#1a2235] mb-4 flex items-center">
                        <i class='bx bx-heart text-[#ffb51b] mr-2'></i>
                        Volunteer Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Application Status:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($volunteer->application_status === 'approved') bg-green-100 text-green-800
                                    @elseif($volunteer->application_status === 'denied') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($volunteer->application_status) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Total Hours:</span>
                                <span class="text-gray-900 font-semibold">{{ $volunteer->total_hours }} hours</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Joined Date:</span>
                                <span class="text-gray-900">
                                    @if($volunteer->joined_at)
                                        {{ \Carbon\Carbon::parse($volunteer->joined_at)->format('M d, Y') }}
                                    @else
                                        <span class="text-gray-500">Not specified</span>
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium text-gray-700">Volunteer Since:</span>
                                <span class="text-gray-900">{{ $volunteer->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
            </div>
        </div>

                <!-- User Roles -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-[#1a2235] mb-4 flex items-center">
                        <i class='bx bx-shield text-[#ffb51b] mr-2'></i>
                        User Roles
                    </h2>
                    @if($volunteer->user->roles && $volunteer->user->roles->count() > 0)
                        <div class="space-y-3">
                            @foreach($volunteer->user->roles as $role)
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-700">{{ $role->name }}:</span>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Active
                                        </span>
                                        @if($role->pivot->assigned_by)
                                            <p class="text-xs text-gray-500 mt-1">
                                                Assigned by: {{ \App\Models\User::find($role->pivot->assigned_by)->name ?? 'Unknown' }}
                                            </p>
                                        @endif
                                        <p class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($role->pivot->assigned_at)->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No roles assigned.</p>
                    @endif
                </div>

                <!-- Member Information -->
                @if($volunteer->member)
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-[#1a2235] mb-4 flex items-center">
                            <i class='bx bx-crown text-[#ffb51b] mr-2'></i>
                            Member Information
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-700">Membership Type:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($volunteer->member->membership_type === 'full_pledge') bg-blue-100 text-blue-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ ucwords(str_replace('_', ' ', $volunteer->member->membership_type)) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-700">Membership Status:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($volunteer->member->membership_status === 'active') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($volunteer->member->membership_status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-700">Invitation Status:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($volunteer->member->invitation_status === 'accepted') bg-green-100 text-green-800
                                        @elseif($volunteer->member->invitation_status === 'declined') bg-red-100 text-red-600
                                        @else bg-yellow-100 text-yellow-600 @endif">
                                        {{ ucfirst($volunteer->member->invitation_status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-700">Start Date:</span>
                                    <span class="text-gray-900">
                                        @if($volunteer->member->start_date)
                                            {{ \Carbon\Carbon::parse($volunteer->member->start_date)->format('M d, Y') }}
                                        @else
                                            <span class="text-gray-500">Not specified</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-700">Invited At:</span>
                                    <span class="text-gray-900">
                                        @if($volunteer->member->invited_at)
                                            {{ \Carbon\Carbon::parse($volunteer->member->invited_at)->format('M d, Y') }}
                                        @else
                                            <span class="text-gray-500">Not specified</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="font-medium text-gray-700">Invited By:</span>
                                    <span class="text-gray-900">
                                        @if($volunteer->member->invited_by)
                                            {{ \App\Models\User::find($volunteer->member->invited_by)->name ?? 'Unknown' }}
                                        @else
                                            <span class="text-gray-500">Not specified</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Membership Payment Summary -->
                        @if($volunteer->member->payments && $volunteer->member->payments->count() > 0)
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <h3 class="text-lg font-semibold text-[#1a2235] mb-3">Payment Summary</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <div class="text-sm text-gray-600">Total Payments</div>
                                        <div class="text-xl font-bold text-[#1a2235]">{{ $volunteer->member->payments->count() }}</div>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <div class="text-sm text-gray-600">Total Amount</div>
                                        <div class="text-xl font-bold text-[#1a2235]">₱{{ number_format($volunteer->member->payments->sum('amount'), 2) }}</div>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <div class="text-sm text-gray-600">Latest Payment</div>
                                        <div class="text-sm font-medium text-[#1a2235]">
                                            @php
                                                $latestPayment = $volunteer->member->payments->sortByDesc('payment_date')->first();
                                            @endphp
                                            @if($latestPayment)
                                                {{ \Carbon\Carbon::parse($latestPayment->payment_date)->format('M d, Y') }}
                                            @else
                                                <span class="text-gray-500">None</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </x-slot>

        <!-- Application Details Tab -->
        <x-slot name="slot_application">
            @if ($volunteer->application)
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-[#1a2235] mb-4 flex items-center">
                        <i class='bx bx-file-text text-[#ffb51b] mr-2'></i>
                        Application Form Details
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Why Volunteer:</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $volunteer->application->why_volunteer ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Interested Programs:</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $volunteer->application->interested_programs ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Skills & Experience:</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $volunteer->application->skills_experience ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Availability:</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $volunteer->application->availability ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Commitment Hours:</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $volunteer->application->commitment_hours ?? 'Not specified' }}</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Physical Limitations:</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $volunteer->application->physical_limitations ?? 'None specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact:</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $volunteer->application->emergency_contact ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Consent:</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($volunteer->application->contact_consent === 'yes') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($volunteer->application->contact_consent) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Volunteered Before:</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($volunteer->application->volunteered_before === 'yes') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($volunteer->application->volunteered_before) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Outdoor Activities OK:</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($volunteer->application->outdoor_ok === 'yes') bg-green-100 text-green-800
                                    @elseif($volunteer->application->outdoor_ok === 'depends') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($volunteer->application->outdoor_ok) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Short Bio:</label>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $volunteer->application->short_bio ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span>Application Status: 
                                <span class="font-medium
                                    @if($volunteer->application->is_active) text-green-600
                                    @else text-red-600 @endif">
                                    {{ $volunteer->application->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>
                            <span>Submitted: {{ $volunteer->application->submitted_at ? \Carbon\Carbon::parse($volunteer->application->submitted_at)->format('M d, Y') : 'Not specified' }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-[#1a2235] mb-4 flex items-center">
                        <i class='bx bx-file-text text-[#ffb51b] mr-2'></i>
                        Application Form Details
                    </h2>
                    <p class="text-gray-500">No application data available.</p>
                </div>
            @endif
        </x-slot>

        <!-- Programs & Attendance Tab -->
        <x-slot name="slot_programs">
            <div class="space-y-6">
                <!-- Programs Section -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-[#1a2235] mb-4 flex items-center">
                        <i class='bx bx-calendar text-[#ffb51b] mr-2'></i>
                        Assigned Programs
                    </h2>
                    @if ($volunteer->programs->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($volunteer->programs as $program)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <h3 class="font-semibold text-[#1a2235] mb-2">{{ $program->title }}</h3>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Start Date:</span>
                                            <span class="text-gray-900">{{ \Carbon\Carbon::parse($program->start_date)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">End Date:</span>
                                            <span class="text-gray-900">
                                {{ $program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('M d, Y') : 'Ongoing' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Status:</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($program->pivot->status === 'active') bg-green-100 text-green-800
                                                @elseif($program->pivot->status === 'completed') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($program->pivot->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                    @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No programs assigned yet.</p>
            @endif
        </div>

                <!-- Attendance Logs Section -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-[#1a2235] mb-4 flex items-center">
                        <i class='bx bx-time text-[#ffb51b] mr-2'></i>
                        Attendance Logs
                    </h2>
                    @if ($volunteer->attendanceLogs->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse">
                    <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th class="p-3 text-left font-medium text-gray-700">Program</th>
                                        <th class="p-3 text-left font-medium text-gray-700">Clock In</th>
                                        <th class="p-3 text-left font-medium text-gray-700">Clock Out</th>
                                        <th class="p-3 text-left font-medium text-gray-700">Total Time</th>
                                        <th class="p-3 text-left font-medium text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($volunteer->attendanceLogs as $log)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="p-3">
                                                <span class="font-medium text-[#1a2235]">
                                    {{ $log->program->title ?? 'No Program Assigned' }}
                                                </span>
                                </td>
                                <td class="p-3">
                                                <span class="text-gray-900">
                                    {{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}
                                                </span>
                                </td>
                                <td class="p-3">
                                    @if ($log->clock_out)
                                                    <span class="text-gray-900">
                                        {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                                                    </span>
                                    @else
                                                    <span class="text-red-500 font-medium">Still Clocked In</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if ($log->clock_out)
                                        @php
                                            $diff = \Carbon\Carbon::parse($log->clock_in)->diff(\Carbon\Carbon::parse($log->clock_out));
                                        @endphp
                                                    <span class="font-medium text-gray-900">
                                        {{ $diff->h }}h {{ $diff->i }}m {{ $diff->s }}s
                                                    </span>
                                    @else
                                                    <span class="text-red-500 font-medium">Ongoing</span>
                                    @endif
                                </td>
                                            <td class="p-3">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    @if($log->clock_out) bg-green-100 text-green-800
                                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                    {{ $log->clock_out ? 'Completed' : 'Active' }}
                                                </span>
                                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                        </div>
                    @else
                        <p class="text-gray-500">No attendance logs available.</p>
            @endif
                </div>
            </div>
        </x-slot>
    </x-navigation-layout.tabs-modern>
@endsection
