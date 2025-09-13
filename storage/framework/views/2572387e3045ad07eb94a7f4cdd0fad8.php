<?php $__env->startSection('content'); ?>
    
    <style>
        body { overflow: hidden !important; }

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
            padding-bottom: 20px;
        }

        #consultationMessages::-webkit-scrollbar { width: 6px; }
        #consultationMessages::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        #consultationMessages::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        #consultationMessages::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }

        .sidebar-scrollable {
            overflow-y: auto;
            height: calc(100vh - 80px);
        }
        .sidebar-scrollable::-webkit-scrollbar { width: 4px; }
        .sidebar-scrollable::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scrollable::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 4px; }

        .chat-bubble {
            max-width: 70%;
            word-wrap: break-word;
            border-radius: 18px;
            padding: 8px 12px;
            font-size: 14px;
            line-height: 1.4;
        }
        .chat-end .chat-bubble { background-color: #1a2235; color: #fff; }
        .chat-start .chat-bubble { background-color: #f1f3f4; color: #1a2235; }

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
        }

        @media (max-width: 768px) {
            .chat-container { height: 100vh; }
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
                box-shadow: -4px 0 15px rgba(0,0,0,.1);
            }
            .sidebar-mobile.show { right: 0; }
            .mobile-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.5);
                z-index: 40;
                opacity: 0;
                visibility: hidden;
                transition: all .3s ease;
            }
            .mobile-overlay.show {
                opacity: 1;
                visibility: visible;
            }
            .chat-bubble { max-width: 85%; }
        }

        .thread-item {
            padding: 12px 16px;
            transition: all .2s ease;
            border-radius: 8px;
            margin: 4px 8px;
        }
        .thread-item:hover { background: rgba(255,181,27,0.08); }
        .thread-item.active {
            background: rgba(255,181,27,0.15);
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
                <?php if(isset($thread)): ?>
                    <?php
                        $me = Auth::id();
                        $other = $thread->user_one_id === $me ? $thread->userTwo : $thread->userOne;
                    ?>

                    <!-- Header -->
                    <div class="px-4 py-3 bg-gradient-to-r from-[#1a2235] to-[#2a3447] text-white flex-shrink-0">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <div class="flex items-center justify-center w-8 h-8 bg-[#ffb51b] rounded-lg mr-3">
                                    <i class='bx bx-conversation text-[#1a2235] text-lg'></i>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-sm font-semibold truncate">
                                        <?php echo e($other->name); ?>

                                    </h3>
                                    <p class="text-xs text-gray-300">
                                        Thread #<?php echo e($thread->id); ?> • <?php echo e(ucfirst($thread->status)); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve(['variant' => 'mobile-toggle'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'mobileSidebarToggle']); ?>
                                    <i class='bx bx-menu text-lg'></i>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $attributes = $__attributesOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $component = $__componentOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__componentOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve(['variant' => 'glass-button'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('consultation-chats.index')).'']); ?>
                                    <i class='bx bx-list-ul mr-1 text-sm'></i>
                                    <span class="hidden sm:inline text-sm">Threads</span>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $attributes = $__attributesOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $component = $__componentOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__componentOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div id="consultationMessages" class="flex-1 px-4 py-4 bg-gray-50">
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $mine = $m->sender_id === Auth::id(); ?>
                            <div class="chat <?php echo e($mine ? 'chat-end' : 'chat-start'); ?>" data-message-id="<?php echo e($m->id); ?>">
                                <div class="chat-header">
                                    <?php echo e($m->sender->name); ?>

                                    <time class="chat-time"
                                          datetime="<?php echo e($m->sent_at?->toIso8601String()); ?>">
                                        <?php
                                            $mt = \Carbon\Carbon::parse($m->sent_at);
                                            if ($mt->isToday()) {
                                                echo $mt->format('g:i A');
                                            } elseif ($mt->isYesterday()) {
                                                echo 'Yesterday ' . $mt->format('g:i A');
                                            } else {
                                                echo $mt->format('M j, Y g:i A');
                                            }
                                        ?>
                                    </time>
                                </div>
                                <div class="chat-bubble">
                                    <?php echo nl2br(e($m->message)); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="flex flex-col items-center justify-center h-full text-center py-12">
                                <div class="w-16 h-16 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-message-detail text-[#ffb51b] text-2xl'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">No messages yet</h3>
                                <p class="text-gray-500 mb-4">Start the conversation.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Input -->
                    <div class="chat-input-fixed p-4 bg-white">
                        <form action="<?php echo e(route('consultation-chats.thread.message.store', $thread)); ?>" method="POST" class="flex gap-3 items-end">
                            <?php echo csrf_field(); ?>
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
                <?php else: ?>
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
                <?php endif; ?>
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
                        <?php if($threads->isNotEmpty()): ?>
                            <?php $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $me = Auth::id();
                                    $other = $t->user_one_id === $me ? $t->userTwo : $t->userOne;
                                    $last = $t->latestChat;
                                    $lastTime = $last? \Carbon\Carbon::parse($last->sent_at) : null;
                                    $preview = $last?->message ? \Illuminate\Support\Str::limit($last->message, 40) : 'No messages yet.';
                                    $timeLabel = '';
                                    if ($lastTime) {
                                        if ($lastTime->isToday()) {
                                            $timeLabel = $lastTime->format('g:i A');
                                        } elseif ($lastTime->isYesterday()) {
                                            $timeLabel = 'Yesterday';
                                        } else {
                                            $timeLabel = $lastTime->format('M j');
                                        }
                                    }
                                ?>
                                <a href="<?php echo e(route('consultation-chats.thread.show', $t)); ?>"
                                   class="thread-item flex items-center gap-3 <?php echo e(isset($thread) && $thread->id === $t->id ? 'active' : ''); ?>">
                                    <div class="flex-shrink-0">
                                        <?php if (isset($component)) { $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-avatar','data' => ['user' => $other,'size' => '10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($other),'size' => '10']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $attributes = $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $component = $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-[#1a2235] truncate">
                                                <?php echo e($other->name); ?>

                                            </h3>
                                            <span class="thread-time"><?php echo e($timeLabel); ?></span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5 truncate">
                                            <?php echo e($preview); ?>

                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center h-full text-center py-12 px-4">
                                <div class="w-16 h-16 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-conversation text-[#ffb51b] text-2xl'></i>
                                </div>
                                <h3 class="text-md font-semibold text-gray-700 mb-2">No consultations</h3>
                                <p class="text-gray-500 text-sm">Start from a participant's consultation hour.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Mobile) -->
            <div class="sidebar-mobile md:hidden" id="mobileSidebar">
                <div class="flex flex-col h-full">
                    <div class="px-4 py-4 border-b border-gray-100 bg-gradient-to-r from-[#ffb51b]/5 to-[#e6a319]/5 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-[#1a2235] flex items-center">
                            <i class='bx bx-conversation text-[#ffb51b] mr-2'></i> Threads
                        </h2>
                        <button id="closeMobileSidebar"
                                class="inline-flex items-center justify-center w-8 h-8 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class='bx bx-x text-xl'></i>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto">
                        <?php if($threads->isNotEmpty()): ?>
                            <?php $__currentLoopData = $threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $me = Auth::id();
                                    $other = $t->user_one_id === $me ? $t->userTwo : $t->userOne;
                                    $last = $t->latestChat;
                                    $lastTime = $last? \Carbon\Carbon::parse($last->sent_at) : null;
                                    $timeLabel = '';
                                    if ($lastTime) {
                                        if ($lastTime->isToday()) $timeLabel = $lastTime->format('g:i A');
                                        elseif ($lastTime->isYesterday()) $timeLabel = 'Yesterday';
                                        else $timeLabel = $lastTime->format('M j');
                                    }
                                    $preview = $last?->message ? \Illuminate\Support\Str::limit($last->message, 40) : 'No messages yet.';
                                ?>
                                <a href="<?php echo e(route('consultation-chats.thread.show', $t)); ?>"
                                   class="thread-item flex items-center gap-3 <?php echo e(isset($thread) && $thread->id === $t->id ? 'active' : ''); ?>">
                                    <div class="flex-shrink-0">
                                        <?php if (isset($component)) { $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-avatar','data' => ['user' => $other,'size' => '10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($other),'size' => '10']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $attributes = $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $component = $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-sm font-semibold text-[#1a2235] truncate">
                                                <?php echo e($other->name); ?>

                                            </h3>
                                            <span class="thread-time"><?php echo e($timeLabel); ?></span>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-0.5 truncate">
                                            <?php echo e($preview); ?>

                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center h-full text-center py-12 px-4">
                                <div class="w-16 h-16 bg-[#ffb51b]/10 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-conversation text-[#ffb51b] text-2xl'></i>
                                </div>
                                <h3 class="text-md font-semibold text-gray-700 mb-2">No consultations</h3>
                                <p class="text-gray-500 text-sm">Start one from a consultation hour.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script>
            $(function () {
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

                // Scroll to bottom on load if thread open
                const msgWrap = document.getElementById('consultationMessages');
                if (msgWrap) {
                    msgWrap.scrollTo({ top: msgWrap.scrollHeight });
                }
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar_final', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/consultation/consultationChats.blade.php ENDPATH**/ ?>