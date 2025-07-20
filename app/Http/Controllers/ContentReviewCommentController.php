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
    public function index(Request $request)
    {
        $contentId = $request->get('content_id');
        $comments = ContentReviewComment::where('content_id', $contentId)
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json($comments);
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
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to comment'], 401);
        }
        $data = $request->only(['content_id', 'comment']);
        $data['user_id'] = Auth::id();
        $validator = Validator::make($data, [
            'content_id' => 'required|integer|exists:contents,id',
            'comment' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $comment = ContentReviewComment::create($data);
        return response()->json($comment, 201);
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
    public function destroy($id)
    {
        $comment = ContentReviewComment::findOrFail($id);
        $comment->delete();
        return response()->json(['success' => true]);
    }
}
