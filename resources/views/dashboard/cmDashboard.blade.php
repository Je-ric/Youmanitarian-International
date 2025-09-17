<!-- Content Management Dashboard -->
<div class="bg-gray-50 min-h-screen">
    <!-- Pipeline (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-upload" title="Submitted" :value="number_format($data['countSubmitted'] ?? 0)" gradientVariant="brand" />
        <x-overview.stat-card icon="bx-time" title="Pending" :value="number_format($data['countPending'] ?? 0)" gradientVariant="amber-orange" />
        <x-overview.stat-card icon="bx-error" title="Needs Revision" :value="number_format($data['countNeedsRevision'] ?? 0)" gradientVariant="sunset-orange" />
        <x-overview.stat-card icon="bx-check-circle" title="Published" :value="number_format($data['countPublished'] ?? 0)" gradientVariant="forest" />
    </x-overview.stat-card-group>

    <!-- My Drafts + Archived (counts only) -->
    <x-overview.stat-card-group>
        <x-overview.stat-card icon="bx-edit" title="My Drafts" :value="number_format($data['myDrafts'] ?? 0)" gradientVariant="blue-sky" />
        <x-overview.stat-card icon="bx-archive" title="Archived" :value="number_format($data['countArchived'] ?? 0)" gradientVariant="deep-rose" />
        <x-overview.stat-card icon="bx-comment" title="New Comments (7d)" :value="number_format($data['commentsNew7Count'] ?? 0)" gradientVariant="violet" />
        <x-overview.stat-card icon="bx-bookmark" title="Bookmarks (7d)" :value="number_format($data['bookmarksLast7'] ?? 0)" gradientVariant="indigo" />
    </x-overview.stat-card-group>

    <!-- Content Engagement Chart -->
    <div class="bg-white border-2 border-gray-100 rounded-xl p-6 mb-8 hover:border-gray-200 transition-colors">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
            <div class="flex items-center">
                <div class="bg-indigo-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-line-chart text-xl text-indigo-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Content Engagement</h3>
                    <p class="text-gray-600 text-sm">Views and Reactions over time</p>
                </div>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 bg-gray-50 p-3 rounded-lg">
                <i class='bx bx-calendar text-gray-600'></i>
                <input type="date" name="from" value="{{ $data['range']['from'] ?? '' }}" class="border border-gray-300 rounded px-2 py-1 text-sm">
                <span class="text-gray-500">to</span>
                <input type="date" name="to" value="{{ $data['range']['to'] ?? '' }}" class="border border-gray-300 rounded px-2 py-1 text-sm">
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-1 rounded transition-colors">Apply</button>
                <a href="{{ url()->current() }}" class="text-sm text-gray-600 hover:text-gray-800 underline">Reset</a>
            </form>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <canvas id="engagementChart" height="120"></canvas>
        </div>

        <!-- ... existing chart script ... -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            (function(){
                const ctx = document.getElementById('engagementChart');
                if (!ctx) return;

                const viewsSeries = @json(collect($data['viewsOverTime'] ?? [])->map(function($r){ return ['date' => $r->date, 'value' => ($r->views ?? $r->published_count ?? 0)]; }));
                const reactsSeries = @json(collect($data['reactsOverTime'] ?? [])->map(function($r){ return ['date' => $r->date, 'value' => ($r->reacts ?? 0)]; }));

                const labelSet = new Set([...
                    viewsSeries.map(r => r.date),
                    ...reactsSeries.map(r => r.date)
                ]);
                const labels = Array.from(labelSet).sort();

                const viewsData = labels.map(d => {
                    const found = viewsSeries.find(r => r.date === d);
                    return found ? Number(found.value) : 0;
                });
                const reactsData = labels.map(d => {
                    const found = reactsSeries.find(r => r.date === d);
                    return found ? Number(found.value) : 0;
                });

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [
                            {
                                label: 'Views',
                                data: viewsData,
                                borderColor: 'rgba(37, 99, 235, 1)',
                                backgroundColor: 'rgba(37, 99, 235, 0.15)',
                                tension: 0.25,
                                fill: true,
                                pointRadius: 3,
                            },
                            {
                                label: 'Reactions',
                                data: reactsData,
                                borderColor: 'rgba(236, 72, 153, 1)',
                                backgroundColor: 'rgba(236, 72, 153, 0.15)',
                                tension: 0.25,
                                fill: true,
                                pointRadius: 3,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'nearest', axis: 'x', intersect: false },
                        plugins: {
                            tooltip: { enabled: true },
                            legend: { position: 'top' }
                        },
                        scales: {
                            x: {
                                ticks: { autoSkip: true, maxTicksLimit: 10 },
                                grid: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            }
                        }
                    }
                });
            })();
        </script>
    </div>

    <!-- Content Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Recent Published -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-green-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-news text-xl text-green-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Recent Published</h3>
                    <p class="text-gray-600 text-sm">Latest content</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['recentPublished'] ?? []) as $c)
                    <div class="p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="flex items-start">
                            <i class='bx bx-file text-green-600 mr-2 mt-1'></i>
                            <div class="flex-1">
                                <div class="font-medium text-gray-800 truncate">{{ $c->title }}</div>
                                <div class="text-gray-500 text-sm">{{ optional($c->published_at)->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-file-blank text-2xl mb-2'></i>
                        <p class="text-sm">No recent publications.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Top Reacted -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-pink-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-heart text-xl text-pink-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Top Reacted</h3>
                    <p class="text-gray-600 text-sm">Most loved content</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['topReacted'] ?? []) as $c)
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

        <!-- Views Over Time -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-blue-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-show text-xl text-blue-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Views (14 days)</h3>
                    <p class="text-gray-600 text-sm">Daily view counts</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['viewsOverTime'] ?? []) as $row)
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="flex items-center">
                            <i class='bx bx-calendar text-blue-600 mr-2'></i>
                            <span class="text-gray-700 font-medium">{{ \Illuminate\Support\Carbon::parse($row->date)->format('M d') }}</span>
                        </div>
                        <span class="text-gray-900 font-bold">{{ $row->views ?? $row->published_count ?? 0 }}</span>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-show text-2xl mb-2'></i>
                        <p class="text-sm">No view data.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Latest Comments (for moderation) -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-blue-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-comment-detail text-xl text-blue-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Latest Comments</h3>
                    <p class="text-gray-600 text-sm">Recent activity</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['commentsLatest'] ?? []) as $cmt)
                    <div class="p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="flex items-start">
                            <i class='bx bx-user-voice text-blue-600 mr-2 mt-1'></i>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div class="text-gray-800 font-medium truncate">{{ $cmt->user->name ?? 'User' }}</div>
                                    <div class="text-gray-500 text-xs">{{ optional($cmt->created_at)->diffForHumans() }}</div>
                                </div>
                                <div class="text-gray-600 text-sm truncate">on: {{ optional($cmt->content)->title ?? 'Content' }}</div>
                                <div class="text-gray-800 text-sm mt-1 line-clamp-2">{{ $cmt->comment }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-comment text-2xl mb-2'></i>
                        <p class="text-sm">No comments yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Top Bookmarked Posts -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-amber-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-bookmark text-xl text-amber-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Top Bookmarked</h3>
                    <p class="text-gray-600 text-sm">Most saved content</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['topBookmarked'] ?? []) as $c)
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                        <div class="flex items-center flex-1">
                            <i class='bx bx-file text-amber-600 mr-2'></i>
                            <span class="text-gray-700 font-medium truncate">{{ $c->title }}</span>
                        </div>
                        <div class="flex items-center text-amber-600 font-bold">
                            <i class='bx bx-bookmark mr-1'></i>
                            <span>{{ $c->bookmarks ?? 0 }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-bookmark text-2xl mb-2'></i>
                        <p class="text-sm">No bookmarks yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Review Notes -->
        <div class="bg-white border-2 border-gray-100 rounded-xl p-6 hover:border-gray-200 transition-colors">
            <div class="flex items-center mb-6">
                <div class="bg-purple-50 p-2 rounded-lg mr-3">
                    <i class='bx bx-note text-xl text-purple-600'></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Review Notes</h3>
                    <p class="text-gray-600 text-sm">Open items: {{ number_format($data['reviewOpenCount'] ?? 0) }}</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse(($data['reviewLatest'] ?? []) as $r)
                    <div class="p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="text-gray-800 font-medium truncate">Note #{{ $r->id }}</div>
                            <div class="text-gray-500 text-xs">{{ optional($r->created_at)->diffForHumans() }}</div>
                        </div>
                        <div class="text-gray-600 text-sm mt-1 line-clamp-2">
                            {{ $r->comment ?? $r->note ?? 'Review note' }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class='bx bx-note text-2xl mb-2'></i>
                        <p class="text-sm">No review notes.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Optional Media Check -->
    <div class="mt-6 bg-white border-2 border-amber-100 rounded-xl p-6 hover:border-amber-200 transition-colors">
        <div class="flex items-center mb-6">
            <div class="bg-amber-50 p-2 rounded-lg mr-3">
                <i class='bx bx-image-alt text-xl text-amber-600'></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Media Checks</h3>
                <p class="text-gray-600 text-sm">Posts missing hero images (top 10)</p>
            </div>
        </div>
        <div class="space-y-2">
            @forelse(($data['mediaIssues'] ?? []) as $m)
                <div class="flex items-center justify-between p-3 bg-amber-50 rounded">
                    <div class="text-gray-700 font-medium">Content #{{ $m->content_id }}</div>
                    <div class="text-amber-700 text-sm">Missing hero: {{ $m->missing_hero }}</div>
                </div>
            @empty
                <div class="text-center py-6 text-gray-500">
                    <i class='bx bx-check-circle text-2xl mb-2'></i>
                    <p class="text-sm">No media issues found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
