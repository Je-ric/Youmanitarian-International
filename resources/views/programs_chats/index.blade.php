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

                // Global variables
                let isSubmitting = false;
                let currentEditId = null;

                // Initialize Laravel Echo
                window.Echo.channel(`program.{{ $program->id }}`)
                    .listen('NewChatMessage', (e) => {
                        console.log('Received message:', e); // Debug log
                        const chat = e.chat;
                        const chatMessages = document.getElementById('chatMessages');
                        
                        // Handle deleted messages
                        if (chat.is_deleted) {
                            const messageToRemove = document.querySelector(`[data-message-id="${chat.id}"]`);
                            if (messageToRemove) {
                                messageToRemove.remove();
                                showToast('Message deleted', 'success');
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
                                <img src="${chat.sender.profile_pic ? chat.sender.profile_pic : '/images/default-avatar.png'}" 
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
                                        <button onclick="editMessage(${chat.id}, '${chat.message.replace(/'/g, "\\'")}')" 
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
                    })
                    .error((error) => {
                        console.error('Echo connection error:', error);
                        showToast('Connection error. Messages may not update in real-time.', 'error');
                    });

                // Handle form submission
                document.getElementById('chatForm').addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    if (isSubmitting) return;
                    
                    const messageInput = document.getElementById('messageInput');
                    const submitButton = this.querySelector('button[type="submit"]');
                    const message = messageInput.value.trim();
                    
                    if (!message) return;

                    // Show loading state
                    isSubmitting = true;
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';
                    messageInput.disabled = true;

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

                        if (response.ok && data.success) {
                            messageInput.value = '';
                            showToast('Message sent successfully!', 'success');
                        } else {
                            showToast(data.error ? data.error : 'Failed to send message', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('Network error. Please try again.', 'error');
                    } finally {
                        // Reset loading state
                        isSubmitting = false;
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<i class="bx bx-send"></i>';
                        messageInput.disabled = false;
                        messageInput.focus();
                    }
                });

                // Handle message deletion
                async function deleteMessage(messageId) {
                    if (!confirm('Are you sure you want to delete this message?')) return;

                    const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
                    if (!messageElement) return;

                    // Show loading state
                    const deleteButton = messageElement.querySelector('button[onclick*="deleteMessage"]');
                    const originalContent = deleteButton.innerHTML;
                    deleteButton.disabled = true;
                    deleteButton.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';

                    try {
                        const response = await fetch(`/programs/{{ $program->id }}/chats/${messageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            messageElement.remove();
                            showToast('Message deleted successfully!', 'success');
                        } else {
                            showToast(data.error ? data.error : 'Failed to delete message', 'error');
                            // Reset button state
                            deleteButton.disabled = false;
                            deleteButton.innerHTML = originalContent;
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('Network error. Please try again.', 'error');
                        // Reset button state
                        deleteButton.disabled = false;
                        deleteButton.innerHTML = originalContent;
                    }
                }

                // Handle message editing
                async function editMessage(messageId, currentMessage) {
                    if (currentEditId) return; // Prevent multiple edits

                    const newMessage = prompt('Edit your message:', currentMessage);
                    if (!newMessage || newMessage === currentMessage) return;

                    currentEditId = messageId;
                    const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
                    const editButton = messageElement.querySelector('button[onclick*="editMessage"]');
                    const originalContent = editButton.innerHTML;
                    
                    // Show loading state
                    editButton.disabled = true;
                    editButton.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';

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

                        if (response.ok && data.success) {
                            // Update the message content in the DOM
                            const messageText = messageElement.querySelector('p');
                            messageText.textContent = newMessage;
                            
                            // Add edited badge if not present
                            const bubble = messageElement.querySelector('.rounded-lg');
                            if (!bubble.querySelector('.text-xs')) {
                                bubble.innerHTML += '<span class="text-xs text-gray-500 mt-1 block">(edited)</span>';
                            }
                            
                            showToast('Message updated successfully!', 'success');
                        } else {
                            showToast(data.error ? data.error : 'Failed to update message', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('Network error. Please try again.', 'error');
                    } finally {
                        // Reset button state
                        editButton.disabled = false;
                        editButton.innerHTML = originalContent;
                        currentEditId = null;
                    }
                }

                // Toast notification function
                function showToast(message, type) {
                    // Set default type if not provided
                    type = type || 'info';
                    
                    // Create toast element
                    const toast = document.createElement('div');
                    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
                    
                    let bgColor = 'bg-blue-500';
                    if (type === 'success') {
                        bgColor = 'bg-green-500';
                    } else if (type === 'error') {
                        bgColor = 'bg-red-500';
                    } else if (type === 'warning') {
                        bgColor = 'bg-yellow-500';
                    }
                    
                    toast.className += ` ${bgColor} text-white`;
                    
                    toast.innerHTML = `
                        <div class="flex items-center gap-2">
                            <i class="bx ${type === 'success' ? 'bx-check-circle' : 
                                          type === 'error' ? 'bx-error-circle' : 
                                          type === 'warning' ? 'bx-warning' : 'bx-info-circle'}"></i>
                            <span>${message}</span>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                    `;
                    
                    document.body.appendChild(toast);
                    
                    // Animate in
                    setTimeout(() => {
                        toast.classList.remove('translate-x-full');
                    }, 100);
                    
                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        toast.classList.add('translate-x-full');
                        setTimeout(() => {
                            if (toast.parentElement) {
                                toast.remove();
                            }
                        }, 300);
                    }, 5000);
                }

                // Add keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    const messageInput = document.getElementById('messageInput');
                    
                    // Ctrl+Enter to send message
                    if (e.ctrlKey && e.key === 'Enter' && document.activeElement === messageInput) {
                        e.preventDefault();
                        document.getElementById('chatForm').dispatchEvent(new Event('submit'));
                    }
                    
                    // Escape to cancel edit
                    if (e.key === 'Escape' && currentEditId) {
                        currentEditId = null;
                        const editButton = document.querySelector(`[data-message-id="${currentEditId}"] button[onclick*="editMessage"]`);
                        if (editButton) {
                            editButton.disabled = false;
                            editButton.innerHTML = '<i class="bx bx-edit"></i> Edit';
                        }
                    }
                });

                // Focus message input on page load
                document.addEventListener('DOMContentLoaded', function() {
                    const messageInput = document.getElementById('messageInput');
                    if (messageInput) {
                        messageInput.focus();
                    }
                });
            </script>
            @endpush
        @endif
    </div>
@endsection 