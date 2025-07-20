<!-- drawer component -->
 <div id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
     <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
         <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
             <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
         </svg>
         Content Review Comments
     </h5>
     <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
         <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
             <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
         </svg>
         <span class="sr-only">Close menu</span>
     </button>
     <div class="mb-4 space-y-2 text-sm text-gray-700 dark:text-gray-200">
         @php $editId = request('edit_comment'); @endphp
         @if(isset($content) && $content->reviewComments && $content->reviewComments->count())
             <div id="review-comments-list">
                 @foreach($content->reviewComments as $comment)
                     <div class="comment-item" data-id="{{ $comment->id }}">
                         <div>{{ $comment->comment }}</div>
                         <div class="text-xs text-gray-400 mt-1">By User #{{ $comment->user_id }}</div>
                         <button class="delete-comment-btn text-red-600 text-xs">Delete</button>
                     </div>
                 @endforeach
             </div>
         @else
             <div class="text-gray-400">No review comments yet.</div>
         @endif
     </div>
     {{-- Debug: --}}
     <div style="display:none" id="debug-user-id">{{ auth()->id() }}</div>
     <form id="add-comment-form">
         @csrf
         <input type="hidden" name="content_id" id="content-id-input" value="{{ $content->id ?? '' }}">
         <input type="hidden" name="user_id" value="{{ auth()->id() }}">
         <textarea name="comment" id="comment-input" rows="2" class="w-full border rounded p-2 mb-2" placeholder="Add a review comment..."></textarea>
         <button type="submit" class="w-full bg-blue-600 text-white rounded p-2">Submit</button>
     </form>
 </div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function() {
    $('#add-comment-form').on('submit', function(e) {
        e.preventDefault();
        var comment = $('#comment-input').val();
        var contentId = $('#content-id-input').val(); // Always get from the DOM
        if (!comment.trim()) return;

        $.post({
            url: '/content-review-comments',
            data: {
                content_id: contentId,
                user_id: {{ auth()->id() }},
                comment: comment,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('#review-comments-list').append(
                    `<div class="comment-item" data-id="${data.id}">
                        <div>${data.comment}</div>
                        <div class="text-xs text-gray-400 mt-1">By User #${data.user_id}</div>
                        <button class="delete-comment-btn text-red-600 text-xs">Delete</button>
                    </div>`
                );
                $('#comment-input').val('');
                $('#error-message').remove();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                let msg = errors ? Object.values(errors).join('<br>') : 'An error occurred.';
                if ($('#error-message').length === 0) {
                    $('#add-comment-form').prepend(`<div id="error-message" class="text-red-600 mb-2">${msg}</div>`);
                } else {
                    $('#error-message').html(msg);
                }
            }
        });
    });

    // Delete comment
    $('#review-comments-list').on('click', '.delete-comment-btn', function() {
        if (!confirm('Delete this comment?')) return;
        var $item = $(this).closest('.comment-item');
        var id = $item.data('id');
        $.ajax({
            url: '/content-review-comments/' + id,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function() {
                $item.remove();
            }
        });
    });
});
</script>
