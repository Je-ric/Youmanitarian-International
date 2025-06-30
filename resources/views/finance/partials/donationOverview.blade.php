<x-overview.stat-card-group>
    <x-overview.stat-card
        icon="bx-money"
        title="Total Donations"
        :value="'₱' . number_format($totalDonations, 2)"
        bgColor="bg-blue-50"
        iconColor="text-blue-500"
    />
    <x-overview.stat-card
        icon="bx-time"
        title="Pending Donations"
        :value="$pendingDonations"
        bgColor="bg-yellow-50"
        iconColor="text-yellow-500"
    />
</x-overview.stat-card-group>

{{-- Financial Summary Chart --}}
<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm mb-6">
    <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Donation Summary</h3>
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($totalDonations, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">100%</td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Total Revenue</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">₱{{ number_format($totalDonations, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">100%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Activity Section --}}
<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
    <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Recent Activity</h3>
    <div class="space-y-3 sm:space-y-4">
        <p class="text-gray-500 text-center py-4">No recent activity to display</p>
    </div>
</div>
