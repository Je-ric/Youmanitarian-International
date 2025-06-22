<dialog id="invitationModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="invitation-modal-title">
    <div x-data="{ message: '' }" class="modal-box w-11/12 max-w-lg p-0 overflow-hidden rounded-xl bg-white border border-slate-200">
        <!-- Header -->
        <x-modal.header>
            <h2 id="invitation-modal-title" class="text-2xl font-bold text-slate-900 tracking-tight">
                Invite to Become a Member
            </h2>
        </x-modal.header>
        
        <!-- Form -->
        <form id="invitationForm" action="" method="POST" class="p-6">
            @csrf
            
            <!-- Membership Type -->
            <div class="mb-5">
                <x-select-option id="membership_type" name="membership_type" label="Membership Type">
                    <option value="full_pledge">Full-Pledge</option>
                    <option value="honorary">Honorary</option>
                </x-select-option>
            </div>
            
            @php
                $templateMessages = [
                    "We're impressed with your contributions and would like to formally invite you to become a member.",
                    "Your dedication as a volunteer has been outstanding. We would be honored to have you as a full-pledge member.",
                    "As a respected partner, we would like to offer you an honorary membership to our organization.",
                    "Join us in a greater capacity! We invite you to become a member and help us shape the future of our mission."
                ];
            @endphp

            <!-- Template Messages -->
            <div class="mb-5">
                 <x-select-option id="template_messages" name="template_messages" label="Use a Message Template (Optional)" x-on:change="message = $event.target.value">
                    <option value="">Select a message...</option>
                    @foreach($templateMessages as $msg)
                        <option value="{{ $msg }}">{{ \Illuminate\Support\Str::limit($msg, 50) }}</option>
                    @endforeach
                </x-select-option>
            </div>

            <!-- Invitation Message -->
            <div class="mb-6">
                <x-textarea id="invitation_message" name="invitation_message" label="Invitation Message" placeholder="Add a personal message or select a template..." x-model="message"></x-textarea>
            </div>

            <!-- Submit Button -->
            <x-button type="submit" variant="primary" class="w-full">
                <i class='bx bx-mail-send'></i>
                Send Invitation
            </x-button>
        </form>

        <!-- Footer -->
        <x-modal.footer>
             <x-modal.close-button modalId="invitationModal" variant="cancel" text="Cancel" />
        </x-modal.footer>
    </div>
</dialog>
