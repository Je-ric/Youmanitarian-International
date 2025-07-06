<x-overview.stat-card-group>
    <x-overview.stat-card
        icon="bx-money"
        title="Total Confirmed Donations"
        :value="'₱' . number_format($totalConfirmedDonations, 2)"
        bgColor="bg-green-100"
        iconColor="text-green-700"
        gradientVariant="green-emerald"
    />
    <x-overview.stat-card
        icon="bx-badge-check"
        title="Confirmed Donations"
        :value="$confirmedDonations"
        bgColor="bg-blue-100"
        iconColor="text-blue-700"
        gradientVariant="teal-cyan"
    />
    <x-overview.stat-card
        icon="bx-hourglass"
        title="Total Pending Donations"
        :value="'₱' . number_format($totalPendingDonations, 2)"
        bgColor="bg-amber-100"
        iconColor="text-amber-700"
        gradientVariant="peach"
    />
    <x-overview.stat-card
        icon="bx-time-five"
        title="Pending Donations"
        :value="$pendingDonations"
        bgColor="bg-purple-100"
        iconColor="text-purple-700"
        gradientVariant="fuchsia-pink"
    />
</x-overview.stat-card-group>

{{-- Financial Summary Chart --}}
<x-overview.card title="Donation Summary" icon="bx-chart" variant="minimal">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Donations</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($totalConfirmedDonations + $totalPendingDonations, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">100%</td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Total Revenue</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">₱{{ number_format($totalConfirmedDonations + $totalPendingDonations, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">100%</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-overview.card>

{{-- Recent Activity Section --}}
<x-overview.card title="Recent Activity" icon="bx-activity" variant="minimal">
    <div class="space-y-3 sm:space-y-4">
        <p class="text-gray-500 text-center py-4">No recent activity to display</p>
    </div>
</x-overview.card>
