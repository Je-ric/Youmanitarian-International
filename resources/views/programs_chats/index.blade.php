@extends('layouts.sidebar_final')

@section('content')
<div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2 flex items-center">
                    <i class='bx bx-message-square-dots text-[#ffb51b] mr-3 text-3xl'></i>
                    Program Group Chats
                </h1>
                <p class="text-gray-600">Connect and collaborate with program volunteers and coordinators</p>
            </div>
        </div>
    </div>

    <!-- Program Chats Grid -->
    @if($programs->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($programs as $p)
                <a href="{{ route('program.chats.show', $p) }}"
                   class="group block bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg hover:border-[#ffb51b]/30 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <!-- Program Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-[#1a2235] group-hover:text-[#ffb51b] transition-colors line-clamp-2">
                                    {{ $p->title }}
                                </h3>
                            </div>
                            <span class="ml-3 px-3 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $p->created_by === Auth::id() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $p->created_by === Auth::id() ? 'Coordinator' : 'Volunteer' }}
                            </span>
                        </div>
                        
                        <!-- Program Stats -->
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="flex items-center justify-center w-8 h-8 bg-blue-50 rounded-lg mr-3">
                                    <i class='bx bx-group text-blue-600'></i>
                                </div>
                                <span class="font-medium">{{ $p->volunteers->count() }}</span>
                                <span class="ml-1">{{ $p->volunteers->count() === 1 ? 'Volunteer' : 'Volunteers' }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="flex items-center justify-center w-8 h-8 bg-[#ffb51b]/10 rounded-lg mr-3">
                                    <i class='bx bx-message-square-dots text-[#ffb51b]'></i>
                                </div>
                                <span class="font-medium">{{ $p->chats->count() }}</span>
                                <span class="ml-1">{{ $p->chats->count() === 1 ? 'Message' : 'Messages' }}</span>
                            </div>
                        </div>
                        
                        <!-- Join Chat Button -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center text-[#ffb51b] font-medium text-sm group-hover:text-[#e6a319] transition-colors">
                                <span>Join Chat</span>
                                <i class='bx bx-right-arrow-alt ml-2 transform group-hover:translate-x-1 transition-transform'></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

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
                                    <img src="{{ $message->sender->profile_pic ?? '/images/default-avatar.png' }}"
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
                                    <div class="flex items-center gap-3 mt-2 {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                        <form action="{{ route('program.chats.update', [$program, $message]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="message" value="{{ $message->message }}" class="hidden edit-message-input w-48 p-1 border rounded text-sm" />
                                            <button type="button" class="inline-flex items-center px-3 py-1 text-xs text-gray-500 hover:text-[#ffb51b] hover:bg-[#ffb51b]/10 rounded-full transition-all edit-message-btn">
                                                <i class="bx bx-edit mr-1"></i>
                                                Edit
                                            </button>
                                            <button type="submit" class="hidden save-edit-btn items-center px-3 py-1 text-xs text-green-600 hover:bg-green-50 rounded-full transition-all">
                                                <i class="bx bx-check mr-1"></i>
                                                Save
                                            </button>
                                            <button type="button" class="hidden cancel-edit-btn items-center px-3 py-1 text-xs text-gray-400 hover:bg-gray-100 rounded-full transition-all">
                                                <i class="bx bx-x mr-1"></i>
                                                Cancel
                                            </button>
                                        </form>
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
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="program.chats.store"]');
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

    // AJAX delete for chat messages
    document.querySelectorAll('.chat-delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
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
        });
    });
});
</script>
@endpush

@endsection