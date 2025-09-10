<div id="drawer-right-example"
    class="fixed top-0 right-0 z-40 h-screen w-96 translate-x-full overflow-y-auto bg-white shadow-2xl border-l border-gray-200 dark:bg-gray-800 dark:border-gray-700 transition-transform duration-300 ease-in-out"
    tabindex="-1" aria-labelledby="drawer-right-label">

    <!-- Header -->
    <div
        class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 rounded-tl-2xl">
        <div class="flex items-center gap-3">
            <span
                class="inline-flex items-center justify-center w-9 h-9 bg-[#f4f5f9] dark:bg-gray-700 rounded-xl shadow-sm">
                <svg class="w-5 h-5 text-[#1a2235] dark:text-gray-100" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
            </span>
            <h5 id="drawer-right-label" class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                Content Review Comments
            </h5>
        </div>
        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example"
            class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 p-2 rounded-full transition-colors">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close</span>
        </button>
    </div>

    <div class="px-6 py-5 space-y-6" id="review-comments-wrapper">
        {{-- existing comments --}}
        <div id="review-comments-list">
            @if (isset($content) && $content->reviewComments && $content->reviewComments->count())
                @foreach ($content->reviewComments as $comment)
                    <div id="comment-{{ $comment->id }}"
                        class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 mb-3 flex justify-between items-start shadow-sm">
                        <div>
                            <p class="text-sm text-gray-800 dark:text-gray-100 leading-snug">
                                {{ $comment->comment }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                By <span class="font-medium text-gray-900 dark:text-[#ffc449]">
                                    {{ $comment->user ? $comment->user->name : 'Sinong User?' }}
                                </span>
                            </p>
                        </div>

                        @if (Auth::id() === $comment->user_id)
                            <button
                                class="delete-comment ml-3 p-2 rounded-full hover:bg-red-100 dark:hover:bg-red-900 transition-colors"
                                data-id="{{ $comment->id }}">
                                <i class='bx bx-trash text-lg text-red-600 dark:text-red-400'></i>
                            </button>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-gray-400 text-center py-10 text-sm">No review comments yet.</div>
            @endif
        </div>

        {{-- add comment --}}
        <form id="add-comment-form" action="{{ route('content-review-comments.store') }}" method="POST"
            class="space-y-3">
            @csrf
            <input type="hidden" name="content_id" value="{{ $content->id ?? '' }}">
            <textarea name="comment" rows="3"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] dark:bg-gray-800 dark:text-gray-100 placeholder-gray-400"
                placeholder="Add a review comment..."></textarea>
            <x-button type="submit" variant="primary" class="w-full">Submit</x-button>
        </form>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const drawerElement = document.getElementById('drawer-right-example');

    if (drawerElement) {
        const drawer = new Drawer(drawerElement, {
            placement: 'right',
            backdrop: true, // ensures backdrop is shown
            backdropClasses: 'fixed inset-0 z-30 bg-black bg-opacity-50 transition-opacity',
            keyboard: true,
        });

        //  event listener for backdrop clicks
        document.addEventListener('click', function(e) {
            const backdrop = document.querySelector('.drawer-backdrop');
            if (backdrop && e.target === backdrop) {
                drawer.hide(); // close
            }
        });
    }


    $(function() {

        $('#add-comment-form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        let c = response.comment;

                        // build new comment HTML
                        let newComment = `
                            <div id="comment-${c.id}"
                                class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 mb-3 flex justify-between items-start shadow-sm">
                                <div>
                                    <p class="text-sm text-gray-800 dark:text-gray-100 leading-snug">${c.comment}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        By <span class="font-medium text-gray-900 dark:text-[#ffc449]">${c.user ? c.user.name : 'Sinong User?'}</span>
                                    </p>
                                </div>
                                <button class="delete-comment ml-3 p-2 rounded-full hover:bg-red-100 dark:hover:bg-red-900 transition-colors"
                                    data-id="${c.id}">
                                    <i class='bx bx-trash text-lg text-red-600 dark:text-red-400'></i>
                                </button>
                            </div>
                        `;

                        $("#review-comments-list .text-center").remove()
                        $("#review-comments-list").append(newComment);
                        $('#add-comment-form textarea').val("");
                    }
                },

                error: function(xhr) {
                    alert("Failed to add comment. Please try again.");
                }
            });
        });

        $(document).on('click', '.delete-comment', function() {
            if (!confirm("Delete this comment?")) return;

            let commentId = $(this).data('id');

            $.ajax({
                url: "/content-review-comments/" + commentId,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                success: function(response) {
                    if (response.success) {
                        $("#comment-" + commentId).fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                },
                error: function() {
                    alert("Failed to delete comment.");
                }
            });
        });
    });
</script>
