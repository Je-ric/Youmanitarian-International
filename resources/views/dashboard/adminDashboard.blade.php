<!-- Admin Dashboard -->
<div class="bg-gray-50 min-h-screen">
    <!-- Stats (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-user" title="Users" :value="number_format($data['usersCount'] ?? 0)" gradientVariant="brand" />
        <x-overview.stat-card icon="bx-calendar" title="Programs" :value="number_format($data['programsCount'] ?? 0)" gradientVariant="forest" />
        <x-overview.stat-card icon="bx-file" title="Contents" :value="number_format($data['contentsCount'] ?? 0)" gradientVariant="blue-sky" />
        <x-overview.stat-card icon="bx-hourglass" title="Pending Donations" :value="number_format($data['pendingDonations'] ?? 0)" gradientVariant="sunset-orange" />
    </x-overview.stat-card-group>

    <!-- Confirmed Donations (amount, keep as card) -->
    <div class="grid grid-cols-1 gap-4 mb-8">
        <div class="bg-white border-2 border-emerald-100 rounded-xl p-6 hover:border-emerald-200 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-600 text-sm font-medium mb-1">Confirmed Donations</div>
                    <div class="text-3xl font-bold text-emerald-600">₱ {{ number_format($data['donationsTotal'] ?? 0, 2) }}</div>
                </div>
                <div class="bg-emerald-50 p-3 rounded-lg">
                    <i class='bx bx-donate-heart text-2xl text-emerald-600'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Management Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Pending Contents -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-amber-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-time text-xl text-amber-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Pending Contents</h3>
                    <p class="text-gray-600 text-sm">Awaiting approval</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['pendingContents'] ?? []) as $c)
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                        <div class="flex items-center flex-1">
                            <i class='bx bx-file text-amber-600 mr-2'></i>
                            <span class="text-gray-700 font-medium truncate">{{ $c->title }}</span>
                        </div>
                        <span class="text-amber-600 text-sm font-medium">{{ $c->approval_status }}</span>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-check-circle text-2xl mb-2'></i>
                        <p class="text-sm">No pending contents.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Top Reacted Contents -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-pink-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-heart text-xl text-pink-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Top Reacted</h3>
                    <p class="text-gray-600 text-sm">Most popular content</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['topReactedContents'] ?? []) as $c)
                    <div class="flex items-center justify-between p-3 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors">
                        <div class="flex items-center flex-1">
                            <i class='bx bx-file text-pink-600 mr-2'></i>
                            <span class="text-gray-700 font-medium truncate">{{ $c->title }}</span>
                        </div>
                        <div class="flex items-center text-pink-600 font-bold">
                            <i class='bx bx-heart mr-1'></i>
                            <span>{{ $c->hearts ?? 0 }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-heart text-2xl mb-2'></i>
                        <p class="text-sm">No reactions yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-emerald-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-donate-heart text-xl text-emerald-600'></i>
                </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Recent Donations</h3>
                <p class="text-gray-600 text-sm">Latest contributions</p>
            </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['recentDonations'] ?? []) as $d)
                    <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">
                        <div class="flex items-center">
                            <i class='bx bx-money text-emerald-600 mr-2'></i>
                            <span class="text-gray-700 font-bold">₱ {{ number_format($d->amount ?? 0, 2) }}</span>
                        </div>
                        <span class="text-gray-500 text-sm">{{ $d->donor_name ?? 'Anonymous' }}</span>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-donate-heart text-2xl mb-2'></i>
                        <p class="text-sm">No recent donations.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Donation Methods -->
    <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
        <div class="flex items-center mb-6">
            <div class="bg-indigo-50 p-2 rounded-lg mr-3">
                <i class='bx bx-credit-card text-xl text-indigo-600'></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Top Donation Methods</h3>
                <p class="text-gray-600 text-sm">Preferred payment methods</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse(($data['topDonationMethods'] ?? []) as $m)
                <div class="flex items-center justify-between p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                    <div class="flex items-center">
                        <i class='bx bx-credit-card text-indigo-600 mr-3'></i>
                        <span class="text-gray-700 font-medium">{{ $m->payment_method ?? 'Unknown' }}</span>
                    </div>
                    <span class="text-gray-900 font-bold">₱ {{ number_format($m->total ?? 0, 2) }}</span>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    <i class='bx bx-credit-card text-3xl mb-2'></i>
                    <p>No donation data available.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
