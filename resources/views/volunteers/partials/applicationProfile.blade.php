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
            <p class="text-gray-500">This User hasn't submitted an application form yet.</p>
        </div>
    </x-overview.card>
@endif 