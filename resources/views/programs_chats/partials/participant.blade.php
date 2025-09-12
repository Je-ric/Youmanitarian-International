<div class="flex items-center gap-2">
    <x-user-avatar :user="$participant['user']" size="8" :showName="false" />
    <span class="text-sm font-medium text-[#1a2235]">
        {{ $participant['user']->name ?? 'Unknown' }}
    </span>

    @if ($participant['is_coordinator'])
        <x-feedback-status.status-indicator status="program-coordinator" label="Program Coordinator" />
    @endif

    @if ($participant['status'])
        <x-feedback-status.status-indicator :status="$participant['status']" />
    @endif

    @if ($participant['hours_count'] > 0)
        <span class="text-xs text-gray-500 ml-2">
            ({{ $participant['hours_count'] }})
        </span>
    @endif
</div>
