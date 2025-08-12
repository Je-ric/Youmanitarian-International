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
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-1 text-xs text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-full transition-all chat-delete-btn"
                                                    data-message-id="{{ $message->id }}"
                                                    {{-- data-program-id="{{ $program->id }}" --}}
                                                    data-program-id="{{ $message->program_id }}"
                                                >
                                                    <i class="bx bx-trash mr-1"></i>
                                                    Delete
                                                </button>
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
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    console.log('🚀 jQuery loaded successfully!');

    // Chat Manager Object
    const ChatManager = {
        config: {
            programId: {{ isset($program) ? $program->id : 'null' }},
            userId: {{ Auth::id() }},
            routes: {
                store: '{{ isset($program) ? route("program.chats.store", $program) : "" }}',
                delete: '{{ isset($program) ? route("program.chats.destroy", [$program, ":messageId"]) : "" }}'
            },
            selectors: {
                form: 'form[action*="program.chats.store"], form[action*="chats"], #messageForm',
                input: 'input[name="message"]',
                chatMessages: '#chatMessages',
                deleteBtn: '.chat-delete-btn'
            }
        },

        state: {
            isSubmitting: false,
            isDeleting: false
        },

        init: function() {
            this.bindEvents();
            this.setupRealTimeConnection();
            console.log('🚀 Chat Manager initialized');
        },

        bindEvents: function() {
            const self = this;

            // Form submission
            console.log('🔍 Looking for form with selector:', this.config.selectors.form);
            const form = $(this.config.selectors.form);
            console.log('🔍 Found form:', form.length, 'forms');

            if (form.length > 0) {
                form.on('submit', function(e) {
                    console.log('🚀 Form submit event caught!');
                    e.preventDefault();
                    self.sendMessage($(this));
                });
            } else {
                console.log('❌ No form found with selector:', this.config.selectors.form);

                // Fallback: Catch any form submission in the chat area
                console.log('🔄 Setting up fallback form handler');
                $('#chatMessages').closest('.flex').find('form').on('submit', function(e) {
                    console.log('🚀 Fallback form submit caught!');
                    e.preventDefault();
                    self.sendMessage($(this));
                });
            }

            // Delete message
            $(document).on('click', this.config.selectors.deleteBtn, function(e) {
                e.preventDefault();
                self.deleteMessage($(this));
            });

            // Keyboard shortcuts
            $(this.config.selectors.input).on('keydown', function(e) {
                if (e.ctrlKey && e.key === 'Enter') {
                    e.preventDefault();
                    self.sendMessage($(self.config.selectors.form));
                }
            });
        },

        sendMessage: function(form) {
            if (this.state.isSubmitting) {
                this.showToast('Please wait, message is being sent...', 'warning');
                return;
            }

            const input = $(this.config.selectors.input);
            const message = input.val().trim();

            if (!message) {
                this.showToast('Please enter a message', 'error');
                return;
            }

            this.state.isSubmitting = true;
            this.setSubmitButtonState(true);

            $.ajax({
                url: this.config.routes.store,
                method: 'POST',
                data: {
                    message: message,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: (response) => {
                    if (response.success && response.chat) {
                        // Add message to DOM immediately (like delete does)
                        this.appendMessage(response.chat);
                        input.val('');
                        this.scrollToBottom();
                        this.showToast('Message sent successfully!', 'success');

                        // Optional: Broadcast to other users via real-time
                        // (but don't rely on it for the sender's view)
                        if (typeof window.Echo !== 'undefined') {
                            console.log('🔔 Broadcasting message to other users');
                        }
                    } else {
                        this.showToast(response.error || 'Failed to send message', 'error');
                    }
                },
                error: (xhr) => {
                    let errorMsg = 'Network error. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    this.showToast(errorMsg, 'error');
                },
                complete: () => {
                    this.state.isSubmitting = false;
                    this.setSubmitButtonState(false);
                }
            });
        },

        deleteMessage: function(btn) {
            if (this.state.isDeleting) {
                this.showToast('Please wait, deleting message...', 'warning');
                return;
            }

            if (!confirm('Are you sure you want to delete this message?')) {
                return;
            }

            const messageId = btn.data('message-id');
            const programId = btn.data('program-id');

            if (!messageId || !programId) {
                this.showToast('Missing message information', 'error');
                return;
            }

            this.state.isDeleting = true;
            btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin mr-1"></i>Deleting...');

            const deleteUrl = this.config.routes.delete.replace(':messageId', messageId);

            $.ajax({
                url: deleteUrl,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: (response) => {
                    if (response.success) {
                        this.removeMessage(messageId);
                        this.showToast('Message deleted successfully!', 'success');
                    } else {
                        this.showToast(response.error || 'Failed to delete message', 'error');
                    }
                },
                error: (xhr) => {
                    let errorMsg = 'Network error. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    this.showToast(errorMsg, 'error');
                },
                complete: () => {
                    this.state.isDeleting = false;
                    btn.prop('disabled', false).html('<i class="bx bx-trash mr-1"></i>Delete');
                }
            });
        },

        appendMessage: function(chat) {
            const isOwn = chat.sender_id == this.config.userId;
            console.log('📝 Appending message to DOM:', {
                message: chat.message,
                sender: chat.sender.name,
                isOwn: isOwn,
                messageId: chat.id
            });

            const msgDiv = $(`
                <div class="flex gap-4 mb-6 ${isOwn ? 'flex-row-reverse' : ''}" data-message-id="${chat.id}">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img src="${chat.sender.profile_pic || '/images/default-avatar.png'}"
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
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-1 text-xs text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-full transition-all chat-delete-btn"
                                data-message-id="${chat.id}"
                                data-program-id="${chat.program_id}"
                            >
                                <i class="bx bx-trash mr-1"></i>
                                Delete
                            </button>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `);

            $(this.config.selectors.chatMessages).append(msgDiv);
            console.log('✅ Message successfully added to DOM');
        },

        removeMessage: function(messageId) {
            $(`[data-message-id="${messageId}"]`).fadeOut(300, function() {
                $(this).remove();
            });
        },

        scrollToBottom: function() {
            const chatMessages = $(this.config.selectors.chatMessages);
            chatMessages.animate({
                scrollTop: chatMessages[0].scrollHeight
            }, 500);
        },

        setSubmitButtonState: function(isLoading) {
            const submitBtn = $(this.config.selectors.form).find('button[type="submit"]');
            const input = $(this.config.selectors.input);

            if (isLoading) {
                submitBtn.prop('disabled', true)
                    .html('<i class="bx bx-loader-alt bx-spin text-xl"></i>')
                    .addClass('opacity-75');
                input.prop('disabled', true);
            } else {
                submitBtn.prop('disabled', false)
                    .html('<i class="bx bx-send text-xl"></i>')
                    .removeClass('opacity-75');
                input.prop('disabled', false);
            }
        },

        setupRealTimeConnection: function() {
            // Check if Laravel Echo is available
            if (typeof window.Echo !== 'undefined') {
                window.Echo.channel(`program.${this.config.programId}`)
                    .listen('NewChatMessage', (event) => {
                        // Only handle messages from OTHER users (not the sender)
                        if (event.chat.sender_id != this.config.userId) {
                            this.handleRealTimeMessage(event.chat);
                        }
                    })
                    .listen('ChatMessageDeleted', (event) => {
                        this.handleRealTimeMessageDeleted(event.messageId);
                    });
                console.log('🔔 Real-time connection established for other users');
            } else {
                console.log('⚠️ Laravel Echo not available - real-time disabled');
            }
        },

        handleRealTimeMessage: function(chat) {
            // Always append real-time messages (they come from other users)
            this.appendMessage(chat);
            this.scrollToBottom();
            this.showToast(`New message from ${chat.sender.name}`, 'info');
        },

        handleRealTimeMessageDeleted: function(messageId) {
            this.removeMessage(messageId);
        },

        showToast: function(message, type = 'info') {
            // Create toast element
            const toast = $(`
                <div class="fixed top-4 right-4 z-50 max-w-sm w-full bg-white border border-gray-200 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full">
                    <div class="flex items-center p-4">
                        <div class="flex-shrink-0">
                            <i class="bx ${this.getToastIcon(type)} text-xl ${this.getToastColor(type)}"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">${message}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <button type="button" class="text-gray-400 hover:text-gray-600">
                                <i class="bx bx-x text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `);

            // Add to page
            $('body').append(toast);

            // Show toast
            setTimeout(() => toast.removeClass('translate-x-full'), 100);

            // Auto-hide after 5 seconds
            setTimeout(() => {
                toast.addClass('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 5000);

            // Close button functionality
            toast.find('button').on('click', function() {
                toast.addClass('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            });
        },

        getToastIcon: function(type) {
            const icons = {
                success: 'bx-check-circle',
                error: 'bx-x-circle',
                warning: 'bx-error',
                info: 'bx-info-circle'
            };
            return icons[type] || icons.info;
        },

        getToastColor: function(type) {
            const colors = {
                success: 'text-green-500',
                error: 'text-red-500',
                warning: 'text-yellow-500',
                info: 'text-blue-500'
            };
            return colors[type] || colors.info;
        }
    };

    // Initialize Chat Manager
    if (ChatManager.config.programId) {
        ChatManager.init();
    }

    // Test CSRF token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    if (csrfToken) {
        console.log('✅ CSRF token found:', csrfToken.substring(0, 20) + '...');
    } else {
        console.log('❌ CSRF token not found!');
    }
});
</script>
@endpush

@endsection
