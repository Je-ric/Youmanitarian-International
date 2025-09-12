<div class="flex items-center gap-2 @if($participant['is_coordinator']) pr-2 @endif">
    <span class="inline-flex items-center justify-center font-semibold text-gray-500 text-[11px]">
        {{ $participant['index'] }}
    </span>

    <x-user-avatar :user="$participant['user']" size="8" :showName="false" />

    <span class="text-sm font-medium text-[#1a2235] truncate max-w-[140px]">
        {{ $participant['user']->name ?? 'Unknown' }}
        @if ($participant['is_coordinator'])
            <span class="ml-2 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-semibold">
                (PC)
            </span>
        @endif
    </span>

    @if ($participant['hours_count'] > 0)
        <span class="text-xs text-gray-500 ml-2">
            ({{ $participant['hours_count'] }})
        </span>
    @endif
</div>
    