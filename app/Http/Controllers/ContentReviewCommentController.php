<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentReviewComment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ContentReviewCommentController extends Controller
{

    // Show comments (used in partials)
    // content/partials/contentReviewComments.blade.php (partial)
    public function index(Request $request)
    {
        $contentId = $request->get('content_id');

        $comments = ContentReviewComment::with('user')
            ->where('content_id', $contentId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('content.partials.contentReviewComments', compact('comments'));
    }

    
    // content/content_create.blade.php (main)
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return $this->errorResponse('You must be logged in.', 401, $request);
        }

        $data = $request->only(['content_id', 'comment']);
        $data['user_id'] = Auth::id();

        $validator = Validator::make($data, [
            'content_id' => 'required|integer|exists:contents,id',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422, $request);
        }

        $comment = ContentReviewComment::create($data);

        return $this->successResponse([
            'comment' => $comment,
            'message' => 'Comment added!'
        ], $request);
    }

    
    // content/content_create.blade.php (main)
    public function destroy($id)
    {
        $comment = ContentReviewComment::findOrFail($id);

        if (!Auth::check() || Auth::id() !== (int) $comment->user_id) {
            return $this->errorResponse('You can only delete your own comment.', 403, request());
        }

        $comment->delete();

        return $this->successResponse([
            'message' => 'Comment deleted!'
        ], request());
    }

    /**
     * Handle success response for both AJAX and normal requests
     */
    private function successResponse(array $data, Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['success' => true] + $data);
        }

        return redirect()->back()->with('success', $data['message'] ?? 'Success');
    }

    /**
     * Handle error response for both AJAX and normal requests
     */
    private function errorResponse($error, int $status, Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['success' => false, 'error' => $error], $status);
        }

        return redirect()->back()->with('error', is_string($error) ? $error : 'Something went wrong');
    }
}
