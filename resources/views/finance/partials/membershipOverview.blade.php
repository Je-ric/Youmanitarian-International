<x-overview.stat-card-group>
    <x-overview.stat-card
        icon="bx-group"
        title="Total Members"
        :value="$totalMembers"
        bgColor="bg-blue-50"
        iconColor="text-blue-500"
    />
    <x-overview.stat-card
        icon="bx-user-check"
        title="Active Members"
        :value="$activeMembers"
        bgColor="bg-green-50"
        iconColor="text-green-500"
    />
    <x-overview.stat-card
        icon="bx-wallet"
        title="Membership Revenue"
        :value="'₱' . number_format($totalMembershipRevenue, 2)"
        bgColor="bg-purple-50"
        iconColor="text-purple-500"
    />
    <x-overview.stat-card
        icon="bx-error-circle"
        title="Overdue Payments"
        :value="$overduePayments"
        bgColor="bg-red-50"
        iconColor="text-red-500"
    />
</x-overview.stat-card-group>

{{-- Payment Status Chart --}}
<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Status Overview</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quarter
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pending
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Overdue
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($paymentStatusByQuarter as $quarter => $statuses)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $quarter }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $statuses['paid'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $statuses['pending'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $statuses['overdue'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>