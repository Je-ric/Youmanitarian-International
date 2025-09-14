@extends('layouts.sidebar_final')
{{-- modal (participants lists) - dropdown "accordion" (consultation hours) --}}
@section('content')
    <style>
        /* Global Layout */
        body {
            overflow: hidden !important;
            /* Prevent page scrolling */
        }

        /* Chat Container */
        .chat-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Messages Area - Scrollable */
        #chatMessages {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scroll-behavior: smooth;
            padding-bottom: 120px;
        }

        /* Custom Scrollbar */
        #chatMessages::-webkit-scrollbar {
            width: 6px;
        }

        #chatMessages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #chatMessages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        #chatMessages::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Sidebar Scrollable */
        .sidebar-scrollable {
            overflow-y: auto;
            height: calc(100vh - 80px);
            /* Account for header */
        }

        .sidebar-scrollable::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scrollable::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scrollable::-webkit-scrollbar-thumb {
            background: #e0e0e0;
            border-radius: 4px;
        }

        /* Compact Message Design */
        .message-bubble {
            max-width: 70%;
            word-wrap: break-word;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }

        .message-content {
            font-size: 14px;
            line-height: 1.4;
            padding: 8px 12px;
        }

        .message-time {
            font-size: 11px;
            opacity: 0.7;
        }

        .delete-btn {
            opacity: 0;
            transition: all 0.2s ease;
        }

        .message-wrapper:hover .delete-btn {
            opacity: 1;
        }

        /* Fixed Input Bar */
        .chat-input-fixed {
            position: sticky;
            bottom: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            z-index: 10;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .chat-container {
                height: 100vh;
            }

            .sidebar-mobile {
                position: fixed;
                top: 0;
                right: -100%;
                height: 100vh;
                width: 80vw;
                max-width: 320px;
                background: white;
                z-index: 50;
                transition: right 0.3s ease;
                box-shadow: -4px 0 15px rgba(0, 0, 0, 0.1);
            }

            .sidebar-mobile.show {
                right: 0;
            }

            .mobile-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 40;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .mobile-overlay.show {
                opacity: 1;
                visibility: visible;
            }

            .message-bubble {
                max-width: 85%;
            }
        }

        /* Compact Sidebar Items */
        .program-item {
            padding: 12px 16px;
            transition: all 0.2s ease;
        }

        .program-item:hover {
            background-color: rgba(255, 181, 27, 0.08);
        }

        .program-item.active {
            background-color: rgba(255, 181, 27, 0.15);
            border-right: 3px solid #ffb51b;
        }

        /* Replace old .message-bubble/.chat-bubble styles with unified consultation style */
        .chat-bubble {
            max-width: 70%;
            word-wrap: break-word;
            border-radius: 18px;
            padding: 8px 12px;
            font-size: 14px;
            line-height: 1.4;
            margin: 0 4px;
        }

        .chat-start .chat-bubble {
            background-color: #b37f13;
            color: #fff;
        }

        .chat-end .chat-bubble {
            background-color: #1a2235;
            color: #fff;
        }

        .chat-header {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 2px;
            opacity: .8;
        }

        .chat-time {
            font-size: 10px;
            opacity: .6;
            margin-left: 4px;
        }

        /* Footer (delete area) */
        .chat-footer-actions {
            font-size: 10px;
            opacity: .65;
        }

        @media (max-width: 768px) {
            .chat-bubble {
                max-width: 85%;
            }
        }

        /* Remove unused old classes (optional, or leave if referenced elsewhere) */
    </style>

    <div class="chat-container">
        <!-- Mobile Overlay -->
        <div class="mobile-overlay md:hidden" id="mobileOverlay"></div>

        <!-- Main Chat Layout -->
        <div class="flex h-full">
            <!-- Chat Interface (Main Area) -->
            <div class="flex-1 flex flex-col min-w-0">
                @if (isset($program))
                    <!-- Chat Header -->
                    <div class="px-4 py-3 bg-gradient-to-r from-[#1a2235] to-[#2a3447] text-white flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <div
                                    class="flex items-center justify-center w-8 h-8 bg-[#ffb51b] rounded-lg mr-3 flex-shrink-0">
                                    <i class='bx bx-message-square-dots text-[#1a2235] text-lg'></i>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold truncate">{{ $program->title }}</h3>
                                    <p class="text-xs text-gray-300">{{ $program->volunteers->count() }} participants</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <!-- Mobile Sidebar Toggle -->
                                <x-button id="mobileSidebarToggle" variant="mobile-toggle">
                                    <i class='bx bx-menu text-lg'></i>
                                </x-button>

                                <x-button href="{{ route('programs.index', $program) }}" variant="glass-button">
                                    <i class='bx bx-arrow-back mr-1 text-sm'></i>
                                    <span class="hidden sm:inline text-sm"></span>
                                </x-button>

                                <x-button variant="glass-button"
                                    onclick="document.getElementById('programParticipants-modal-{{ $program->id }}').showModal(); return false;">
                                    <i class='bx bx-group'></i> Participants
                                </x-button>

                                @include('programs_chats.modals.programParticipantsModal', [
                                    'program' => $program,
                                ])

                            </div>
                        </div>
                    </div>


                    <!-- Messages Area (Scrollable) -->
                    <div id="chatMessages" class="flex-1 px-4 py-2 bg-gray-50">
                        @forelse($messages as $message)
                            @php $mine = $message->sender_id === Auth::id(); @endphp
                            <div class="chat {{ $mine ? 'chat-end' : 'chat-start' }}" data-message-id="{{ $message->id }}">
                                <div class="flex flex-col {{ $mine ? 'items-end text-right' : '' }} mb-2">
                                    <div class="chat-header flex items-center gap-1 {{ $mine ? 'justify-end' : '' }}">
                                        {{ $message->sender->name }}
                                        <time class="chat-time"
                                              datetime="{{ $message->created_at->toIso8601String() }}"
                                              data-time="{{ $message->created_at->toIso8601String() }}">
                                            {{ $message->created_at->diffForHumans() }}
                                        </time>
                                        @if($message->is_edited)
                                            <span class="italic opacity-60">(edited)</span>
                                        @endif
                                    </div>
                                    <div class="chat-bubble">{!! nl2br(e($message->message)) !!}</div>
                                    @if($mine)
                                        <div class="chat-footer-actions mt-1 flex items-center gap-2">
                                            <button type="button"
                                                    class="chat-delete-btn text-red-500 hover:text-red-600 transition"
                                                    data-message-id="{{ $message->id }}"
                                                    data-program-id="{{ $message->program_id }}"
                                                    data-delete-url="{{ route('program.chats.destroy', [$program, $message->id]) }}"
                                                    title="Delete message">
                                                <i class="bx bx-trash text-sm"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div id="programChatEmptyState">
                                <x-empty-state
                                    icon="bx bx-message-square-dots"
                                    title="No messages yet"
                                    description="Start the conversation."
                                />
                            </div>
                        @endforelse
                    </div>

                    <!-- Fixed Input Bar -->
                    <div class="chat-input-fixed p-4 bg-white">
                        <form action="{{ route('program.chats.store', $program) }}" method="POST"
                            class="flex gap-3 items-end">
                            @csrf
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="text" id="messageInput" name="message"
                                        class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-full text-gray-800 placeholder-gray-500 transition-all duration-200 focus:bg-white focus:ring-2 focus:ring-[#ffb51b] focus:outline-none resize-none"
                                        placeholder="Type a message..." required autocomplete="off">
                                </div>
                            </div>
                            <button type="submit"
                                class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-[#ffb51b] to-[#e6a319] text-[#1a2235] rounded-full hover:from-[#e6a319] hover:to-[#cc9116] transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#ffb51b]/50 flex-shrink-0">
                                <i class='bx bx-send text-lg'></i>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- No Program Selected -->
                    <div class="flex flex-col items-center justify-center h-full text-center py-24">
                        <div id="programChatEmptyState">
                            <x-empty-state
                                icon="bx bx-message-square-dots"
                                title="Select a program chat"
                                description="Choose a program from the sidebar to start chatting."
                            />
                        </div>
                        <button
                            class="md:hidden inline-flex items-center px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg font-medium hover:bg-[#e6a319] transition-colors mt-4"
                            id="mobileSidebarToggleEmpty">
                            <i class='bx bx-list-ul mr-2'></i>
                            Show Programs
                        </button>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="hidden md:block w-80 flex-shrink-0 bg-white border-l border-gray-200">
                <div class="flex flex-col h-full">
                    <!-- Sidebar Header -->
                    <div class="px-4 py-4 border-b border-gray-100 bg-gradient-to-r from-[#ffb51b]/5 to-[#e6a319]/5">
                        <h2 class="text-lg font-bold text-[#1a2235] flex items-center">
                            <i class='bx bx-group text-[#ffb51b] mr-2'></i>
                            Program Chats
                        </h2>
                    </div>

                    <!-- Sidebar Content (Scrollable) -->
                    <div class="sidebar-scrollable">
                        @if ($programs->isNotEmpty())
                            @foreach ($programs as $p)
                                <a href="{{ route('program.chats.show', $p) }}"
                                    class="program-item flex items-center gap-3 border-b border-gray-50 {{ isset($program) && $program->id === $p->id ? 'active' : '' }}">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 bg-blue-50 rounded-lg flex-shrink-0">
                                        <i class='bx bx-message-square-dots text-blue-600'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-semibold text-[#1a2235] truncate">{{ $p->title }}</h3>
                                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                            <span>{{ $p->volunteers->count() }}
                                                {{ $p->volunteers->count() === 1 ? 'volunteer' : 'volunteers' }}</span>
                                            <span>•</span>
                                            <span>{{ $p->chats->count() }}
                                                {{ $p->chats->count() === 1 ? 'message' : 'messages' }}</span>
                                        </div>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap flex-shrink-0 {{ $p->created_by === Auth::id() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $p->created_by === Auth::id() ? 'Host' : 'Member' }}
                                    </span>
                                </a>
                            @endforeach
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-center py-12 px-4">
                                <div class="w-16 h-16 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-message-square-dots text-[#ffb51b] text-2xl'></i>
                                </div>
                                <h3 class="text-md font-semibold text-gray-700 mb-2">No program chats</h3>
                                <p class="text-gray-500 text-sm">You're not part of any program chats yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Mobile Sidebar -->
            <div class="sidebar-mobile md:hidden" id="mobileSidebar">
                <div class="flex flex-col h-full">
                    <!-- Mobile Sidebar Header -->
                    <div
                        class="px-4 py-4 border-b border-gray-100 bg-gradient-to-r from-[#ffb51b]/5 to-[#e6a319]/5 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-[#1a2235] flex items-center">
                            <i class='bx bx-group text-[#ffb51b] mr-2'></i>
                            Program Chats
                        </h2>
                        <button
                            class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                            id="closeMobileSidebar">
                            <i class='bx bx-x text-xl'></i>
                        </button>
                    </div>

                    <!-- Mobile Sidebar Content -->
                    <div class="flex-1 overflow-y-auto">
                        @if ($programs->isNotEmpty())
                            @foreach ($programs as $p)
                                <a href="{{ route('program.chats.show', $p) }}"
                                    class="program-item flex items-center gap-3 border-b border-gray-50 {{ isset($program) && $program->id === $p->id ? 'active' : '' }}">
                                    <div
                                        class="flex items-center justify-center w-10 h-10 bg-blue-50 rounded-lg flex-shrink-0">
                                        <i class='bx bx-message-square-dots text-blue-600'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-semibold text-[#1a2235] truncate">{{ $p->title }}</h3>
                                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                            <span>{{ $p->volunteers->count() }}
                                                {{ $p->volunteers->count() === 1 ? 'volunteer' : 'volunteers' }}</span>
                                            <span>•</span>
                                            <span>{{ $p->chats->count() }}
                                                {{ $p->chats->count() === 1 ? 'message' : 'messages' }}</span>
                                        </div>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap flex-shrink-0 {{ $p->created_by === Auth::id() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $p->created_by === Auth::id() ? 'Host' : 'Member' }}
                                    </span>
                                </a>
                            @endforeach
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-center py-12 px-4">
                                <div class="w-16 h-16 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-message-square-dots text-[#ffb51b] text-2xl'></i>
                                </div>
                                <h3 class="text-md font-semibold text-gray-700 mb-2">No program chats</h3>
                                <p class="text-gray-500 text-sm">You're not part of any program chats yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {
                console.log('✅ Connected to server');

                // Mobile Sidebar Functionality
                const mobileSidebar = $('#mobileSidebar');
                const mobileOverlay = $('#mobileOverlay');

                function showMobileSidebar() {
                    mobileSidebar.addClass('show');
                    mobileOverlay.addClass('show');
                    $('body').addClass('overflow-hidden');
                }

                function hideMobileSidebar() {
                    mobileSidebar.removeClass('show');
                    mobileOverlay.removeClass('show');
                    $('body').removeClass('overflow-hidden');
                }

                $('#mobileSidebarToggle, #mobileSidebarToggleEmpty').on('click', showMobileSidebar);
                $('#closeMobileSidebar, #mobileOverlay').on('click', hideMobileSidebar);

                // Chat Manager Object
                const ChatManager = {
                    config: {
                        programId: {{ isset($program) ? $program->id : 'null' }},
                        userId: {{ Auth::id() }},
                        routes: {
                            store: '{{ isset($program) ? route('program.chats.store', $program) : '' }}',
                            // Safe template placeholder (no URL encoding)
                            deleteTemplate: '{{ isset($program) ? route('program.chats.destroy', [$program, 'CHAT_ID']) : '' }}'
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
                        this.scrollToBottom();
                        console.log('✅ Chat system ready');
                    },

                    bindEvents: function() {
                        const self = this;

                        // Form submission
                        const form = $(this.config.selectors.form);

                        if (form.length > 0) {
                            form.on('submit', function(e) {
                                e.preventDefault();
                                self.sendMessage($(this));
                            });
                        } else {
                            // Fallback form handler
                            $('#chatMessages').closest('.flex').find('form').on('submit', function(e) {
                                e.preventDefault();
                                self.sendMessage($(this));
                            });
                        }

                        // Delete message
                        $(document).on('click', this.config.selectors.deleteBtn, function(e) {
                            e.preventDefault();
                            self.deleteMessage($(this));
                        });

                        // Enter key to send (Shift+Enter for new line)
                        $(this.config.selectors.input).on('keydown', function(e) {
                            if (e.key === 'Enter' && !e.shiftKey) {
                                e.preventDefault();
                                self.sendMessage($(self.config.selectors.form));
                            }
                        });
                    },

                    sendMessage: function(form) {
                        if (this.state.isSubmitting) {
                            return;
                        }

                        const input = $(this.config.selectors.input);
                        const message = input.val().trim();

                        if (!message) {
                            return;
                        }

                        console.log('📝 Sending message...');
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
                                    console.log('📩 Message sent successfully');
                                    this.appendMessage(response.chat);
                                    input.val('');
                                    this.scrollToBottom();

                                    // Hide mobile sidebar on mobile after sending
                                    if (window.innerWidth < 768) {
                                        hideMobileSidebar();
                                    }
                                } else {
                                    console.log('❌ Failed to send message:', response.error);
                                }
                            },
                            error: (xhr) => {
                                console.log('❌ Network error:', xhr.responseText);
                            },
                            complete: () => {
                                this.state.isSubmitting = false;
                                this.setSubmitButtonState(false);
                            }
                        });
                    },

                    deleteMessage: function(btn) {
                        if (this.state.isDeleting) return;

                        const messageId = btn.data('message-id');
                        const programId = btn.data('program-id');
                        if (!messageId || !programId) return;

                        if (!confirm('Delete this message?')) return;

                        this.state.isDeleting = true;
                        btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin text-xs"></i>');

                        // Prefer per-button URL, fallback to template
                        const deleteUrl = btn.data('delete-url') ||
                            this.config.routes.deleteTemplate.replace('CHAT_ID', messageId);

                        $.ajax({
                                url: deleteUrl,
                                method: 'DELETE',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                }
                            })
                            .done((response, textStatus, xhr) => {
                                // JSON or empty 204 both count as success
                                if (!response || response.success !== false) {
                                    this.removeMessage(messageId);
                                } else {
                                    btn.prop('disabled', false).html('<i class="bx bx-trash text-xs"></i>');
                                }
                            })
                            .fail((xhr) => {
                                // If server sent 200/204 without JSON, still remove
                                if (xhr.status === 200 || xhr.status === 204) {
                                    this.removeMessage(messageId);
                                } else {
                                    btn.prop('disabled', false).html('<i class="bx bx-trash text-xs"></i>');
                                }
                            })
                            .always(() => {
                                this.state.isDeleting = false;
                            });
                    },

                    // Keep a single removeMessage definition
                    removeMessage: function(messageId) {
                        const $el = $(`[data-message-id="${messageId}"]`);
                        if ($el.length) {
                            $el.fadeOut(200, function() {
                                $(this).remove();
                            });
                        }
                    },


                    hideEmptyState: function(){
                        $('#programChatEmptyState').remove();
                    },

                    appendMessage: function(chat) {
                        this.hideEmptyState();
                        const isOwn = chat.sender_id == this.config.userId;
                        const safeMsg = $('<div>').text(chat.message || '').html().replace(/\n/g, '<br>');
                        const deleteUrl = this.config.routes.deleteTemplate
                            ? this.config.routes.deleteTemplate.replace('CHAT_ID', chat.id)
                            : '';

                        const nameEsc = $('<div>').text(chat.sender.name || 'User').html();
                        const createdIso = chat.created_at || new Date().toISOString();

                        const html = `
                            <div class="chat ${isOwn ? 'chat-end':'chat-start'}" data-message-id="${chat.id}">
                                <div class="flex flex-col ${isOwn ? 'items-end text-right':''} mb-2">
                                    <div class="chat-header flex items-center gap-1 ${isOwn ? 'justify-end':''}">
                                        ${nameEsc}
                                        <time class="chat-time" datetime="${createdIso}">Just now</time>
                                    </div>
                                    <div class="chat-bubble">${safeMsg}</div>
                                    ${isOwn ? `
                                        <div class="chat-footer-actions mt-1 flex items-center gap-2">
                                            <button type="button"
                                                    class="chat-delete-btn text-red-500 hover:text-red-600 transition"
                                                    data-message-id="${chat.id}"
                                                    data-program-id="${chat.program_id}"
                                                    data-delete-url="${deleteUrl}"
                                                    title="Delete message">
                                                <i class="bx bx-trash text-sm"></i>
                                            </button>
                                        </div>` : ''}
                                </div>
                            </div>
                        `;
                        $(this.config.selectors.chatMessages).append(html);
                        this.scrollToBottom();
                    },

                    scrollToBottom: function() {
                        const el = document.getElementById('chatMessages');
                        if (!el) return;
                        el.scrollTo({
                            top: el.scrollHeight,
                            behavior: 'smooth'
                        });
                    },


                    setSubmitButtonState: function(isLoading) {
                        const submitBtn = $(this.config.selectors.form).find('button[type="submit"]');
                        const input = $(this.config.selectors.input);

                        if (isLoading) {
                            submitBtn.prop('disabled', true)
                                .html('<i class="bx bx-loader-alt bx-spin text-lg"></i>')
                                .addClass('opacity-75');
                            input.prop('disabled', true);
                        } else {
                            submitBtn.prop('disabled', false)
                                .html('<i class="bx bx-send text-lg"></i>')
                                .removeClass('opacity-75');
                            input.prop('disabled', false);
                        }
                    },

                    setupRealTimeConnection: function() {
                        // Check if Laravel Echo is available
                        if (typeof window.Echo !== 'undefined') {
                            console.log('🔔 Setting up real-time connection...');
                            window.Echo.channel(`program.${this.config.programId}`)
                                .listen('NewChatMessage', (event) => {
                                    // Only handle messages from OTHER users (not the sender)
                                    if (event.chat.sender_id != this.config.userId) {
                                        console.log('📩 New message received from another user');
                                        this.handleRealTimeMessage(event.chat);
                                    }
                                })
                                .listen('ChatMessageDeleted', (event) => {
                                    console.log('🗑️ Message deleted by another user');
                                    this.handleRealTimeMessageDeleted(event.messageId);
                                });
                            console.log('✅ Real-time connection established');
                        } else {
                            console.log('⚠️ Real-time features disabled (Laravel Echo not available)');
                        }
                    },

                    handleRealTimeMessage: function(chat) {
                        // Always append real-time messages (they come from other users)
                        this.appendMessage(chat); // appendMessage already hides empty state
                        this.scrollToBottom();
                    },

                    handleRealTimeMessageDeleted: function(messageId) {
                        this.removeMessage(messageId);
                    },
                };

                // Initialize Chat Manager
                if (ChatManager.config.programId) {
                    ChatManager.init();
                } else {
                    console.log('💡 Select a program to start chatting');
                }

                // Test CSRF token
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                if (csrfToken) {
                    console.log('✅ Security token verified');
                } else {
                    console.log('❌ Security token missing - some features may not work');
                }

                // Auto-focus message input on desktop
                if (window.innerWidth >= 768 && ChatManager.config.programId) {
                    $(ChatManager.config.selectors.input).focus();
                }
            });
        </script>
    @endpush

@endsection
