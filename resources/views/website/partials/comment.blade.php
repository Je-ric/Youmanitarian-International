<div class="comment-item bg-white p-6 rounded-lg shadow-sm border border-gray-100" data-comment-id="{{ $comment->id }}">
    <div class="flex items-start gap-4">
        <div class="w-10 h-10 flex-shrink-0 bg-gray-200 rounded-full flex items-center justify-center">
            <span class="text-lg text-gray-600">{{ substr($comment->user->name ?? 'G', 0, 1) }}</span>
        </div>                                                                        
        <div class="flex-1">
            <p class="text-gray-800">
                <strong class="text-[#1a2235]">{{ $comment->user->name ?? 'Guest' }}</strong>: 
                <span id="comment-text-{{ $comment->id }}">{{ $comment->comment }}</span>
            </p>
            <p class="text-sm text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
        </div>
    </div>

    @auth
    @if (auth()->id() == $comment->user_id)
    <div class="mt-4 flex justify-end gap-3">
        <button onclick="editComment({{ $comment->id }})" class="text-sm text-[#ffb51b] hover:text-[#e6a017] transition-colors">Edit</button>
        <button onclick="deleteComment({{ $comment->id }})" class="text-sm text-red-500 hover:text-red-600 transition-colors">Delete</button>
    </div>
    @endif
    @endauth
</div>


<script>
    function postComment(contentId) {
        let comment = document.getElementById('comment-input').value;
        if (!comment.trim()) return;

        fetch(`/comments/${contentId}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ comment: comment })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            let commentHtml = `
                <div class="comment-item bg-white p-6 rounded-lg shadow-sm border border-gray-100" data-comment-id="${data.comment.id}">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 flex-shrink-0 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-lg text-gray-600">{{ substr(optional(auth()->user())->name, 0, 1) }}</span>

                        </div>
                        <div class="flex-1">
                          <p class="text-gray-800">
                                <strong class="text-[#1a2235]">{{ optional(auth()->user())->name ?? 'Guest' }}</strong>: 
                                <span id="comment-text-${data.comment.id}">${data.comment.comment}</span>
                            </p>
                            <p class="text-sm text-gray-500 mt-1">Just now</p>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end gap-3">
                        <button onclick="editComment(${data.comment.id})" class="text-sm text-[#ffb51b] hover:text-[#e6a017] transition-colors">Edit</button>
                        <button onclick="deleteComment(${data.comment.id})" class="text-sm text-red-500 hover:text-red-600 transition-colors">Delete</button>
                    </div>
                </div>
            `;
            document.getElementById('comment-list').insertAdjacentHTML('afterbegin', commentHtml);
            document.getElementById('comment-input').value = "";
        });
    }

    function editComment(commentId) {
    let commentText = document.getElementById(`comment-text-${commentId}`);
    let currentText = commentText.innerText;

    let inputField = document.createElement("textarea");
    inputField.classList.add("w-full", "p-3", "border-b-2", "border-gray-300", "focus:border-[#ffb51b]", 
                             "focus:border-b-4", "focus:ring-0", "focus:outline-none", "resize-none", 
                             "transition-all", "duration-200", "overflow-hidden");
    inputField.rows = 1;
    inputField.value = currentText;
    inputField.setAttribute("oninput", "autoResizeTextarea(this)"); 

    let saveButton = document.createElement("button");
    saveButton.classList.add("px-4", "py-2", "bg-[#ffb51b]", "text-white", "rounded-lg", 
                             "hover:bg-[#e6a017]", "transition-colors");
    saveButton.innerText = "Save";
    saveButton.onclick = function() { updateComment(commentId, inputField.value); };

    let cancelButton = document.createElement("button");
    cancelButton.classList.add("px-4", "py-2", "bg-gray-500", "text-white", "rounded-lg", 
                               "hover:bg-gray-600", "transition-colors");
    cancelButton.innerText = "Cancel";
    cancelButton.onclick = function() { commentText.innerHTML = currentText; };

    let buttonContainer = document.createElement("div");
    buttonContainer.classList.add("mt-2", "flex", "gap-2", "justify-end");
    buttonContainer.appendChild(saveButton);
    buttonContainer.appendChild(cancelButton);

    commentText.innerHTML = "";
    commentText.appendChild(inputField);
    commentText.appendChild(buttonContainer);

    autoResizeTextarea(inputField);
}

    function updateComment(commentId, newText) {
        fetch(`/comments/${commentId}`, {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ comment: newText })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            let commentText = document.getElementById(`comment-text-${commentId}`);
            commentText.innerHTML = data.comment.comment;
        });
    }

    function deleteComment(commentId) {
        fetch(`/comments/${commentId}`, {
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
        });
    }
</script>




<script>
    function toggleEmojiPicker() {
        const emojiPicker = document.getElementById('emoji-picker');
        emojiPicker.classList.toggle('hidden');
    }

    // Insert emoji
    function insertEmoji(emoji) {
        const commentInput = document.getElementById('comment-input');
        commentInput.value += emoji;
        commentInput.focus();
        autoResizeTextarea(commentInput); 
    }

    // Close when click Outside
    document.addEventListener('click', (event) => {
        const emojiPicker = document.getElementById('emoji-picker');
        const emojiButton = document.querySelector('button[onclick="toggleEmojiPicker()"]');
        if (!emojiPicker.contains(event.target) && !emojiButton.contains(event.target)) {
            emojiPicker.classList.add('hidden');
        }
    });

    // Auto-Resize Textarea
    function autoResizeTextarea(textarea) {
        textarea.style.height = 'auto'; // Reset height
        textarea.style.height = `${textarea.scrollHeight}px`; // Set height based on content
    }
</script>
