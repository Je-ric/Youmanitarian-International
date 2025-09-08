
<div id="drawer-right-example"
     class="fixed top-0 right-0 z-40 h-screen p-0 overflow-y-auto transition-transform translate-x-full bg-white shadow-xl border-l border-gray-200 w-80 dark:bg-gray-800 dark:border-gray-700"
     tabindex="-1" aria-labelledby="drawer-right-label">

    <!-- Header -->
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700 rounded-t-xl bg-white dark:bg-gray-800">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center justify-center w-8 h-8 bg-[#e6e8ef] rounded-lg">
                <svg class="w-4 h-4 text-[#1a2235]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
            </span>
            <h5 id="drawer-right-label" class="text-md font-semibold text-[#1a2235] dark:text-gray-100 mt-0 mb-0">Content Review Comments</h5>
        </div>
        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white transition-colors"
                >
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
    </div>

    <!-- Body -->
    <div class="px-5 py-4 space-y-6">
        @if(isset($content) && $content->reviewComments && $content->reviewComments->count())
            <div class="space-y-3">
                @foreach($content->reviewComments as $comment)
                    <div class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-lg px-3 py-2 flex justify-between items-start">
                        <div>
                            <div class="text-sm text-gray-800 dark:text-gray-100">{{ $comment->comment }}</div>
                            <div class="text-xs text-gray-500 mt-1">
                                By <span class="font-medium text-[#1a2235] dark:text-[#ffc449]">{{ $comment->user ? $comment->user->name : 'Sinong User?' }}</span>
                            </div>
                        </div>
                        <form action="{{ route('content-review-comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete" class="ml-2 p-1 h-7 w-7 flex items-center justify-center rounded hover:bg-red-50 dark:hover:bg-red-900 transition-colors">
                                <i class='bx bx-trash text-lg text-red-600 dark:text-red-400'></i>
                                <span class="sr-only">Delete</span>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-400 text-center py-8">No review comments yet.</div>
        @endif

        <!-- Add Comment Form -->
        <form action="{{ route('content-review-comments.store') }}" method="POST" class="space-y-2">
            @csrf
            <input type="hidden" name="content_id" value="{{ $content->id ?? '' }}">
            <textarea name="comment" rows="2" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] dark:bg-gray-800 dark:text-gray-100" placeholder="Add a review comment...">{{ old('comment') }}</textarea>
            <x-button type="submit" variant="primary" class="w-full">Submit</x-button>
        </form>
    </div>
</div>


<script>
    // Initialize Flowbite drawer
    const drawerElement = document.getElementById('drawer-right-example');
    if (drawerElement) {
        const drawer = new Drawer(drawerElement, {
            placement: 'right',
            backdrop: true,
            keyboard: true,
        });
    }


</script>
