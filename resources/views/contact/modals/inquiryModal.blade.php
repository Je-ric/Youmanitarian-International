<x-modal.dialog id="inquiryModal-{{ $contactInquiry->id }}"
    maxWidth="2xl:max-w-4xl xl:max-w-3xl lg:max-w-2xl md:max-w-xl sm:max-w-lg max-w-md" width="w-full"
    maxHeight="max-h-[90vh]">

    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-[#1a2235] flex items-center gap-2">
            <i class='bx bx-message-dots text-[#ffb51b] text-2xl'></i>
            <span class="leading-tight">Contact Inquiry Details</span>
        </h2>
    </x-modal.header>

    <x-modal.body>
        <div class="space-y-6">
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
                        <x-feedback-status.status-indicator :status="$contactInquiry->status" :label="ucfirst($contactInquiry->status)" />
                        <p class="text-sm text-gray-300 mt-1">
                            {{ $contactInquiry->created_at->format('M d, Y g:i A') }}
                        </p>
                    </div>
                </div>

                @if ($contactInquiry->subject)
                    <div class="bg-white/10 rounded-lg p-4">
                        <h3 class="font-semibold mb-2">Subject</h3>
                        <p>{{ $contactInquiry->subject }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-info-circle text-[#FFB51B] mr-2'></i>
                    Contact Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-form.label variant="email" class="text-[11px] tracking-wide">Email</x-form.label>
                        <x-form.readonly class="text-sm text-[#1a2235] bg-gray-100">
                            {{ $contactInquiry->email }}
                        </x-form.readonly>
                    </div>

                    @if ($contactInquiry->phone)
                        <div>
                            <x-form.label variant="user" class="text-[11px] tracking-wide">Phone</x-form.label>
                            <x-form.readonly class="text-sm text-[#1a2235] bg-gray-100">
                                {{ $contactInquiry->phone }}
                            </x-form.readonly>
                        </div>
                    @endif

                    <div>
                        <x-form.label variant="date" class="text-[11px] tracking-wide">Submitted</x-form.label>
                        <x-form.readonly class="text-sm text-[#1a2235] bg-gray-100">
                            {{ $contactInquiry->created_at->format('M d, Y g:i A') }}
                        </x-form.readonly>
                    </div>

                    <div>
                        <x-form.label variant="status" class="text-[11px] tracking-wide">Status</x-form.label>
                        <div class="mt-2">
                            <x-feedback-status.status-indicator :status="$contactInquiry->status" :label="ucfirst($contactInquiry->status)" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-message-dots text-[#FFB51B] mr-2'></i>
                    Message
                </h3>

                <div>
                    <x-form.label variant="description" class="text-[11px] tracking-wide mb-1">
                        Message Content
                    </x-form.label>
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="text-sm leading-relaxed text-gray-700 whitespace-pre-line">
                            {!! nl2br(e($contactInquiry->message)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class='bx bx-cog text-[#FFB51B] mr-2'></i>
                    Actions
                </h3>

                <div class="flex flex-wrap gap-3">
                    @if ($contactInquiry->status !== 'read')
                        <x-button onclick="updateStatus({{ $contactInquiry->id }}, 'read')" variant="info">
                            <i class='bx bx-check'></i>
                            Mark as Read
                        </x-button>
                    @endif

                    @if ($contactInquiry->status !== 'responded')
                        <x-button onclick="updateStatus({{ $contactInquiry->id }}, 'responded')" variant="success">
                            <i class='bx bx-message-check'></i>
                            Mark as Responded
                        </x-button>
                    @endif

                    <x-button
                        href="mailto:{{ $contactInquiry->email }}?subject=Re: {{ $contactInquiry->subject ?? 'Your Inquiry' }}"
                        variant="primary">
                        <i class='bx bx-envelope'></i>
                        Reply via Email
                    </x-button>

                    @if ($contactInquiry->phone)
                        <x-button href="tel:{{ $contactInquiry->phone }}" variant="secondary">
                            <i class='bx bx-phone'></i>
                            Call
                        </x-button>
                    @endif

                    <x-dropdown-button>
                        <button onclick="updateStatus({{ $contactInquiry->id }}, 'read')"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class='bx bx-check mr-2 text-green-500'></i>Mark as Read
                        </button>
                        <button onclick="updateStatus({{ $contactInquiry->id }}, 'responded')"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class='bx bx-message-check mr-2 text-blue-500'></i>Mark as Responded
                        </button>
                        <a href="mailto:{{ $contactInquiry->email }}?subject=Re: {{ $contactInquiry->subject ?? 'Your Inquiry' }}"
                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class='bx bx-envelope mr-2 text-purple-500'></i>Reply via Email
                        </a>
                        @if ($contactInquiry->phone)
                            <a href="tel:{{ $contactInquiry->phone }}"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                <i class='bx bx-phone mr-2 text-green-500'></i>Call
                            </a>
                        @endif
                        <hr class="my-1">
                        <button onclick="deleteInquiry({{ $contactInquiry->id }})"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                            <i class='bx bx-trash mr-2'></i>Delete
                        </button>
                    </x-dropdown-button>
                </div>
            </div>
        </div>

    </x-modal.body>

    <x-modal.footer align="end">
        <x-modal.close-button :modalId="'inquiryModal-' . $contactInquiry->id" text="Close" />
    </x-modal.footer>
</x-modal.dialog>
