<x-table.table containerClass="overflow-x-auto" tableClass="min-w-full">
    <x-table.thead>
        <x-table.tr :hover="false">
            <x-table.th class="w-10 text-center">#</x-table.th>
            <x-table.th>Member</x-table.th>
            <x-table.th>Type</x-table.th>
        @foreach(['Q1', 'Q2', 'Q3', 'Q4'] as $quarter)
                <x-table.th>{{ $quarter }}</x-table.th>
        @endforeach
            <x-table.th>Actions</x-table.th>
        </x-table.tr>
    </x-table.thead>
    <x-table.tbody>
    @forelse($members as $member)
            <x-table.tr>
                <x-table.td class="w-10 text-center text-gray-500">{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</x-table.td>
                <x-table.td>
                    <div class="text-sm font-bold text-gray-800">{{ $member->user->name }}</div>
                <div class="text-sm text-gray-500">{{ $member->user->email }}</div>
                </x-table.td>
                <x-table.td>
                <div class="text-sm text-gray-900">{{ ucfirst($member->membership_type) }}</div>
                </x-table.td>
            @php
                $currentYear = now()->year;
                $startYear = $member->start_date ? $member->start_date->year : null;
                $startQuarter = $member->start_date ? ceil($member->start_date->month / 3) : null;
            @endphp

            @foreach(['Q1', 'Q2', 'Q3', 'Q4'] as $quarter)
                    <x-table.td>
                    @php
                        $quarterNumber = substr($quarter, 1);
                        $shouldShowPayment = $startYear &&
                            ($currentYear > $startYear ||
                            ($currentYear == $startYear && $quarterNumber >= $startQuarter));
                        $payment = $member->payments
                            ->where('payment_period', $quarter)
                            ->where('payment_year', $currentYear)
                            ->first();
                        $status = $payment ? $payment->payment_status : app(App\Http\Controllers\MembershipController::class)->determinePaymentStatus($quarter, $payment);
                        // Icon and color mapping
                        if (!$shouldShowPayment) {
                            $icon = 'bx-lock';
                            $bg = 'bg-gray-300';
                            $iconColor = 'text-white';
                        } else if ($payment) {
                            if ($status === 'paid') {
                                $icon = 'bx-check-circle';
                                $bg = 'bg-green-500';
                                $iconColor = 'text-white';
                            } else if ($status === 'overdue') {
                                $icon = 'bx-error';
                                $bg = 'bg-red-500';
                                $iconColor = 'text-white';
                            } else {
                                $icon = 'bx-time';
                                $bg = 'bg-yellow-400';
                                $iconColor = 'text-white';
                            }
                        } else {
                            $icon = 'bx-time';
                            $bg = 'bg-yellow-400';
                            $iconColor = 'text-white';
                        }
                    @endphp
                    @if($shouldShowPayment)
                        @php $modalId = 'paymentModal_' . $member->id . '_' . $quarter; @endphp
                        <button type="button"
                            onclick="document.getElementById('{{ $modalId }}').showModal()"
                            class="w-9 h-9 flex items-center justify-center rounded-full {{ $bg }} {{ $iconColor }} focus:outline-none">
                            <i class='bx {{ $icon }} text-xl'></i>
                        </button>
                        @include('finance.modals.addPaymentModal', [
                            'modalId' => $modalId,
                            'member' => $member,
                            'quarter' => $quarter,
                            'year' => $currentYear,
                            'payment' => $payment,
                            'status' => $status,
                            'statusClass' => $status === 'paid' ? 'text-green-600' : ($status === 'overdue' ? 'text-red-600' : 'text-yellow-600')
                        ])
                    @else
                        <button class="w-9 h-9 flex items-center justify-center rounded-full {{ $bg }} {{ $iconColor }} cursor-not-allowed" disabled>
                            <i class='bx {{ $icon }} text-xl'></i>
                        </button>
                    @endif
                    </x-table.td>
            @endforeach
                <x-table.td>
                    <div class="flex items-center gap-2">
                        @php $reminderModalId = 'reminderModal_' . $member->id; @endphp
                        <button type="button"
                            onclick="document.getElementById('{{ $reminderModalId }}').showModal()"
                            class="flex items-center gap-1 text-blue-600 hover:underline bg-transparent p-0 border-0 focus:outline-none"
                            title="Send Payment Reminder">
                            <i class='bx bx-bell'></i>
                            <span>Remind</span>
                        </button>
                    </div>
                </x-table.td>
            </x-table.tr>
            @include('finance.modals.paymentReminderModal', [
                'modalId' => $reminderModalId,
                'member' => $member
            ])
    @empty
        <tr>
            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                No active members found
            </td>
        </tr>
    @endforelse
    </x-table.tbody>
</x-table.table>
<div class="px-6 py-4 border-t border-gray-200">
    {{ $members->links() }}
</div>
