<x-modal.dialog id="invitationModal" maxWidth="max-w-lg" width="w-11/12" maxHeight="max-h-[90vh]">
    <div x-data="{ message: '' }">
        <!-- Header -->
        <x-modal.header>
            <h2 id="invitation-modal-title" class="text-2xl font-bold text-slate-900 tracking-tight">
                Invite {{ $volunteer->user->name }} to Become a Member
            </h2>
        </x-modal.header>
        
        <!-- Form -->
        <form id="invitationForm" action="" method="POST" class="p-6">
            @csrf
            
            <!-- Membership Type -->
            <div class="mb-5">
                <x-form.select-option id="membership_type" name="membership_type" label="Membership Type">
                    <option value="full_pledge">Full-Pledge</option>
                    <option value="honorary">Honorary</option>
                </x-form.select-option>
            </div>
            
            @php
                $templateMessages = [
                    "Dear {$volunteer->user->name},\n\nWe're impressed with your contributions and would like to formally invite you to become a member. Your dedication and commitment have not gone unnoticed, and we believe you would be a valuable addition to our membership.\n\nBest regards,\n" . auth()->user()->name,

                    "Dear {$volunteer->user->name},\n\nYour dedication as a volunteer has been outstanding. We would be honored to have you as a full-pledge member. Your consistent efforts and positive impact align perfectly with our organization's values.\n\nBest regards,\n" . auth()->user()->name,

                    "Dear {$volunteer->user->name},\n\nAs a respected partner in our mission, we would like to offer you an honorary membership to our organization. Your expertise and contributions have made a significant difference in our community.\n\nBest regards,\n" . auth()->user()->name,

                    "Dear {$volunteer->user->name},\n\nJoin us in a greater capacity! We invite you to become a member and help us shape the future of our mission. Your experience and perspective would be invaluable in our continued growth.\n\nBest regards,\n" . auth()->user()->name
                ];
            @endphp

            <!-- Template Messages -->
            <div class="mb-5">
                 <x-form.select-option id="template_messages" name="template_messages" label="Use a Message Template (Optional)" x-on:change="message = $event.target.value">
                    <option value="">Select a message...</option>
                    @foreach($templateMessages as $msg)
                        <option value="{{ $msg }}">{{ \Illuminate\Support\Str::limit($msg, 50) }}</option>
                    @endforeach
                </x-form.select-option>
            </div>

            <!-- Invitation Message -->
            <div class="mb-6">
                <x-form.textarea id="invitation_message" name="invitation_message" label="Invitation Message" placeholder="Add a personal message or select a template..." x-model="message"></x-form.textarea>
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
</x-modal.dialog>
