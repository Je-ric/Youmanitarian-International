<dialog id="invitationModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="invitation-modal-title">
    <div class="modal-box w-11/12 max-w-lg p-0 overflow-hidden rounded-xl bg-white border border-slate-200">
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
            
            <!-- Invitation Message -->
            <div class="mb-6">
                <x-textarea id="invitation_message" name="invitation_message" label="Invitation Message (Optional)" placeholder="Add a personal message..."></x-textarea>
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
