<!-- Financial Dashboard -->
<div class="bg-gray-50 min-h-screen">
    <!-- Membership Revenue (amount, keep as card) -->
    <div class="grid grid-cols-1 gap-4 mb-6">
        <div class="bg-white border-2 border-blue-100 rounded-xl p-6 hover:border-blue-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 text-sm font-medium mb-1">Membership Revenue (Paid)</div>
                    <div class="text-3xl font-bold text-blue-600">₱ {{ number_format($data['membershipRevenue'] ?? 0, 2) }}</div>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <i class='bx bx-wallet text-2xl text-blue-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-time" title="Overdue Payments" :value="number_format($data['overduePayments'] ?? 0)" gradientVariant="deep-rose" />
        <x-overview.stat-card icon="bx-check-circle" title="Donations (Confirmed)" :value="number_format($data['donationsConfirmed'] ?? 0)" gradientVariant="forest" />
        <x-overview.stat-card icon="bx-hourglass" title="Donations (Pending)" :value="number_format($data['donationsPending'] ?? 0)" gradientVariant="sunset-orange" />
    </x-overview.stat-card-group>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Quarterly Summary -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 lg:col-span-2 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-indigo-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-bar-chart text-xl text-indigo-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Quarterly Payments Summary</h3>
                    <p class="text-gray-600 text-sm">{{ now()->year }} Financial Overview</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @php($quarters = $data['quarterly'] ?? [])
                @foreach($quarters as $q => $row)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                        <div class="text-gray-700 font-semibold mb-3 text-center">{{ $q }}</div>
                        <div class="space-y-2">
                            <div class="flex items-center text-sm">
                                <i class='bx bx-check text-green-600 mr-1'></i>
                                <span class="text-green-700">Paid: {{ number_format($row['paid_count'] ?? 0) }}</span>
                            </div>
                            <div class="text-xs text-green-600 ml-4">₱ {{ number_format($row['paid_amount'] ?? 0, 2) }}</div>
                            <div class="flex items-center text-sm">
                                <i class='bx bx-time-five text-amber-600 mr-1'></i>
                                <span class="text-amber-600">Pending: {{ number_format($row['pending_count'] ?? 0) }}</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class='bx bx-x text-red-600 mr-1'></i>
                                <span class="text-red-600">Overdue: {{ number_format($row['overdue_count'] ?? 0) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Donation Methods -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-purple-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-credit-card text-xl text-purple-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Top Donation Methods</h3>
                    <p class="text-gray-600 text-sm">Payment preferences</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['topDonationMethods'] ?? []) as $m)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <i class='bx bx-money text-gray-600 mr-2'></i>
                            <span class="text-gray-700 font-medium">{{ $m->payment_method ?? 'Unknown' }}</span>
                        </div>
                        <span class="text-gray-900 font-bold">₱ {{ number_format($m->total ?? 0, 2) }}</span>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class='bx bx-info-circle text-3xl mb-2'></i>
                        <p>No donations yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Donations -->
    <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
        <div class="flex items-center mb-6">
            <div class="bg-emerald-50 p-2 rounded-lg mr-3">
                <i class='bx bx-history text-xl text-emerald-600'></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Recent Donations</h3>
                <p class="text-gray-600 text-sm">Latest donation activity</p>
            </div>
        </div>

        <div class="space-y-3">
            @forelse(($data['recentDonations'] ?? []) as $d)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white p-2 rounded-lg border">
                            <i class='bx bx-donate-heart text-emerald-600'></i>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">₱ {{ number_format($d->amount ?? 0, 2) }}</div>
                            <div class="text-sm text-gray-600">
                                {{ $d->donor_name ?? 'Anonymous' }} • {{ $d->payment_method ?? 'N/A' }} • {{ optional($d->donation_date)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @if($d->status === 'Confirmed')
                            <i class='bx bx-check-circle text-green-600 mr-1'></i>
                            <span class="text-sm font-medium text-green-600">{{ $d->status }}</span>
                        @else
                            <i class='bx bx-time text-amber-600 mr-1'></i>
                            <span class="text-sm font-medium text-amber-600">{{ $d->status }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <i class='bx bx-donate-heart text-3xl mb-2'></i>
                    <p>No recent donations.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
