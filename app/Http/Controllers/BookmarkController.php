<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    // website/view-content.blade.php (main)
    public function toggle($contentId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Login required'], 401);
        }

        $existing = Bookmark::where('content_id', $contentId)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            Bookmark::create([
                'content_id' => $contentId,
                'user_id' => $user->id,
            ]);
            $bookmarked = true;
        }

        $bookmark_count = Bookmark::where('content_id', $contentId)->count();

        return response()->json([
            'status' => 'success',
            'bookmark_count' => $bookmark_count,
            'bookmarked' => $bookmarked,
        ]);
    }
}
