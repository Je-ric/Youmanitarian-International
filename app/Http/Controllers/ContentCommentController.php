<?php

namespace App\Http\Controllers;

use App\Models\ContentComment;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentCommentController extends Controller {
    public function store(Request $request, $contentId) {
        $request->validate(['comment' => 'required|string|max:500']);

        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to comment'], 401);
        }

        $comment = ContentComment::create([
            'content_id' => $contentId,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Comment added successfully', 'comment' => $comment]);
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    public function update(Request $request, $commentId) {
        $comment = ContentComment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate(['comment' => 'required|string|max:500']);
        $comment->update(['comment' => $request->comment]);

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment]);
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    


    public function destroy($commentId) {
        $comment = ContentComment::findOrFail($commentId);

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    


    public function fetchComments($contentId) {
        $comments = ContentComment::where('content_id', $contentId)->with('user')->latest()->get();
        return response()->json($comments);
    }
}
