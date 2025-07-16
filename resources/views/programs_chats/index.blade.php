@extends('layouts.sidebar_final')

@section('content')
<div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6 max-w-7xl">
    <!-- Messenger Layout -->
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Chat Interface (Left) -->
        <div class="flex-1 order-2 md:order-1">
            @if(isset($program))
                <!-- Chat Interface -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                    <!-- Chat Header -->
                    <div class="px-6 py-4 bg-gradient-to-r from-[#1a2235] to-[#2a3447] text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-10 h-10 bg-[#ffb51b] rounded-lg mr-4">
                                    <i class='bx bx-message-square-dots text-[#1a2235] text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $program->title }}</h3>
                                    <p class="text-sm text-gray-300">{{ $program->volunteers->count() }} participants</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('programs.volunteers', $program) }}"
                                   class="inline-flex items-center justify-center px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-lg transition-all duration-200 backdrop-blur-sm">
                                    <i class='bx bx-arrow-back mr-2'></i>
                                    <span class="hidden sm:inline">Back to Program</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Container -->
                    <div class="flex flex-col h-[700px]">
                        <!-- Messages Area -->
                        <div class="flex-1 overflow-y-auto p-6 bg-gray-50" id="chatMessages">
                            @forelse($messages as $message)
                                <div class="flex gap-4 mb-6 {{ $message->sender_id === Auth::id() ? 'flex-row-reverse' : '' }}" data-message-id="{{ $message->id }}">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="relative">
                                            <img src="{{ $message->sender->profile_pic ?? asset('images/default-avatar.png') }}"
                                                 alt="{{ $message->sender->name }}"
                                                 class="w-12 h-12 rounded-full border-2 border-white shadow-md">
                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></div>
                                        </div>
                                    </div>
                                    <!-- Message Content -->
                                    <div class="flex-1 max-w-md {{ $message->sender_id === Auth::id() ? 'text-right' : '' }}">
                                        <div class="flex items-center gap-2 mb-2 {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                            <span class="font-semibold text-[#1a2235] text-sm">{{ $message->sender->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="relative group">
                                            <div class="p-4 rounded-2xl shadow-sm {{ $message->sender_id === Auth::id() ? 'bg-gradient-to-br from-[#ffb51b] to-[#e6a319] text-[#1a2235]' : 'bg-white text-gray-700 border border-gray-200' }}">
                                                <p class="whitespace-pre-wrap text-sm leading-relaxed">{{ $message->message }}</p>
                                                @if($message->is_edited)
                                                    <span class="text-xs opacity-70 mt-2 block italic">(edited)</span>
                                                @endif
                                            </div>
                                            <div class="absolute top-4 {{ $message->sender_id === Auth::id() ? '-right-2' : '-left-2' }}">
                                                <div class="w-4 h-4 transform rotate-45 {{ $message->sender_id === Auth::id() ? 'bg-[#ffb51b]' : 'bg-white border-l border-b border-gray-200' }}"></div>
                                            </div>
                                        </div>
                                        @if($message->sender_id === Auth::id())
                                            <div class="flex items-center gap-3 mt-2 justify-end">
                                                <form action="{{ route('program.chats.destroy', [$program, $message]) }}" method="POST" class="inline chat-delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Delete this message?')" class="inline-flex items-center px-3 py-1 text-xs text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-full transition-all">
                                                        <i class="bx bx-trash mr-1"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center h-full text-center py-12">
                                    <div class="w-24 h-24 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-6">
                                        <i class='bx bx-message-square-dots text-[#ffb51b] text-4xl'></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No messages yet</h3>
                                    <p class="text-gray-500 mb-6">Be the first to start the conversation!</p>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <i class='bx bx-info-circle mr-2'></i>
                                        <span>Messages will appear here once someone sends one</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        <!-- Message Input Area -->
                        <div class="border-t border-gray-200 bg-white p-6">
                            <form action="{{ route('program.chats.store', $program) }}" method="POST" class="flex gap-4 items-end">
                                @csrf
                                <div class="flex-1">
                                    <div class="relative">
                                        <input type="text"
                                               id="messageInput"
                                               name="message"
                                               class="w-full p-4 pr-12 bg-gray-50 border border-gray-200 rounded-2xl text-[#1a2235] placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-4 focus:ring-[#ffb51b]/20 focus:outline-none"
                                               placeholder="Type your message..."
                                               required>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                            <i class='bx bx-smile text-xl cursor-pointer hover:text-[#ffb51b] transition-colors'></i>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit"
                                        class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-[#ffb51b] to-[#e6a319] text-[#1a2235] rounded-2xl hover:from-[#e6a319] hover:to-[#cc9116] transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-[#ffb51b]/30">
                                    <i class='bx bx-send text-xl'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Pagination -->
                @if($messages->hasPages())
                    <div class="mt-6 flex justify-center">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-2">
                            {{ $messages->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center h-full text-center py-24">
                    <div class="w-24 h-24 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-6">
                        <i class='bx bx-message-square-dots text-[#ffb51b] text-4xl'></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Select a program chat</h3>
                    <p class="text-gray-500 mb-6">Choose a program from the list to start chatting.</p>
                </div>
            @endif
        </div>
        <!-- Program Chats Sidebar (Right) -->
        <div class="w-full md:w-80 order-1 md:order-2 md:h-[700px] flex-shrink-0">
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg h-full flex flex-col overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-[#ffb51b]/10 to-[#e6a319]/10">
                    <h2 class="text-lg font-bold text-[#1a2235] flex items-center">
                        <i class='bx bx-group text-[#ffb51b] mr-2'></i>
                        Program Chats
                    </h2>
                </div>
                <div class="flex-1 overflow-y-auto">
                    @if($programs->isNotEmpty())
                        <ul class="divide-y divide-gray-100">
                            @foreach($programs as $p)
                                <li>
                                    <a href="{{ route('program.chats.show', $p) }}"
                                       class="flex items-center gap-3 px-6 py-4 hover:bg-[#ffb51b]/10 transition-colors {{ isset($program) && $program->id === $p->id ? 'bg-[#ffb51b]/20' : '' }}">
                                        <div class="flex items-center justify-center w-10 h-10 bg-blue-50 rounded-lg">
                                            <i class='bx bx-message-square-dots text-blue-600'></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-sm font-semibold text-[#1a2235] truncate">{{ $p->title }}</h3>
                                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                                <span>{{ $p->volunteers->count() }} {{ $p->volunteers->count() === 1 ? 'Volunteer' : 'Volunteers' }}</span>
                                                <span>·</span>
                                                <span>{{ $p->chats->count() }} {{ $p->chats->count() === 1 ? 'Message' : 'Messages' }}</span>
                                            </div>
                                        </div>
                                        <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full whitespace-nowrap {{ $p->created_by === Auth::id() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $p->created_by === Auth::id() ? 'Coordinator' : 'Volunteer' }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-center py-12">
                            <div class="w-16 h-16 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-4">
                                <i class='bx bx-message-square-dots text-[#ffb51b] text-2xl'></i>
                            </div>
                            <h3 class="text-md font-semibold text-gray-700 mb-2">No program chats</h3>
                            <p class="text-gray-500 mb-4">You are not part of any program chats yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="program.chats.store"]');
    if (form) {
        const input = form.querySelector('input[name="message"]');
        const chatMessages = document.getElementById('chatMessages');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.chat) {
                    // Append the new message to the chat
                    const chat = data.chat;
                    const isOwn = chat.sender_id == {{ Auth::id() }};
                    const msgDiv = document.createElement('div');
                    msgDiv.className = 'flex gap-4 mb-6' + (isOwn ? ' flex-row-reverse' : '');
                    msgDiv.setAttribute('data-message-id', chat.id);
                    msgDiv.innerHTML = `
                        <div class="flex-shrink-0">
                            <div class="relative">
                                <img src="${chat.sender.profile_pic ?? '/images/default-avatar.png'}"
                                     alt="${chat.sender.name}"
                                     class="w-12 h-12 rounded-full border-2 border-white shadow-md">
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></div>
                            </div>
                        </div>
                        <div class="flex-1 max-w-md ${isOwn ? 'text-right' : ''}">
                            <div class="flex items-center gap-2 mb-2 ${isOwn ? 'justify-end' : 'justify-start'}">
                                <span class="font-semibold text-[#1a2235] text-sm">${chat.sender.name}</span>
                                <span class="text-xs text-gray-500">Just now</span>
                            </div>
                            <div class="relative group">
                                <div class="p-4 rounded-2xl shadow-sm ${isOwn ? 'bg-gradient-to-br from-[#ffb51b] to-[#e6a319] text-[#1a2235]' : 'bg-white text-gray-700 border border-gray-200'}">
                                    <p class="whitespace-pre-wrap text-sm leading-relaxed">${chat.message}</p>
                                </div>
                                <div class="absolute top-4 ${isOwn ? '-right-2' : '-left-2'}">
                                    <div class="w-4 h-4 transform rotate-45 ${isOwn ? 'bg-[#ffb51b]' : 'bg-white border-l border-b border-gray-200'}"></div>
                                </div>
                            </div>
                            ${isOwn ? `
                            <div class="flex items-center gap-3 mt-2 justify-end">
                                <form action="${data.delete_url}" method="POST" class="inline chat-delete-form">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="inline-flex items-center px-3 py-1 text-xs text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-full transition-all">
                                        <i class="bx bx-trash mr-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                            ` : ''}
                        </div>
                    `;
                    chatMessages.appendChild(msgDiv);
                    input.value = '';
                    chatMessages.scrollTo({ top: chatMessages.scrollHeight, behavior: 'smooth' });
                } else {
                    alert(data.error || 'Failed to send message.');
                }
            })
            .catch(() => alert('Network error. Please try again.'));
        });
    }

    // Event delegation for delete
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form.classList.contains('chat-delete-form')) {
            e.preventDefault();
            if (!confirm('Delete this message?')) return;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            fetch(form.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const msgDiv = form.closest('[data-message-id]');
                    if (msgDiv) msgDiv.remove();
                } else {
                    alert(data.error || 'Failed to delete message.');
                }
            })
            .catch(() => alert('Network error. Please try again.'));
        }
    });
});
</script>
@endpush

@endsection