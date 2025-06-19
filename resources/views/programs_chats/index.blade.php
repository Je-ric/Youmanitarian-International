@extends('layouts.sidebar_final')

@section('content')

    <div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <div class="mb-4 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                        Program Group Chats
                    </h1>
                    <p class="text-gray-600">Communicate with program volunteers and coordinators</p>
                </div>
            </div>
        </div>

        <!-- Program Chats List -->
        @if($programs->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($programs as $p)
                <a href="{{ route('program.chats.show', $p) }}" 
                   class="block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-[#1a2235]">{{ $p->title }}</h3>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $p->created_by === Auth::id() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $p->created_by === Auth::id() ? 'Coordinator' : 'Volunteer' }}
                            </span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <i class='bx bx-group mr-1'></i>
                            <span>{{ $p->volunteers->count() }} Volunteers</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class='bx bx-message-square-dots mr-1'></i>
                            <span>{{ $p->chats->count() }} Messages</span>
                        </div>
                    </div>
                </a>
            @endforeach
            </div>
        @endif

        @if(isset($program))
            <!-- Chat Interface -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mt-6">
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-[#1a2235] flex items-center">
                            <i class='bx bx-message-square-dots mr-2 text-[#ffb51b]'></i>
                            Group Chat - "{{ $program->title }}"
                        </h3>
                        <a href="{{ route('programs.volunteers', $program) }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class='bx bx-arrow-back mr-2'></i> Back to Program
                        </a>
                    </div>
                </div>
                
                <div class="flex flex-col h-[600px]">
                    <!-- Chat Messages Area -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chatMessages">
                        @forelse($messages as $message)
                            <div class="flex gap-3 {{ $message->sender_id === Auth::id() ? 'flex-row-reverse' : '' }}" data-message-id="{{ $message->id }}">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $message->sender->profile_pic ?? '/images/default-avatar.png' }}" 
                                         alt="{{ $message->sender->name }}"
                                         class="w-10 h-10 rounded-full">
                                </div>

                                <!-- Message Content -->
                                <div class="flex-1 {{ $message->sender_id === Auth::id() ? 'text-right' : '' }}">
                                    <!-- Header -->
                                    <div class="flex items-center gap-2 {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                        <span class="font-medium text-[#1a2235]">{{ $message->sender->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- Message Bubble -->
                                    <div class="mt-1 p-3 rounded-lg {{ $message->sender_id === Auth::id() ? 'bg-[#ffb51b] text-[#1a2235]' : 'bg-gray-100 text-gray-700' }}">
                                        <p class="whitespace-pre-wrap">{{ $message->message }}</p>
                                        @if($message->is_edited)
                                            <span class="text-xs text-gray-500 mt-1 block">(edited)</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Message Actions -->
                                    @if($message->sender_id === Auth::id())
                                        <div class="flex items-center gap-2 mt-1 justify-end">
                                            <button onclick="editMessage({{ $message->id }}, '{{ $message->message }}')" 
                                                    class="text-xs text-gray-500 hover:text-gray-700">
                                                <i class="bx bx-edit"></i> Edit
                                            </button>
                                            <button onclick="deleteMessage({{ $message->id }})" 
                                                    class="text-xs text-red-500 hover:text-red-700">
                                                <i class="bx bx-trash"></i> Delete
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class='bx bx-message-square-dots text-4xl mb-2'></i>
                                <p>No messages yet. Start the conversation!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Message Input Area -->
                    <div class="border-t border-gray-200 p-4">
                        <form id="chatForm" class="flex gap-2">
                            @csrf
                            <div class="flex-1">
                                <input type="text" 
                                       id="messageInput"
                                       name="message"
                                       class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20"
                                       placeholder="Type your message..."
                                       required>
                            </div>
                            <button type="submit" 
                                    class="px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors">
                                <i class='bx bx-send'></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $messages->links() }}
            </div>

            @push('scripts')
            <script>
                // Enable Pusher logging in development
                Pusher.logToConsole = true;

                // Initialize Laravel Echo
                window.Echo.join(`program.{{ $program->id }}`)
                    .listen('NewChatMessage', (e) => {
                        console.log('Received message:', e); // Debug log
                        const chat = e.chat;
                        const chatMessages = document.getElementById('chatMessages');
                        
                        // Handle deleted messages
                        if (chat.is_deleted) {
                            const messageToRemove = document.querySelector(`[data-message-id="${chat.id}"]`);
                            if (messageToRemove) {
                                messageToRemove.remove();
                            }
                            return;
                        }

                        // Handle new or updated messages
                        const existingMessage = document.querySelector(`[data-message-id="${chat.id}"]`);
                        if (existingMessage) {
                            existingMessage.remove();
                        }
                        
                        // Create new message element
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `flex gap-3 ${chat.sender_id === {{ Auth::id() }} ? 'flex-row-reverse' : ''}`;
                        messageDiv.dataset.messageId = chat.id;
                        
                        messageDiv.innerHTML = `
                            <div class="flex-shrink-0">
                                <img src="${chat.sender.profile_pic || '/images/default-avatar.png'}" 
                                     alt="${chat.sender.name}"
                                     class="w-10 h-10 rounded-full">
                            </div>
                            <div class="flex-1 ${chat.sender_id === {{ Auth::id() }} ? 'text-right' : ''}">
                                <div class="flex items-center gap-2 ${chat.sender_id === {{ Auth::id() }} ? 'justify-end' : 'justify-start'}">
                                    <span class="font-medium text-[#1a2235]">${chat.sender.name}</span>
                                    <span class="text-sm text-gray-500">Just now</span>
                                </div>
                                <div class="mt-1 p-3 rounded-lg ${chat.sender_id === {{ Auth::id() }} ? 'bg-[#ffb51b] text-[#1a2235]' : 'bg-gray-100 text-gray-700'}">
                                    <p class="whitespace-pre-wrap">${chat.message}</p>
                                    ${chat.is_edited ? '<span class="text-xs text-gray-500 mt-1 block">(edited)</span>' : ''}
                                </div>
                                ${chat.sender_id === {{ Auth::id() }} ? `
                                    <div class="flex items-center gap-2 mt-1 justify-end">
                                        <button onclick="editMessage(${chat.id}, '${chat.message}')" 
                                                class="text-xs text-gray-500 hover:text-gray-700">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                        <button onclick="deleteMessage(${chat.id})" 
                                                class="text-xs text-red-500 hover:text-red-700">
                                            <i class="bx bx-trash"></i> Delete
                                        </button>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                        
                        // Add message to chat
                        chatMessages.insertBefore(messageDiv, chatMessages.firstChild);
                        
                        // Scroll to bottom
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    });

                // Handle form submission
                document.getElementById('chatForm').addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const messageInput = document.getElementById('messageInput');
                    const message = messageInput.value.trim();
                    
                    if (!message) return;

                    try {
                        const response = await fetch('{{ route("program.chats.store", $program) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ message })
                        });

                        const data = await response.json();

                        if (response.ok) {
                            messageInput.value = '';
                            console.log('Message sent successfully:', data); // Debug log
                        } else {
                            console.error('Failed to send message:', data.error);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                });

                // Handle message deletion
                async function deleteMessage(messageId) {
                    if (!confirm('Are you sure you want to delete this message?')) return;

                    try {
                        const response = await fetch(`/programs/{{ $program->id }}/chats/${messageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            console.error('Failed to delete message:', data.error);
                        } else {
                            console.log('Message deleted successfully:', data); // Debug log
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }

                // Handle message editing
                async function editMessage(messageId, currentMessage) {
                    const newMessage = prompt('Edit your message:', currentMessage);
                    if (!newMessage || newMessage === currentMessage) return;

                    try {
                        const response = await fetch(`/programs/{{ $program->id }}/chats/${messageId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ message: newMessage })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            console.error('Failed to update message:', data.error);
                        } else {
                            console.log('Message updated successfully:', data); // Debug log
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                }
            </script>
            @endpush
        @endif
    </div>
@endsection 