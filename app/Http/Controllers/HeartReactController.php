<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeartReact;
use Illuminate\Support\Facades\Auth;

class HeartReactController extends Controller
{
    public function toggleReact($contentId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Login required'], 401);
        }

        $existingReact = HeartReact::where('content_id', $contentId)
            ->where('user_id', $user->id)
            ->first();

        if ($existingReact) {
            $existingReact->delete();
            $reacted = false;
        } else {
            HeartReact::create([
                'content_id' => $contentId,
                'user_id' => $user->id,
            ]);
            $reacted = true;
        }

        // Get updated count
        $heart_count = HeartReact::where('content_id', $contentId)->count();

        return response()->json([
            'status' => 'success',
            'heart_count' => $heart_count,
            'reacted' => $reacted
        ]);
    }
}
