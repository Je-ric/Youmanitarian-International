@php
    $user = $volunteer->user;
    $hours = $user && method_exists($user, 'consultationHours')
        ? $user->consultationHours()
            ->orderByRaw("FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->get()
        : collect();
@endphp

<div class="space-y-4">
    <x-feedback-status.alert
        variant="flexible"
        icon="bx bx-time-five"
        message="These consultation hours are visible to everyone and may be used to contact the volunteer."
        bgColor="bg-blue-50"
        textColor="text-blue-700"
        borderColor="border-blue-200"
        iconColor="text-blue-600"
    />

    @if($hours->isEmpty())
        <x-empty-state icon="bx bx-time" title="No Consultation Hours" description="This user hasn't added any consultation hours yet." />
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border rounded-lg">
                <thead class="text-xs font-semibold text-gray-500 border-b bg-gray-50">
                    <tr>
                        <th class="py-2 px-3 text-left">Specialization</th>
                        <th class="py-2 px-3 text-left">Day</th>
                        <th class="py-2 px-3 text-left">Time</th>
                        <th class="py-2 px-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hours as $h)
                        <tr class="border-b last:border-0 hover:bg-gray-50">
                            <td class="py-2 px-3 font-medium whitespace-nowrap">{{ $h->specialization ?? 'Consultation' }}</td>
                            <td class="py-2 px-3 whitespace-nowrap">{{ $h->day }}</td>
                            <td class="py-2 px-3 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($h->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($h->end_time)->format('g:i A') }}
                            </td>
                            <td class="py-2 px-3 whitespace-nowrap">
                                <x-feedback-status.status-indicator :status="$h->status" :label="ucfirst($h->status)" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>


