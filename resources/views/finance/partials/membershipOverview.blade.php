<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    @php
        $stats = [
            [
                'title' => 'Total Members',
                'value' => $members->total(),
                'icon' => 'bx-group',
                'color' => 'blue'
            ],
            [
                'title' => 'Active Members',
                'value' => $members->where('membership_status', 'active')->count(),
                'icon' => 'bx-user-check',
                'color' => 'green'
            ],
            [
                'title' => 'Total Payments',
                'value' => $members->sum(function ($member) {
                    return $member->payments->count();
                }),
                'icon' => 'bx-money',
                'color' => 'purple'
            ]
        ];
    @endphp

    @foreach($stats as $stat)
        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ $stat['title'] }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                </div>
                <div class="p-3 bg-{{ $stat['color'] }}-50 rounded-full">
                    <i class='bx {{ $stat['icon'] }} text-{{ $stat['color'] }}-500 text-xl'></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

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
                @foreach(['Q1', 'Q2', 'Q3', 'Q4'] as $quarter)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $quarter }}</td>
                        @php
                            $statuses = ['paid', 'pending', 'overdue'];
                            $counts = array_map(function ($status) use ($members, $quarter) {
                                return $members->sum(function ($member) use ($quarter, $status) {
                                    return $member->payments->where('payment_period', $quarter)
                                        ->where('payment_status', $status)->count();
                                });
                            }, $statuses);
                        @endphp
                        @foreach($counts as $count)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $count }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>