@if($hours->isNotEmpty())
    <ul class="space-y-2">
        @foreach($hours as $h)
            @php
                $hourUserId = $h->user_id ?? ($h->user->id ?? null);
                $isSelf = $hourUserId === Auth::id();
            @endphp
            <li>
                <a href="{{ !$isSelf ? route('consultation-chats.thread.start', $hourUserId) : 'javascript:void(0)' }}" class="group p-2 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-between hover:bg-white hover:shadow-sm transition {{ $isSelf ? 'opacity-60 cursor-not-allowed' : '' }}">
                    <div>
                        <p class="font-medium text-gray-800 text-xs group-hover:text-[#1a2235]">
                            {{ $h->specialization ?? 'Consultation Hour' }}
                        </p>
                        <p class="text-[11px] text-gray-500">
                            {{ $h->day ?? '' }}
                        </p>
                    </div>
                    <span class="text-[11px] font-medium text-[#1a2235] bg-white px-2 py-0.5 rounded border border-gray-200">
                        {{ $h->start_time ? \Carbon\Carbon::parse($h->start_time)->format('g:i A') : '—' }} –
                        {{ $h->end_time ? \Carbon\Carbon::parse($h->end_time)->format('g:i A') : '—' }}
                    </span>
                </a>
            </li>
        @endforeach
    </ul>
@else
    <div class="p-3 text-xs text-gray-500 bg-gray-50 rounded-lg">
        No active consultation hours.
    </div>
@endif
