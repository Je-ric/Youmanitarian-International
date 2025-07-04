@php
    $currentYear = now()->year;
    $modalId = $modalId ?? 'reminderModal_' . $member->id;

    $templateMessages = [
        "Dear {$member->user->name},\n\nThis is a friendly reminder about your pending membership payment. Please process your payment at your earliest convenience.\n\nBest regards,\n" . auth()->user()->name,
        
        "Dear {$member->user->name},\n\nWe hope this message finds you well. We noticed that your membership payment is currently pending. Your timely payment helps us continue our mission.\n\nBest regards,\n" . auth()->user()->name,
        
        "Dear {$member->user->name},\n\nJust a gentle reminder regarding your membership payment. Your support is vital to our organization's success.\n\nThank you for your attention to this matter.\n\nBest regards,\n" . auth()->user()->name,
        
        "Dear {$member->user->name},\n\nWe're reaching out to remind you about your pending membership payment. Your contribution helps us maintain and improve our services.\n\nBest regards,\n" . auth()->user()->name
    ];
@endphp

<x-modal.dialog :id="$modalId" maxWidth="max-w-2xl" width="w-11/12" maxHeight="max-h-[90vh]">
    <!-- Header -->
    <x-modal.header>
        <div class="flex-1 min-w-0">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900">
                Send Payment Reminder
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                {{ $member->user->name }}
            </p>
        </div>
    </x-modal.header>

    <!-- Main Content -->
    <form action="{{ route('finance.membership.reminders.store') }}" method="POST" class="flex flex-col">
        @csrf
        <input type="hidden" name="member_id" value="{{ $member->id }}">
        
        <x-modal.body :padded="false">
            <div class="p-4 sm:p-6 space-y-6">
                <!-- Payment Period Selection -->
                <div>
                    <x-form.label for="payment_period">Payment Period</x-form.label>
                    @php
                        $allPayments = $member->payments()->get();
                        $pendingOrOverduePayments = $allPayments->whereIn('payment_status', ['pending', 'overdue']);
                        $paymentsToShow = $pendingOrOverduePayments->isNotEmpty() ? $pendingOrOverduePayments : $allPayments;
                    @endphp

                    <x-form.select-option
                        name="membership_payment_id"
                        id="payment_period"
                        :options="$paymentsToShow->map(function($payment) {
                            return [
                                'value' => $payment->id,
                                'label' => $payment->payment_period . ' ' . $payment->payment_year . ' (' . ucfirst($payment->payment_status) . ')'
                            ];
                        })->toArray()"
                        class="mt-1 block w-full"
                    />
                </div>

                <!-- Template Selection -->
                <div>
                    <x-form.label for="template">
                        Message Template
                        <span class="text-xs font-normal text-gray-500">(Click to use a template)</span>
                    </x-form.label>
                    <x-form.button-group class="mt-1">
                        @foreach($templateMessages as $index => $template)
                            <button type="button"
                                onclick="document.getElementById('content').value = this.getAttribute('data-message')"
                                data-message="{{ $template }}"
                                class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ffb51b] transition-colors">
                                Template #{{ $index + 1 }}
                            </button>
                        @endforeach
                    </x-form.button-group>
                </div>

                <!-- Reminder Message -->
                <div>
                    <x-form.label for="content">
                        Reminder Message
                        <span class="text-xs font-normal text-gray-500">(You can customize this message)</span>
                    </x-form.label>
                    <x-form.textarea
                        name="content"
                        id="content"
                        rows="6"
                        class="mt-1"
                    ></x-form.textarea>
                </div>
            </div>
        </x-modal.body>

        <!-- Footer -->
        <x-modal.footer>
            <x-modal.close-button :modalId="'reminderModal_' . $member->id" text="Cancel" variant="cancel" />
            <x-button type="submit" variant="primary">
                Send Reminder
            </x-button>
        </x-modal.footer>
    </form>
</x-modal.dialog>
