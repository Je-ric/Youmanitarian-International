<!-- Admin Dashboard -->
<div class="bg-gray-50 min-h-screen">
    <!-- Stats (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-user" title="Users" :value="number_format($data['usersCount'] ?? 0)" gradientVariant="brand" />
        <x-overview.stat-card icon="bx-calendar" title="Programs" :value="number_format($data['programsCount'] ?? 0)" gradientVariant="forest" />
        <x-overview.stat-card icon="bx-file" title="Contents" :value="number_format($data['contentsCount'] ?? 0)" gradientVariant="blue-sky" />
        <x-overview.stat-card icon="bx-hourglass" title="Pending Donations" :value="number_format($data['pendingDonations'] ?? 0)" gradientVariant="sunset-orange" />
        <x-overview.stat-card icon="bx-id-card" title="Members" :value="number_format($data['membersTotal'] ?? 0)" gradientVariant="indigo" />
    </x-overview.stat-card-group>

    <!-- Extra quick stats -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-user-plus" title="New Users (7d)" :value="number_format($data['usersNew7d'] ?? 0)" gradientVariant="amber-orange" />
        <x-overview.stat-card icon="bx-lock" title="2FA Enabled" :value="number_format($data['users2FAEnabled'] ?? 0)" gradientVariant="violet" />
        <x-overview.stat-card icon="bx-time-five" title="Jobs Queued" :value="number_format($data['jobsQueued'] ?? 0)" gradientVariant="deep-rose" />
        <x-overview.stat-card icon="bx-group" title="Active Team" :value="number_format($data['teamActiveCount'] ?? 0)" gradientVariant="brand" />
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

    <!-- Content & Programs & Members Grid -->
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

        <!-- Programs Breakdown -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-blue-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-calendar text-xl text-blue-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Programs</h3>
                    <p class="text-gray-600 text-sm">Upcoming • Ongoing • Completed</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="bg-blue-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-blue-700">Upcoming</div>
                    <div class="text-xl font-bold text-blue-700">{{ number_format($data['programsUpcoming'] ?? 0) }}</div>
                </div>
                <div class="bg-green-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-green-700">Ongoing</div>
                    <div class="text-xl font-bold text-green-700">{{ number_format($data['programsOngoing'] ?? 0) }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-gray-700">Completed</div>
                    <div class="text-xl font-bold text-gray-700">{{ number_format($data['programsCompleted'] ?? 0) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Content Status Breakdown -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-indigo-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-layer text-xl text-indigo-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Content Status</h3>
                    <p class="text-gray-600 text-sm">Draft • Published • Archived</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="bg-gray-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-gray-700">Draft</div>
                    <div class="text-xl font-bold text-gray-700">{{ number_format(data_get($data,'contentsByStatus.draft',0)) }}</div>
                </div>
                <div class="bg-green-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-green-700">Published</div>
                    <div class="text-xl font-bold text-green-700">{{ number_format(data_get($data,'contentsByStatus.published',0)) }}</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-blue-700">Archived</div>
                    <div class="text-xl font-bold text-blue-700">{{ number_format(data_get($data,'contentsByStatus.archived',0)) }}</div>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-600">Pending approvals</div>
                <div class="text-sm font-semibold text-amber-600">{{ number_format($data['pendingApprovals'] ?? 0) }}</div>
            </div>
        </div>

        <!-- Members & Payments -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-purple-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-id-card text-xl text-purple-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Members & Payments</h3>
                    <p class="text-gray-600 text-sm">Overview</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="bg-indigo-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-indigo-700">New (30d)</div>
                    <div class="text-xl font-bold text-indigo-700">{{ number_format($data['membersNew30d'] ?? 0) }}</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-3 text-center">
                    <div class="text-xs text-blue-700">Reminders Sent</div>
                    <div class="text-xl font-bold text-blue-700">{{ number_format($data['mpRemindersSent'] ?? 0) }}</div>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Payments Paid</span>
                    <span class="text-sm font-bold text-gray-900">₱ {{ number_format($data['mpPaidTotal'] ?? 0, 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Pending</span>
                    <span class="text-sm font-semibold text-amber-600">{{ number_format($data['mpPendingCount'] ?? 0) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Overdue</span>
                    <span class="text-sm font-semibold text-red-600">{{ number_format($data['mpOverdueCount'] ?? 0) }}</span>
                </div>
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

    <!-- Roles & Consultations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- Role Distribution -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-gray-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-shield-quarter text-xl text-gray-700'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Role Distribution</h3>
                    <p class="text-gray-600 text-sm">Users by role</p>
                </div>
            </div>
            <div class="space-y-2">
                @forelse(($data['roleDistribution'] ?? []) as $r)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <span class="text-gray-700 font-medium">{{ $r->role }}</span>
                        <span class="text-gray-900 font-bold">{{ number_format($r->count ?? 0) }}</span>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-info-circle text-2xl mb-2'></i>
                        <p class="text-sm">No role data.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Consultations Overview -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-teal-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-time text-xl text-teal-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Consultations</h3>
                    <p class="text-gray-600 text-sm">Threads • Avg response • Next slot</p>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Total Threads</span>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($data['consultationThreads'] ?? 0) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Avg Response</span>
                    <span class="text-sm font-semibold text-teal-700">{{ number_format($data['consultationAvgResponseMin'] ?? 0) }}m</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Next Available</span>
                    <span class="text-sm font-semibold text-gray-800">
                        @php($slot = $data['nextConsultationSlot'] ?? null)
                        {{ $slot?->start_at ?? $slot?->available_from ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
