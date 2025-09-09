<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentReviewComment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ContentReviewCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // content/partials/contentReviewComments.blade.php (partial)
    public function index(Request $request)
    {
        $contentId = $request->get('content_id');
        $comments = ContentReviewComment::with('user')
            ->where('content_id', $contentId)
            ->orderBy('created_at', 'asc')
            ->get();

        // return response()->json($comments);
        return view('content.partials.contentReviewComments',
        compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // content/content_create.blade.php (main)
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to comment');
        }


        $data = $request->only(['content_id', 'comment']);
        $data['user_id'] = Auth::id();

        $validator = Validator::make($data, [
            'content_id' => 'required|integer|exists:contents,id',
            'comment' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->ajax()){

        }

        ContentReviewComment::create($data);
        return redirect()->back()->with('success', 'Comment added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    // content/content_create.blade.php (main)
    public function destroy($id)
    {
        $comment = ContentReviewComment::findOrFail($id);

        if (!Auth::check() || Auth::id() !== (int)$comment->user_id) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'error' => 'Forbidden'], 403);
            }
            return redirect()->back()->with('error', 'You can only delete your own comment.');
        }

        $comment->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Comment deleted!');
    }
}
