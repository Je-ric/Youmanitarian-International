<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Awaiting Review</div>
        <div class="text-2xl font-semibold">{{ number_format($data['needsApproval'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Published</div>
        <div class="text-2xl font-semibold">{{ number_format($data['published'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">My Drafts</div>
        <div class="text-2xl font-semibold">{{ number_format($data['myDrafts'] ?? 0) }}</div>
    </div>
</div>

<div class="mt-6 bg-white rounded shadow p-4">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <div class="font-semibold">Content Engagement</div>
            <div class="text-gray-500 text-sm">Views and Reactions over time</div>
        </div>
        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
            <input type="date" name="from" value="{{ $data['range']['from'] ?? '' }}" class="border rounded px-2 py-1 text-sm">
            <span class="text-gray-500">to</span>
            <input type="date" name="to" value="{{ $data['range']['to'] ?? '' }}" class="border rounded px-2 py-1 text-sm">
            <button class="bg-blue-600 text-white text-sm px-3 py-1 rounded">Apply</button>
            <a href="{{ url()->current() }}" class="text-sm text-gray-600 underline">Reset</a>
        </form>
    </div>

    <div class="mt-4">
        <canvas id="engagementChart" height="120"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        (function(){
            const ctx = document.getElementById('engagementChart');
            if (!ctx) return;

            const viewsSeries = @json(collect($data['viewsOverTime'] ?? [])->map(function($r){ return ['date' => $r->date, 'value' => ($r->views ?? $r->published_count ?? 0)]; }));
            const reactsSeries = @json(collect($data['reactsOverTime'] ?? [])->map(function($r){ return ['date' => $r->date, 'value' => ($r->reacts ?? 0)]; }));

            // Merge labels from both series
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


<div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Recent Content Published</div>
        <ul class="space-y-2">
            @forelse(($data['recentPublished'] ?? []) as $c)
                <li class="flex items-center justify-between">
                    <div class="truncate">
                        <span class="text-gray-800">{{ $c->title }}</span>
                        <span class="text-gray-500 text-sm ml-2">{{ optional($c->published_at)->format('M d, Y') }}</span>
                    </div>
                </li>
            @empty
                <li class="text-gray-500">No recent publications.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Top 5 Most Reacted</div>
        <ul class="space-y-2">
            @forelse(($data['topReacted'] ?? []) as $c)
                <li class="flex items-center justify-between">
                    <div class="truncate">{{ $c->title }}</div>
                    <div class="text-sm text-pink-600 font-medium">❤ {{ $c->hearts ?? 0 }}</div>
                </li>
            @empty
                <li class="text-gray-500">No reacts yet.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Views Over Time (last 14d)</div>
        <ul class="space-y-2">
            @forelse(($data['viewsOverTime'] ?? []) as $row)
                <li class="flex items-center justify-between">
                    <div class="text-gray-700">{{ \Illuminate\Support\Carbon::parse($row->date)->format('M d') }}</div>
                    <div class="text-gray-900 font-medium">
                        {{ $row->views ?? $row->published_count ?? 0 }}
                    </div>
                </li>
            @empty
                <li class="text-gray-500">No view data.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Recently Updated</div>
        <ul class="space-y-2">
            @forelse(($data['recentlyUpdated'] ?? []) as $c)
                <li class="flex items-center justify-between">
                    <div class="truncate">
                        <span class="text-gray-800">{{ $c->title }}</span>
                        <span class="text-gray-500 text-sm ml-2">by {{ $c->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="text-gray-500 text-sm">{{ optional($c->updated_at)->diffForHumans() }}</div>
                </li>
            @empty
                <li class="text-gray-500">No recent updates.</li>
            @endforelse
        </ul>
    </div>
    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Awaiting Approval</div>
        <ul class="space-y-2">
            @forelse(($data['awaiting'] ?? []) as $c)
                <li class="flex items-center justify-between">
                    <div class="truncate">
                        <span class="text-gray-800">{{ $c->title }}</span>
                        <span class="text-gray-500 text-sm ml-2">by {{ $c->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="text-amber-600 text-sm font-medium">Pending</div>
                </li>
            @empty
                <li class="text-gray-500">Nothing awaiting approval.</li>
            @endforelse
        </ul>
    </div>
</div>

