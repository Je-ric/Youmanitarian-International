
<div id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
    <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>Right drawer</h5>
   <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
      <span class="sr-only">Close menu</span>
   </button>

   <div>
    @if(isset($content) && $content->reviewComments && $content->reviewComments->count())
        <div>
            @foreach($content->reviewComments as $comment)
                <div class="border-b py-2 flex justify-between items-center">
                    <div>
                        <div>{{ $comment->comment }}</div>
                        <div class="text-xs text-gray-400 mt-1">
                            By {{ $comment->user ? $comment->user->name : 'Sinong User?' }}
                        </div>
                    </div>
                    <form action="{{ route('content-review-comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 text-xs">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-gray-400">No review comments yet.</div>
    @endif

    <form action="{{ route('content-review-comments.store') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="content_id" value="{{ $content->id ?? '' }}">
        <textarea name="comment" rows="2" class="w-full border rounded p-2 mb-2"
                placeholder="Add a review comment...">{{ old('comment') }}</textarea>
        <button type="submit" class="w-full bg-blue-600 text-white rounded p-2">Submit</button>
    </form>
</div>


</div>
