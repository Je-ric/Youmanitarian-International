<div class="space-y-6">

    <!-- Inquiry Header -->
    <div class="bg-gradient-to-r from-[#1A2235] to-[#1A2235]/90 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-[#FFB51B] rounded-xl flex items-center justify-center">
                    <i class='bx bx-user text-white text-xl'></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">{{ $contactInquiry->name }}</h2>
                    <p class="text-gray-300">{{ $contactInquiry->email }}</p>
                </div>
            </div>

            <div class="text-right">
                <x-feedback-status.status-indicator
                    :status="$contactInquiry->status"
                    :label="ucfirst($contactInquiry->status)" />
                <p class="text-sm text-gray-300 mt-1">
                    {{ $contactInquiry->created_at->format('M d, Y g:i A') }}
                </p>
            </div>
        </div>

        @if($contactInquiry->subject)
            <div class="bg-white/10 rounded-lg p-4">
                <h3 class="font-semibold mb-2">Subject</h3>
                <p>{{ $contactInquiry->subject }}</p>
            </div>
        @endif
    </div>

    <!-- Contact Information -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class='bx bx-info-circle text-[#FFB51B] mr-2'></i>
            Contact Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-envelope text-blue-600'></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium text-gray-900">{{ $contactInquiry->email }}</p>
                </div>
            </div>

            @if($contactInquiry->phone)
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-phone text-green-600'></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-medium text-gray-900">{{ $contactInquiry->phone }}</p>
                    </div>
                </div>
            @endif

            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-purple-600'></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Submitted</p>
                    <p class="font-medium text-gray-900">{{ $contactInquiry->created_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-message-square-dots text-orange-600'></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <x-feedback-status.status-indicator
                        :status="$contactInquiry->status"
                        :label="ucfirst($contactInquiry->status)" />
                </div>
            </div>
        </div>
    </div>

    <!-- Message Content -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class='bx bx-message-dots text-[#FFB51B] mr-2'></i>
            Message
        </h3>

        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-gray-800 whitespace-pre-wrap">{{ $contactInquiry->message }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class='bx bx-cog text-[#FFB51B] mr-2'></i>
            Actions
        </h3>

        <div class="flex flex-wrap gap-3">
            @if($contactInquiry->status !== 'read')
                <button onclick="updateStatus({{ $contactInquiry->id }}, 'read')"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    <i class='bx bx-check mr-1'></i>
                    Mark as Read
                </button>
            @endif

            @if($contactInquiry->status !== 'responded')
                <button onclick="updateStatus({{ $contactInquiry->id }}, 'responded')"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    <i class='bx bx-message-check mr-1'></i>
                    Mark as Responded
                </button>
            @endif

            <a href="mailto:{{ $contactInquiry->email }}?subject=Re: {{ $contactInquiry->subject ?? 'Your Inquiry' }}"
               class="bg-[#FFB51B] hover:bg-[#FFB51B]/90 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                <i class='bx bx-envelope mr-1'></i>
                Reply via Email
            </a>

            @if($contactInquiry->phone)
                <a href="tel:{{ $contactInquiry->phone }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    <i class='bx bx-phone mr-1'></i>
                    Call
                </a>
            @endif

            <button onclick="deleteInquiry({{ $contactInquiry->id }})"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                <i class='bx bx-trash mr-1'></i>
                Delete
            </button>
        </div>
    </div>
</div>
