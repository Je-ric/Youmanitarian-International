@if($content->enable_comments)
<section class="bg-white border-t border-gray-200">
    <!-- Comments Header -->
    <header class="px-6 sm:px-8 lg:px-10 py-6 border-b border-gray-100 bg-gray-50">
        <div class="flex items-center justify-between">
            <h2 class="text-xl sm:text-2xl font-semibold text-[#1a2235] flex items-center gap-3">
                <div class="w-8 h-8 bg-[#ffb51b] rounded-lg flex items-center justify-center">
                    <i class='bx bx-message-square-dots text-white text-lg'></i>
                </div>
                <span>Comments</span>
                <span class="text-lg font-normal text-gray-500">
                    (<span id="commentCount-{{ $content->id }}">{{ $content->comments->count() }}</span>)
                </span>
            </h2>
        </div>
    </header>

    <!-- Comment Form -->
    @auth
    <div class="px-6 sm:px-8 lg:px-10 py-6 bg-white border-b border-gray-100">
        <form id="comment-form" onsubmit="event.preventDefault(); postComment({{ $content->id }});" class="space-y-4">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 flex-shrink-0 bg-gradient-to-br from-[#1a2235] to-[#2a3441] rounded-full flex items-center justify-center">
                    <span class="text-sm font-semibold text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </span>
                </div>
                
                <div class="flex-1 space-y-3">
                    <div class="relative">
                        <textarea 
                            id="comment-input"
                            name="comment" 
                            rows="3" 
                            class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-[#ffb51b] focus:ring-0 focus:outline-none resize-none transition-all duration-200 text-gray-800 placeholder-gray-500"
                            placeholder="Share your thoughts on this content..."
                            oninput="autoResizeTextarea(this)"
                        ></textarea>
                        
                        <!-- Emoji Picker Button -->
                        <button 
                            type="button" 
                            onclick="toggleEmojiPicker()" 
                            class="absolute bottom-3 right-3 text-gray-400 hover:text-[#ffb51b] transition-colors duration-200 p-1 rounded-lg hover:bg-gray-100"
                            title="Add emoji"
                        >
                            <i class='bx bx-smile text-xl'></i>
                        </button>
                    </div>

                    <!-- Emoji Picker -->
                    <div id="emoji-picker" class="hidden relative">
                        <div class="absolute top-0 right-0 bg-white border-2 border-gray-200 rounded-xl p-4 shadow-xl z-10 max-w-xs">
                            <div class="grid grid-cols-8 gap-2 max-h-32 overflow-y-auto">
                                @php
                                    $emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇', '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚', '😋', '😛', '😝', '😜', '🤪', '🤨', '🧐', '🤓', '😎', '🤩', '🥳', '😏', '😒', '😞', '😔', '😟', '😕', '🙁', '☹️', '😣', '😖', '😫', '😩', '🥺', '😢', '😭', '😤', '😠', '😡', '🤬', '🤯', '😳', '🥵', '🥶', '😱', '😨', '😰', '😥', '😓', '🤗', '🤔', '🤭', '🤫', '🤥', '😶', '😐', '😑', '😯', '😦', '😧', '😮', '😲', '🥱', '😴', '🤤', '😪', '😵', '🤐', '🥴', '🤢', '🤮', '🤧', '😷', '🤒', '🤕', '🤑', '🤠', '👍', '👎', '👏', '🙌', '👌', '✌️', '🤞', '🤟', '🤘', '🤙', '👈', '👉', '👆', '👇', '☝️', '✋', '🤚', '🖐️', '🖖', '👋', '🤏', '💪', '🦾', '🖕', '✍️', '🙏', '🦶', '🦵', '🦿', '💄', '💋', '👄', '🦷', '👅', '👂', '🦻', '👃', '👣', '👁️', '👀', '🧠', '🗣️', '👤', '👥'];
                                @endphp
                                @foreach($emojis as $emoji)
                                    <button 
                                        type="button" 
                                        onclick="insertEmoji('{{ $emoji }}')" 
                                        class="text-lg hover:bg-gray-100 rounded p-1 transition-colors duration-200"
                                        title="{{ $emoji }}"
                                    >
                                        {{ $emoji }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            <i class='bx bx-info-circle mr-1'></i>
                            Be respectful and constructive in your comments
                        </div>
                        <button 
                            type="submit" 
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#ffb51b] text-white rounded-lg hover:bg-[#e6a017] transition-all duration-200 font-medium shadow-sm hover:shadow-md"
                        >
                            <i class='bx bx-send'></i>
                            <span>Post Comment</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @else
    <div class="px-6 sm:px-8 lg:px-10 py-6 bg-gray-50 border-b border-gray-100">
        <div class="flex items-center gap-4 p-4 bg-white border border-gray-200 rounded-xl">
            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                <i class='bx bx-user text-gray-500'></i>
            </div>
            <div class="flex-1">
                <p class="text-gray-700 font-medium">Join the conversation</p>
                <p class="text-sm text-gray-500">
                    Please <a href="{{ route('login') }}" class="text-[#ffb51b] hover:text-[#e6a017] font-medium hover:underline">sign in</a> to share your thoughts and engage with the community.
                </p>
            </div>
        </div>
    </div>
    @endauth

    <!-- Comments List -->
    <div id="comment-list" class="divide-y divide-gray-100">
        @forelse($content->comments()->orderBy('created_at', 'desc')->get() as $comment)
            <article class="comment-item bg-white p-6 sm:p-8 lg:p-10" data-comment-id="{{ $comment->id }}">
                <div class="flex items-start gap-4">
                    <!-- User Avatar -->
                    <div class="w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 bg-gradient-to-br from-[#1a2235] to-[#2a3441] rounded-full flex items-center justify-center">
                        <span class="text-sm sm:text-base font-semibold text-white">
                            {{ substr($comment->user->name ?? 'Guest', 0, 1) }}
                        </span>
                    </div>
                    
                    <!-- Comment Content -->
                    <div class="flex-1 min-w-0">
                        <!-- Comment Header -->
                        <header class="flex flex-col sm:flex-row sm:items-center gap-2 mb-3">
                            <h4 class="font-semibold text-[#1a2235] text-base">
                                {{ $comment->user->name ?? 'Guest' }}
                            </h4>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class='bx bx-time-five'></i>
                                <time datetime="{{ $comment->created_at->toISOString() }}">
                                    {{ $comment->created_at->diffForHumans() }}
                                </time>
                            </div>
                        </header>
                        
                        <!-- Comment Text -->
                        <div class="mb-4">
                            <p id="comment-text-{{ $comment->id }}" class="text-gray-800 leading-relaxed text-sm sm:text-base">
                                {{ $comment->comment }}
                            </p>
                        </div>
                        
                        <!-- Comment Actions -->
                        @if(auth()->check() && (auth()->id() == $comment->user_id || auth()->user()->hasRole('admin')))
                            <footer class="flex items-center gap-4">
                                <button 
                                    onclick="editComment({{ $comment->id }})" 
                                    class="inline-flex items-center gap-1 text-sm text-[#ffb51b] hover:text-[#e6a017] transition-colors duration-200 font-medium"
                                >
                                    <i class='bx bx-edit-alt'></i>
                                    <span>Edit</span>
                                </button>
                                <button 
                                    onclick="deleteComment({{ $comment->id }})" 
                                    class="inline-flex items-center gap-1 text-sm text-red-500 hover:text-red-600 transition-colors duration-200 font-medium"
                                >
                                    <i class='bx bx-trash'></i>
                                    <span>Delete</span>
                                </button>
                            </footer>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="p-8 sm:p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class='bx bx-message-square-dots text-2xl text-gray-400'></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No comments yet</h3>
                <p class="text-gray-500 text-sm">Be the first to share your thoughts on this content!</p>
            </div>
        @endforelse
    </div>
</section>
@endif
