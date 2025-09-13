@extends('layouts.sidebar_final')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">
    <h1 class="text-xl font-semibold mb-6 flex items-center gap-2">
        <i class="bx bx-conversation text-2xl text-[#ffb51b]"></i>
        Consultation Chats
    </h1>

    <div class="grid md:grid-cols-3 gap-6">
        {{-- Left: thread list --}}
        <div class="md:col-span-1 space-y-3">
            @forelse($threads as $t)
                @php
                    $me = Auth::id();
                    $other = $t->professional_id === $me ? $t->volunteer : $t->professional;
                    $last = $t->latestChat;
                    $preview = $last?->message ? \Illuminate\Support\Str::limit($last->message, 60) : 'No messages yet.';
                @endphp

             <a href="{{ route('consultation-chats.thread.show', $t) }}"
   class="group block rounded-xl border border-gray-200 bg-white hover:border-[#ffb51b] transition p-4 {{ isset($thread) && $thread->id === $t->id ? 'bg-[#fffbf5]' : '' }}">
    <div class="flex items-center gap-3">
        <x-user-avatar :user="$other" size="8" />
        <div class="min-w-0">
            <p class="text-sm font-semibold text-[#1a2235] truncate">{{ $other->name }}</p>
            <p class="text-[11px] text-gray-500 truncate">{{ $preview }}</p>
        </div>
    </div>
    <div class="mt-2 flex items-center justify-between text-[11px] text-gray-400">
        <span>#{{ $t->id }}</span>
        <span>{{ $last?->sent_at ? \Carbon\Carbon::parse($last->sent_at)->diffForHumans() : '' }}</span>
    </div>
</a>

            @empty
                <p class="text-gray-500 text-sm">No consultation threads yet.</p>
            @endforelse
        </div>

        {{-- Right: conversation --}}
        <div class="md:col-span-2">
            @if(isset($thread))
                @php $me = Auth::id(); $other = $thread->professional_id === $me ? $thread->volunteer : $thread->professional; @endphp
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <x-user-avatar :user="$other" size="10" />
                        <div>
                            <h2 class="text-lg font-semibold text-[#1a2235]">Chat with {{ $other->name }}</h2>
                            <p class="text-xs text-gray-500">Thread #{{ $thread->id }} • Status: {{ ucfirst($thread->status) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl h-[65vh] flex flex-col overflow-hidden">
                    <div id="consultationMessages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-slate-50">
                        @forelse($messages as $m)
                            @php $mine = $m->sender_id === Auth::id(); @endphp
                            <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs sm:max-w-sm px-3 py-2 rounded-lg text-sm shadow
                                    {{ $mine ? 'bg-[#1a2235] text-white' : 'bg-white border border-gray-200 text-gray-700' }}">
                                    <p class="whitespace-pre-line">{{ $m->message }}</p>
                                    <span class="block mt-1 text-[10px] opacity-60">
                                        {{ \Carbon\Carbon::parse($m->sent_at)->format('M d, g:i A') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-xs text-gray-500 py-10">No messages yet.</div>
                        @endforelse
                    </div>

                <form method="POST" action="{{ route('consultation-chats.thread.message.store', $thread) }}"
      class="border-t border-gray-200 p-3 bg-white flex items-center gap-3">
    @csrf
    <textarea name="message" rows="1" required placeholder="Type your message..."
              class="flex-1 resize-none text-sm p-2 rounded-md border border-gray-300 focus:ring-[#ffb51b] focus:border-[#ffb51b]"></textarea>
    <x-button type="submit" variant="primary">
        <i class='bx bx-send text-base'></i>
    </x-button>
</form>

                </div>
            @else
                <div class="h-full min-h-[60vh] rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center text-center p-8 bg-white">
                    <div class="w-16 h-16 rounded-full bg-[#ffb51b]/10 flex items-center justify-center mb-4">
                        <i class="bx bx-message-detail text-[#ffb51b] text-3xl"></i>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Select a thread</h2>
                    <p class="text-gray-500 text-sm max-w-sm">
                        Click a conversation on the left to view and continue your 1-on-1 consultation.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
