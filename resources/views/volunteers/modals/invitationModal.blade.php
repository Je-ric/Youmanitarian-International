@php
    $templateMessages = [
        "Dear {$volunteer->user->name},\n\nWe're impressed with your contributions and would like to formally invite you to become a member. Your dedication and commitment have not gone unnoticed, and we believe you would be a valuable addition to our membership.\n\nBest regards,\n" . auth()->user()->name,

        "Dear {$volunteer->user->name},\n\nYour dedication as a volunteer has been outstanding. We would be honored to have you as a full-pledge member. Your consistent efforts and positive impact align perfectly with our organization's values.\n\nBest regards,\n" . auth()->user()->name,

        "Dear {$volunteer->user->name},\n\nAs a respected partner in our mission, we would like to offer you an honorary membership to our organization. Your expertise and contributions have made a significant difference in our community.\n\nBest regards,\n" . auth()->user()->name,

        "Dear {$volunteer->user->name},\n\nJoin us in a greater capacity! We invite you to become a member and help us shape the future of our mission. Your experience and perspective would be invaluable in our continued growth.\n\nBest regards,\n" . auth()->user()->name
    ];
@endphp

<x-modal.dialog id="invitationModal" maxWidth="max-w-2xl" width="w-11/12" maxHeight="max-h-[90vh]">
    <div x-data="{ message: '' }">
        <!-- Header -->
        <x-modal.header>
            <div class="flex-1 min-w-0">
                <h2 id="invitation-modal-title" class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">
                    Invite {{ $volunteer->user->name }} to Become a Member
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Send a membership invitation to this volunteer
                </p>
            </div>
        </x-modal.header>
        
        <!-- Form -->
        <form id="invitationForm" action="" method="POST" class="flex flex-col">
            @csrf
            <div class="p-4 sm:p-6 space-y-6">
                <!-- Membership Type -->
                <div>
                    <x-form.label for="membership_type">Membership Type</x-form.label>
                    <select id="membership_type" name="membership_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                        <option value="full_pledge">Full-Pledge</option>
                        <option value="honorary">Honorary</option>
                    </select>
                </div>

                <!-- Template Selection -->
                <div>
                    <x-form.label for="template">
                        Message Template
                        <span class="text-xs font-normal text-gray-500">(Click to use a template)</span>
                    </x-form.label>
                    <div class="mt-1 space-y-2">
                        @foreach($templateMessages as $index => $template)
                            <button type="button"
                                x-on:click="message = $el.getAttribute('data-message')"
                                data-message="{{ $template }}"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 rounded-md transition-colors">
                                Template {{ $index + 1 }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Invitation Message -->
                <div>
                    <x-form.label for="invitation_message">
                        Invitation Message
                        <span class="text-xs font-normal text-gray-500">(You can customize this message)</span>
                    </x-form.label>
                    <x-form.textarea id="invitation_message" name="invitation_message" rows="6" class="mt-1" x-model="message" placeholder="Add a personal message or select a template..."></x-form.textarea>
                </div>
            </div>

            <!-- Footer -->
            <x-modal.footer>
                <x-button type="button" variant="secondary" onclick="document.getElementById('invitationModal').close()">
                    Cancel
                </x-button>
                <x-button type="submit" variant="primary" class="w-full">
                    <i class='bx bx-mail-send'></i>
                    Send Invitation
                </x-button>
            </x-modal.footer>
        </form>
    </div>
</x-modal.dialog>
