@extends('layouts.sidebar_final')

@section('content')
    {{-- Replicated layout styling from program chats --}}
    <style>
        body {
            overflow: hidden !important;
        }

        .chat-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #consultationMessages {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scroll-behavior: smooth;
            padding-bottom: 80px;
            /* Increased from 20px to account for input height */
        }

        #consultationMessages::-webkit-scrollbar {
            width: 6px;
        }

        #consultationMessages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #consultationMessages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        #consultationMessages::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .sidebar-scrollable {
            overflow-y: auto;
            height: calc(100vh - 80px);
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

        .chat-input-fixed {
            position: sticky;
            bottom: 0;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            z-index: 10;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .chat-footer-actions { font-size:10px; opacity:.65; }

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
                background: #fff;
                z-index: 50;
                transition: right .3s ease;
                box-shadow: -4px 0 15px rgba(0, 0, 0, .1);
            }

            .sidebar-mobile.show {
                right: 0;
            }

            .mobile-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .5);
                z-index: 40;
                opacity: 0;
                visibility: hidden;
                transition: all .3s ease;
            }

            .mobile-overlay.show {
                opacity: 1;
                visibility: visible;
            }

            .chat-bubble {
                max-width: 85%;
            }

            #consultationMessages { padding-bottom: 120px; }
            /*  para hindi puma-ilalim yung chats sa input */
        }

        .thread-item {
            padding: 12px 16px;
            transition: all .2s ease;
            border-radius: 8px;
            margin: 4px 8px;
        }

        .thread-item:hover {
            background: rgba(255, 181, 27, 0.08);
        }

        .thread-item.active {
            background: rgba(255, 181, 27, 0.15);
            border-left: 3px solid #ffb51b;
        }

        .thread-time {
            font-size: 11px;
            color: #65676b;
            white-space: nowrap;
        }
    </style>

    <div class="chat-container">
        <!-- Mobile Overlay -->
        <div class="mobile-overlay md:hidden" id="mobileOverlay"></div>

        <div class="flex h-full">
            <!-- Main Conversation Area -->
            <div class="flex-1 flex flex-col min-w-0">
                @if (isset($thread))
                    <!-- Header -->
                    <div class="px-4 py-3 bg-gradient-to-r from-[#1a2235] to-[#2a3447] text-white flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <div class="mr-3">
                                    <x-user-avatar :user="$other" size="10" bare />
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold truncate">
                                        {{ $other->name }}
                                    </h3>
                                    <p class="text-xs text-gray-300">
                                        Thread #{{ $thread->id }} • {{ ucfirst($thread->status) }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-button id="mobileSidebarToggle" variant="mobile-toggle">
                                    <i class='bx bx-menu text-lg'></i>
                                </x-button>

                                {{-- View Other User Active Consultation Hours --}}
                                <x-button variant="glass-button"
                                    onclick="document.getElementById('user-hours-{{ $other->id }}').showModal(); return false;">
                                    <i class='bx bx-time-five'></i>
                                    <span class="hidden sm:inline">Consultation Hours</span>
                                </x-button>
                            </div>
                        </div>
                    </div>

                    @if(isset($isAvailableNow) && !$isAvailableNow)
                        <div class="px-4 py-3 bg-amber-50 border-b border-amber-200 text-amber-800">
                            <div class="flex items-start gap-2 text-sm">
                                <i class='bx bx-time-five mt-0.5'></i>
                                <p>
                                    The user may not be available right now based on their consultation hours. You can still send a message; they might reply later.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Messages -->
                    <div id="consultationMessages" class="flex-1 px-4 py-4 bg-gray-50">
                        {{-- Messages Loop --}}
                        @forelse($messages as $msg)
                            <div class="chat {{ $msg['is_mine'] ? 'chat-end' : 'chat-start' }}" data-message-id="{{ $msg['id'] }}">
                                <div class="flex flex-col {{ $msg['is_mine'] ? 'items-end text-right' : '' }} mb-2">
                                    <div class="chat-header flex items-center gap-1 {{ $msg['is_mine'] ? 'justify-end' : '' }}">
                                        {{ $msg['sender_name'] }}
                                        <time class="chat-time" datetime="{{ $msg['sent_iso'] }}">{{ $msg['time_label'] }}</time>
                                    </div>
                                    <div class="chat-bubble">{!! nl2br(e($msg['message'])) !!}</div>
                                    @if($msg['is_mine'])
                                        <div class="chat-footer-actions mt-1 flex items-center gap-2">
                                            <button
                                                class="chat-delete-btn text-red-500 hover:text-red-600 transition"
                                                data-delete-url="{{ $msg['delete_url'] }}"
                                                data-message-id="{{ $msg['id'] }}"
                                                title="Delete message">
                                                <i class="bx bx-trash text-sm"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        @empty
                            <div id="chatEmptyState">
                                <x-empty-state
                                    icon="bx bx-message-detail"
                                    title="No messages yet"
                                    description="Start the conversation." />
                            </div>
                        @endforelse
                        <div id="chatBottomSpacer"></div>
                    </div>



                    <!-- Input -->
                    <div class="chat-input-fixed p-4 bg-white">
                        <form action="{{ route('consultation-chats.thread.message.store', $thread) }}" method="POST"
                            class="flex gap-3 items-end">
                            @csrf
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="text" name="message" id="messageInput"
                                        class="input input-bordered w-full rounded-full bg-gray-100 border-0 text-gray-800 placeholder-gray-500 focus:bg-white focus:ring-2 focus:ring-[#ffb51b] focus:outline-none"
                                        placeholder="Type a message..." required autocomplete="off">
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-primary rounded-full w-10 h-10 min-h-10 p-0 bg-[#ffb51b] border-[#ffb51b] hover:bg-[#e6a319] hover:border-[#e6a319] text-[#1a2235]">
                                <i class='bx bx-send text-lg'></i>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center h-full text-center py-24">
                        <div class="w-20 h-20 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-6">
                            <i class='bx bx-conversation text-[#ffb51b] text-3xl'></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Select a consultation thread</h3>
                        <p class="text-gray-500 mb-6">Choose a thread on the sidebar to start chatting.</p>
                        <button id="mobileSidebarToggleEmpty"
                            class="md:hidden inline-flex items-center px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg font-medium hover:bg-[#e6a319] transition-colors">
                            <i class='bx bx-list-ul mr-2'></i> Show Threads
                        </button>
                    </div>
                @endif
            </div>

            <!-- Sidebar (Desktop) -->
            <div class="hidden md:block w-80 flex-shrink-0 bg-white border-l border-gray-200">
                <div class="flex flex-col h-full">
                    <div class="px-4 py-4 border-b border-gray-100 bg-gradient-to-r from-[#ffb51b]/5 to-[#e6a319]/5">
                        <h2 class="text-lg font-bold text-[#1a2235] flex items-center">
                            <i class='bx bx-conversation text-[#ffb51b] mr-2'></i>
                            Consultation Threads
                        </h2>
                    </div>
                    <div class="sidebar-scrollable">
                        @if ($threads->isNotEmpty())
                            @foreach ($threads as $t)
                                <a href="{{ route('consultation-chats.thread.show', $t['id']) }}"
                                   class="thread-item flex items-center gap-3 {{ $t['is_active'] ? 'active' : '' }}">
                                    <div class="flex-shrink-0">
                                        <x-user-avatar :user="$t['other']" size="10" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-[#1a2235] truncate">
                                                {{ $t['other']->name }}
                                            </h3>
                                            <span class="thread-time">{{ $t['time_label'] }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5 truncate">
                                            {{ $t['preview'] }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-center py-12 px-4">
                                <div class="w-16 h-16 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-conversation text-[#ffb51b] text-2xl'></i>
                                </div>
                                <h3 class="text-md font-semibold text-gray-700 mb-2">No consultations</h3>
                                <p class="text-gray-500 text-sm">Start from a participant's consultation hour.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar (Mobile) -->
            <div class="sidebar-mobile md:hidden" id="mobileSidebar">
                <div class="flex flex-col h-full">
                    <div
                        class="px-4 py-4 border-b border-gray-100 bg-gradient-to-r from-[#ffb51b]/5 to-[#e6a319]/5 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-[#1a2235] flex items-center">
                            <i class='bx bx-conversation text-[#ffb51b] mr-2'></i> Threads
                        </h2>
                        <button id="closeMobileSidebar"
                            class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class='bx bx-x text-xl'></i>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        @if ($threads->isNotEmpty())
                            @foreach ($threads as $t)
                                <a href="{{ route('consultation-chats.thread.show', $t['id']) }}"
                                    class="thread-item flex items-center gap-3 {{ $t['is_active'] ? 'active' : '' }}">
                                    <div class="flex-shrink-0">
                                        <x-user-avatar :user="$t['other']" size="10" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-[#1a2235] truncate">
                                                {{ $t['other']->name }}
                                            </h3>
                                            <span class="thread-time">{{ $t['time_label'] }}</span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5 truncate">
                                            {{ $t['preview'] }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-center py-12 px-4">
                                <div class="w-16 h-16 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-conversation text-[#ffb51b] text-2xl'></i>
                                </div>
                                <h3 class="text-md font-semibold text-gray-700 mb-2">No consultations</h3>
                                <p class="text-gray-500 text-sm">Start one from a consultation hour.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if(isset($other))
        <x-modal.dialog id="user-hours-{{ $other->id }}" maxWidth="max-w-md" width="w-11/12" maxHeight="max-h-[90vh]">
            <x-modal.header>
                <div class="flex items-center gap-2">
                    <i class='bx bx-time-five text-[#ffb51b] text-xl'></i>
                    <div>
                        <h3 class="text-lg font-bold text-[#1a2235]">Consultation Hours</h3>
                        <p class="text-xs text-gray-500">{{ $other->name }}</p>
                    </div>
                </div>
            </x-modal.header>

            <x-modal.body>
                @if(empty($activeHours) || $activeHours->isEmpty())
                    <x-empty-state icon="bx bx-time" title="No Active Hours"
                        description="This user has no active consultation hours." />
                @else
                    <div class="space-y-3">
                        @foreach($activeHours as $h)
                            <div class="flex items-start justify-between p-3 border border-gray-200 rounded-lg bg-white">
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-[#1a2235] truncate">
                                        {{ $h->specialization ?? 'Consultation' }}
                                    </div>
                                    <div class="text-xs text-gray-600 mt-0.5">
                                        {{ $h->day }}
                                    </div>
                                </div>
                                <div class="text-xs font-medium text-[#1a2235] bg-gray-50 px-2 py-1 rounded border border-gray-200">
                                    {{ \Carbon\Carbon::parse($h->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($h->end_time)->format('g:i A') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-modal.body>

            <x-modal.footer>
                <x-modal.close-button :modalId="'user-hours-' . $other->id" text="Close" />
            </x-modal.footer>
        </x-modal.dialog>
    @endif

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            (function() {
                var threadId = {{ isset($thread) ? $thread->id : 'null' }};
                var userId = {{ Auth::id() }};
                var storeUrl = threadId
                    ? "{{ isset($thread) ? route('consultation-chats.thread.message.store', $thread) : '' }}"
                    : null;
                var deleteRouteTemplate = null;
                @if(isset($thread))
                        // Template with placeholder to replace in JS
                        deleteRouteTemplate = "{{ url('consultation-chats/threads/'.$thread->id.'/messages/__CHAT_ID__') }}";
                @endif
                var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                function log(msg) {
                    console.log(msg);
                }

                function initMobileSidebar() {
                    var mobileSidebar = $('#mobileSidebar');
                    var mobileOverlay = $('#mobileOverlay');

                    function show() {
                        mobileSidebar.addClass('show');
                        mobileOverlay.addClass('show');
                        $('body').addClass('overflow-hidden');
                    }

                    function hide() {
                        mobileSidebar.removeClass('show');
                        mobileOverlay.removeClass('show');
                        $('body').removeClass('overflow-hidden');
                    }

                    $('#mobileSidebarToggle, #mobileSidebarToggleEmpty').on('click', show);
                    $('#closeMobileSidebar, #mobileOverlay').on('click', hide);
                }

                // function scrollMessagesBottom() {
                //     var wrap = document.getElementById('consultationMessages');
                //     if (!wrap) return;
                //     wrap.scrollTo({
                //         top: wrap.scrollHeight
                //     });
                // }

                function scrollMessagesBottom() {
                    const wrap = document.getElementById('consultationMessages');
                    if (wrap) {
                        wrap.scrollTo({
                            top: wrap.scrollHeight,
                            behavior: "smooth"
                        });
                    }
                }

                function buildMessageHtml(chat, isOwn){
                    var bubbleClass = isOwn ? 'chat-end' : 'chat-start';
                    var name = escapeHtml(chat.sender?.name || 'You');
                    var timeText = 'Just now';
                    var deleteBlock = '';
                    if(isOwn && deleteRouteTemplate){
                        var deleteUrl = deleteRouteTemplate.replace('__CHAT_ID__', chat.id);
                        deleteBlock =
                            '<div class="chat-footer-actions mt-1 flex items-center gap-2">' +
                                '<button class="chat-delete-btn text-red-500 hover:text-red-600 transition" ' +
                                'data-delete-url="'+deleteUrl+'" data-message-id="'+chat.id+'" title="Delete message">' +
                                '<i class="bx bx-trash text-sm"></i></button>' +
                            '</div>';
                    }
                    return '' +
      '<div class="chat ' + bubbleClass + '" data-message-id="' + chat.id + '">' +
        '<div class="flex flex-col ' + (isOwn ? 'items-end text-right':'') + ' mb-2">' +
          '<div class="chat-header flex items-center gap-1 ' + (isOwn ? 'justify-end':'') + '">' +
             name +
             '<time class="chat-time"> ' + timeText + '</time>' +
          '</div>' +
          '<div class="chat-bubble">' + formatMessage(chat.message || '') + '</div>' +
          deleteBlock +
        '</div>' +
      '</div>';
                }

                function escapeHtml(str) {
                    var div = document.createElement('div');
                    div.appendChild(document.createTextNode(str));
                    return div.innerHTML;
                }

                function formatMessage(str) {
                    return escapeHtml(str).replace(/\n/g, '<br>');
                }

                function hideEmptyState(){
                    $('#chatEmptyState').remove();
                }

                function appendMessage(chat) {
                    hideEmptyState();
                    var isOwn = chat.sender_id == userId;
                    var html = buildMessageHtml(chat, isOwn);
                    $('#consultationMessages').append(html);
                    scrollMessagesBottom();
                    adjustChatSpacer();
                }

                function sendMessageAjax(form) {
                    if (!storeUrl) {
                        log('No storeUrl');
                        return;
                    }
                    var input = form.find('input[name="message"]');
                    var message = input.val().trim();
                    if (!message) {
                        return;
                    }

                    setSendingState(form, true);

                    $.ajax({
                        url: storeUrl,
                        method: 'POST',
                        data: {
                            message: message,
                            _token: csrfToken
                        },
                        dataType: 'json'
                    }).done(function(resp) {
                        if (resp && resp.success && resp.chat) {
                            appendMessage(resp.chat);
                            input.val('');
                        } else {
                            log('Send failed response structure');
                        }
                    }).fail(function(xhr) {
                        log('Send failed status ' + xhr.status);
                    }).always(function() {
                        setSendingState(form, false);
                    });
                }

                function setSendingState(form, isSending) {
                    var btn = form.find('button[type="submit"]');
                    var input = form.find('input[name="message"]');
                    if (isSending) {
                        btn.prop('disabled', true).html('<span>...</span>');
                        input.prop('disabled', true);
                    } else {
                        btn.prop('disabled', false).html('<i class="bx bx-send text-lg"></i>');
                        input.prop('disabled', false);
                    }
                }

                function bindForm() {
                    var form = $('form[action*="consultation-chats/threads"]');
                    if (!form.length) {
                        return;
                    }
                    form.on('submit', function(e) {
                        e.preventDefault();
                        sendMessageAjax(form);
                    });
                    form.find('input[name="message"]').on('keydown', function(e) {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            sendMessageAjax(form);
                        }
                    });
                }

                function bindDelete() {
                    $(document).on('click', '.chat-delete-btn', function(e){
                        e.preventDefault();
                        var btn = $(this);
                        var msgId = btn.data('message-id');
                        var url = btn.data('delete-url');
                        if(!url || !msgId) return;
                        if(!confirm('Delete this message?')) return;
                        btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin text-xs"></i>');
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: { _method: 'DELETE', _token: csrfToken },
                            dataType: 'json'
                        }).done(function(resp){
                            if(resp && resp.success){
                                removeMessage(msgId);
                            } else {
                                btn.prop('disabled', false).html('<i class="bx bx-trash text-xs"></i>');
                            }
                        }).fail(function(){
                            btn.prop('disabled', false).html('<i class="bx bx-trash text-xs"></i>');
                        });
                    });
                }

                function removeMessage(id){
                    var el = $('[data-message-id="'+id+'"]');
                    if(el.length){
                        el.fadeOut(150, function(){ $(this).remove(); });
                    }
                }

                function initEcho() {
                    if (typeof window.Echo === 'undefined') {
                        log('Echo not available');
                        return;
                    }
                    if (!threadId) {
                        log('No thread selected. Echo not initialized');
                        return;
                    }
                    log('Subscribing to channel consultation.thread.' + threadId);
                    window.Echo.channel('consultation.thread.' + threadId)
                        .listen('ConsultationNewMessage', function(event){
                            if(event.chat && event.chat.sender_id != userId){
                                hideEmptyState();
                                appendMessage(event.chat);
                            }
                        })
                        .listen('ConsultationChatMessageDeleted', function(event){
                            if(event.messageId){
                                removeMessage(event.messageId);
                            }
                        });
                }

                function adjustChatSpacer() {
                    var input = document.querySelector('.chat-input-fixed');
                    var spacer = document.getElementById('chatBottomSpacer');
                    if (input && spacer) {
                        spacer.style.height = input.offsetHeight + 'px';
                    }
                }

                // and update on resize
                window.addEventListener('resize', adjustChatSpacer);

                function init() {
                    adjustChatSpacer();
                    initMobileSidebar();
                    bindForm();
                    bindDelete();
                    initEcho();
                    scrollMessagesBottom();
                    log('Consultation chat ready');
                }

                $(init);
            })();
        </script>
    @endpush
@endsection
