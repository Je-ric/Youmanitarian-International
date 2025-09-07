@extends('layouts.navbar')

@section('content')

    @if ($content->image_content)
        <div class="relative w-full h-[80vh] sm:h-[90vh] lg:h-[100vh] flex items-center justify-center overflow-hidden">
            <!-- Background image with blur -->
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                <img src="{{ Storage::url($content->image_content) }}"
                    alt="Content Image" class="w-full h-full object-cover filter blur-sm">
            </div>

            <!-- Semi-transparent overlay -->
            <div class="absolute inset-0 bg-[#1a2235] bg-opacity-80 backdrop-blur-sm"></div>

            <!-- Centered text -->
            <div class="relative z-10 text-center px-6 sm:px-12">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-[#ffb51b] leading-tight">
                    {{ $content->title }}
                </h1>

                <div
                    class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-4 text-sm sm:text-base text-white">
                    <div class="flex items-center gap-2">
                        <i class='bx bx-calendar'></i>
                        <span>{{ $content->created_at->format('F j, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class='bx bx-show'></i>
                        <span>{{ number_format($content->views) }} views</span>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center items-center gap-3 mt-4">
                    <span class="inline-flex items-center px-3 py-1 bg-[#ffb51b] text-[#1a2235] text-sm font-semibold">
                        {{ ucfirst($content->content_type) }}
                    </span>
                    @if ($content->is_featured)
                        <span
                            class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-semibold">
                            <i class='bx bx-star mr-1'></i> Featured
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif


    <!-- Main content: white background -->
    <div class="flex flex-col xl:flex-row gap-6 lg:gap-8 bg-white px-10 py-4">

        <article class="xl:w-2/3">
            <div class="overflow-hidden">
                <!-- Article Content -->
                <div class="sm:px-8 lg:px-16 pt-10 pb-6 sm:pb-8">
                    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                        {!! $content->body !!}
                    </div>
                </div>

                <!-- Gallery Section -->
                @if ($content->image_content)
                    <!-- Featured Poster Image -->
                    <div class="px-6 sm:px-8 lg:px-10 pb-6 sm:pb-8">
                        <img src="{{ Storage::url($content->image_content) }}"
                            alt="Featured Image" class="w-full h-auto max-h-[80vh] object-contain rounded-md shadow-lg">
                    </div>
                @endif
                @if ($galleryImages->isNotEmpty())
                    <div class="px-6 sm:px-8 lg:px-10 pb-6 sm:pb-8">
                        <div class="border-t border-gray-200 pt-6 sm:pt-8">
                            <h3 class="text-xl sm:text-2xl font-semibold text-[#1a2235] mb-6 flex items-center gap-2">
                                <i class='bx bx-image text-[#ffb51b]'></i>
                                Gallery
                            </h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                                @foreach ($galleryImages as $image)
                                    <div class="group relative overflow-hidden cursor-pointer transform hover:scale-105 transition-all duration-300"
                                        onclick="openImageModal({{ $loop->index }})">
                                        <img src="{{ Storage::url($image->image_path) }}"
                                            class="w-full h-24 sm:h-32 lg:h-40 object-cover"
                                            alt="Gallery Image {{ $loop->iteration }}">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                            <i
                                                class='bx bx-expand text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300'></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Engagement Section -->
                @if ($content->enable_likes || $content->enable_comments || $content->enable_bookmark)
                    <div class="px-6 sm:px-8 lg:px-10 py-6 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-6">
                                @if ($content->enable_likes)
                                    <button id="heartButton-{{ $content->id }}"
                                        class="flex items-center gap-2 text-gray-600 hover:text-red-500 transition-colors duration-200 group"
                                        onclick="toggleReact({{ $content->id }}, '{{ csrf_token() }}')"
                                        data-reacted="{{ auth()->user() && $content->heartReacts->contains('user_id', auth()->id()) ? 'true' : 'false' }}">
                                        <i id="heartIcon-{{ $content->id }}"
                                            class="bx text-xl {{ auth()->user() && $content->heartReacts->contains('user_id', auth()->id()) ? 'bxs-heart text-red-500' : 'bx-heart group-hover:text-red-500' }}"></i>
                                        <span id="heartCount-{{ $content->id }}" class="font-medium">
                                            {{ $content->heartReacts->count() }}
                                        </span>
                                    </button>
                                @endif

                                @if ($content->enable_comments)
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class='bx bx-comment text-xl'></i>
                                        <span id="commentCount-{{ $content->id }}" class="font-medium">
                                            {{ $content->comments->count() }}
                                        </span>
                                        <span class="text-sm">Comments</span>
                                    </div>
                                @endif
                            </div>

                            @if ($content->enable_bookmark)
                                <button
                                    class="flex items-center gap-2 text-gray-600 hover:text-[#ffb51b] transition-colors duration-200">
                                    <i class='bx bx-bookmark text-xl'></i>
                                    <span class="font-medium text-sm">Bookmark</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Comments Section -->
                @if ($content->enable_comments)
                    @include('website.partials.comment', ['content' => $content])
                @endif

                <!-- Navigation -->
                <div class="px-6 sm:px-8 lg:px-10 py-6 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row justify-between gap-4">
                        @if ($prevContent)
                            <a href="{{ route('website.view-content', $prevContent->slug) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 text-sm font-medium">
                                <i class='bx bx-chevron-left'></i>
                                <span class="truncate max-w-32 sm:max-w-48">{{ $prevContent->title }}</span>
                            </a>
                        @endif

                        @if ($nextContent)
                            <a href="{{ route('website.view-content', $nextContent->slug) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 text-sm font-medium sm:ml-auto">
                                <span class="truncate max-w-32 sm:max-w-48">{{ $nextContent->title }}</span>
                                <i class='bx bx-chevron-right'></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </article>

        <!-- Sidebar -->
        <aside class="xl:w-1/3">
            <div class="bg-white border border-gray-200 sticky top-6 max-h-[calc(100vh-3rem)] overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-[#1a2235] flex items-center gap-2">
                        <i class='bx bx-collection text-[#ffb51b]'></i>
                        Related Content
                    </h2>
                </div>

                <div class="overflow-y-auto max-h-[calc(100vh-12rem)]">
                    <div class="p-6 space-y-4">
                        @forelse ($otherContents as $item)
                            <a href="{{ route('website.view-content', $item->slug) }}" class="block group">
                                <article
                                    class="p-4 border border-gray-200 hover:border-[#ffb51b] hover:shadow-md transition-all duration-200">
                                    <div class="flex gap-4">
                                        @if ($item->image_content)
                                            <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 overflow-hidden">
                                                <img src="{{ Storage::url($item->image_content) }}"
                                                    alt="Thumbnail"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                            </div>
                                        @else
                                            <div
                                                class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 bg-gray-100 flex items-center justify-center">
                                                <i class='bx bx-image text-xl text-gray-400'></i>
                                            </div>
                                        @endif

                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="font-semibold text-[#1a2235] text-sm sm:text-base line-clamp-2 group-hover:text-[#ffb51b] transition-colors duration-200">
                                                {{ $item->title }}
                                            </h3>
                                            <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                                                <i class='bx bx-calendar'></i>
                                                <span>{{ $item->created_at->format('M j, Y') }}</span>
                                            </div>
                                            @if ($item->is_featured)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 text-xs mt-2">
                                                    <i class='bx bx-star mr-1'></i> Featured
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            </a>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class='bx bx-collection text-3xl mb-2'></i>
                                <p class="text-sm">No related content available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </aside>
    </div>
    {{-- </div> --}}

    <!-- Image Preview Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 items-center justify-center hidden z-50 p-4">
        <button onclick="closeImageModal()"
            class="absolute top-4 right-4 text-white text-2xl sm:text-3xl hover:text-[#ffb51b] transition-colors z-10 w-10 h-10 flex items-center justify-center bg-black bg-opacity-50">
            <i class='bx bx-x'></i>
        </button>

        <button onclick="prevImage()"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-2xl sm:text-3xl hover:text-[#ffb51b] transition-colors z-10 w-10 h-10 flex items-center justify-center bg-black bg-opacity-50">
            <i class='bx bx-chevron-left'></i>
        </button>

        <img id="modalImage" class="max-w-full max-h-full" src="/placeholder.svg" alt="Preview">

        <button onclick="nextImage()"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-2xl sm:text-3xl hover:text-[#ffb51b] transition-colors z-10 w-10 h-10 flex items-center justify-center bg-black bg-opacity-50">
            <i class='bx bx-chevron-right'></i>
        </button>
    </div>

    <script>
        let galleryImages = [
            @foreach ($galleryImages as $image)
                "{{ Storage::url($image->image_path) }}",
            @endforeach
        ];
        let currentIndex = 0;

        function openImageModal(index) {
            currentIndex = index;
            document.getElementById('modalImage').src = galleryImages[currentIndex];
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function prevImage() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : galleryImages.length - 1;
            document.getElementById('modalImage').src = galleryImages[currentIndex];
        }

        function nextImage() {
            currentIndex = (currentIndex < galleryImages.length - 1) ? currentIndex + 1 : 0;
            document.getElementById('modalImage').src = galleryImages[currentIndex];
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });

        function postComment(contentId) {
            let comment = document.getElementById('comment-input').value;
            if (!comment.trim()) {
                alert('Please enter a comment');
                return;
            }

            let submitBtn = document.querySelector('#comment-form button[type="submit"]');
            let originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt animate-spin mr-2"></i>Posting...';
            submitBtn.disabled = true;

            fetch(`/content/${contentId}/comments`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        comment: comment
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    let commentHtml = `
                    <div class="comment-item bg-white border-b border-gray-100 p-6" data-comment-id="${data.comment.id}">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 flex-shrink-0 bg-gradient-to-br from-[#1a2235] to-[#2a3441] flex items-center justify-center">
                                <span class="text-sm font-semibold text-white">{{ substr(optional(auth()->user())->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="font-semibold text-[#1a2235]">{{ optional(auth()->user())->name ?? 'Guest' }}</h4>
                                    <span class="text-sm text-gray-500">Just now</span>
                                </div>
                                <p id="comment-text-${data.comment.id}" class="text-gray-800 leading-relaxed">${data.comment.comment}</p>
                                <div class="mt-3 flex items-center gap-4">
                                    <button onclick="editComment(${data.comment.id})" class="text-sm text-[#ffb51b] hover:text-[#e6a017] transition-colors font-medium">Edit</button>
                                    <button onclick="deleteComment(${data.comment.id})" class="text-sm text-red-500 hover:text-red-600 transition-colors font-medium">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    document.getElementById('comment-list').insertAdjacentHTML('afterbegin', commentHtml);

                    document.getElementById('comment-input').value = "";

                    let commentCount = document.getElementById('commentCount-{{ $content->id }}');
                    if (commentCount) {
                        commentCount.textContent = parseInt(commentCount.textContent) + 1;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error posting comment. Please try again.');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        }

        function editComment(commentId) {
            let commentText = document.getElementById(`comment-text-${commentId}`);
            let currentText = commentText.innerText;

            let inputField = document.createElement("textarea");
            inputField.classList.add("w-full", "p-3", "border-2", "border-gray-200",
                "focus:border-[#ffb51b]", "focus:ring-0", "focus:outline-none",
                "resize-none", "transition-all", "duration-200");
            inputField.rows = 3;
            inputField.value = currentText;
            inputField.setAttribute("oninput", "autoResizeTextarea(this)");

            let buttonContainer = document.createElement("div");
            buttonContainer.classList.add("mt-3", "flex", "gap-2");

            let saveButton = document.createElement("button");
            saveButton.classList.add("px-4", "py-2", "bg-[#ffb51b]", "text-white",
                "hover:bg-[#e6a017]", "transition-colors", "font-medium", "text-sm");
            saveButton.innerText = "Save";
            saveButton.onclick = function() {
                updateComment(commentId, inputField.value);
            };

            let cancelButton = document.createElement("button");
            cancelButton.classList.add("px-4", "py-2", "bg-gray-200", "text-gray-700",
                "hover:bg-gray-300", "transition-colors", "font-medium", "text-sm");
            cancelButton.innerText = "Cancel";
            cancelButton.onclick = function() {
                commentText.innerHTML = currentText;
            };

            buttonContainer.appendChild(saveButton);
            buttonContainer.appendChild(cancelButton);

            commentText.innerHTML = "";
            commentText.appendChild(inputField);
            commentText.appendChild(buttonContainer);

            autoResizeTextarea(inputField);
            inputField.focus();
        }

        function updateComment(commentId, newText) {
            fetch(`/content/comments/${commentId}`, {
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        comment: newText
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    let commentText = document.getElementById(`comment-text-${commentId}`);
                    commentText.innerHTML = data.comment.comment;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating comment. Please try again.');
                });
        }

        function deleteComment(commentId) {
            if (!confirm('Are you sure you want to delete this comment?')) {
                return;
            }

            fetch(`/content/comments/${commentId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    document.querySelector(`[data-comment-id="${commentId}"]`).remove();

                    let commentCount = document.getElementById('commentCount-{{ $content->id }}');
                    if (commentCount) {
                        commentCount.textContent = parseInt(commentCount.textContent) - 1;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting comment. Please try again.');
                });
        }

        function toggleEmojiPicker() {
            const emojiPicker = document.getElementById('emoji-picker');
            emojiPicker.classList.toggle('hidden');
        }

        function insertEmoji(emoji) {
            const commentInput = document.getElementById('comment-input');
            const cursorPos = commentInput.selectionStart;
            const textBefore = commentInput.value.substring(0, cursorPos);
            const textAfter = commentInput.value.substring(cursorPos);

            commentInput.value = textBefore + emoji + textAfter;
            commentInput.focus();
            commentInput.setSelectionRange(cursorPos + emoji.length, cursorPos + emoji.length);

            autoResizeTextarea(commentInput);
        }

        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = `${textarea.scrollHeight}px`;
        }

        document.addEventListener('click', (event) => {
            const emojiPicker = document.getElementById('emoji-picker');
            const emojiButton = document.querySelector('button[onclick="toggleEmojiPicker()"]');
            if (emojiPicker && emojiButton && !emojiPicker.contains(event.target) && !emojiButton.contains(event
                    .target)) {
                emojiPicker.classList.add('hidden');
            }
        });
    </script>
@endsection

<script src="{{ asset('js/toggleReact.js') }}"></script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .prose {
        max-width: none;
    }

    .prose h1,
    .prose h2,
    .prose h3,
    .prose h4,
    .prose h5,
    .prose h6 {
        color: #1a2235;
        font-weight: 600;
    }

    .prose a {
        color: #ffb51b;
        text-decoration: none;
    }

    .prose a:hover {
        color: #e6a017;
        text-decoration: underline;
    }

    .prose blockquote {
        border-left: 4px solid #ffb51b;
        background: #f8f9fa;
        padding: 1rem;
        margin: 1.5rem 0;
    }

    .prose code {
        background: #f1f5f9;
        padding: 0.25rem 0.5rem;
        font-size: 0.875em;
    }

    .prose pre {
        background: #1e293b;
        color: #e2e8f0;
        padding: 1rem;
        overflow-x: auto;
    }

    @media (max-width: 640px) {
        .prose {
            font-size: 0.875rem;
            line-height: 1.5;
        }
    }
</style>
