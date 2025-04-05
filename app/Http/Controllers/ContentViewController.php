<?php

namespace App\Http\Controllers;

use Str;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Models\ContentRequest;
use Illuminate\Support\Facades\Storage;
class ContentViewController extends Controller {

    public function content_index() {
        $contents = Content::latest()->get();
        return view('content.index', compact('contents'));
    }

    public function requests_index() {
        $contentRequests = ContentRequest::with(['user', 'images'])->latest()->get();
        return view('content_requests.requests-index', compact('contentRequests'));
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    

    // from content request 
    public function create(Request $request, $request_id = null) {
        $contentRequest = $request_id ? ContentRequest::with(['user', 'images'])->find($request_id) : null;
    
        return view('content.content_create', ['contentRequest' => $contentRequest]);
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    
    
    // mark as in progress then create content with placehlders 
    public function updateRequestStatus(Request $request) {
        $request->validate([
            'id' => 'required|exists:content_requests,id',
            'status' => 'required|in:pending,in_progress,completed'
        ]);
    
        $contentRequest = ContentRequest::findOrFail($request->id);
    
        $contentRequest->update(['status' => $request->status]);
    
        if ($request->status === 'in_progress') {
            Content::create([
                'title' => $contentRequest->title,
                'body' => 'This is a placeholder body for the content.', 
                'image_content' => null, 
                'created_by' => auth()->id(), 
                'status' => 'draft', 
                'type' => 'news',  
                'slug' => Str::slug($contentRequest->title),  
                'request_id' => $contentRequest->id, 
            ]);
        }
    
        return redirect()->back()->with('success', 'Content request marked as In Progress!');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    
    
    // content archive status
    public function archiveContent($id) {
        $content = Content::findOrFail($id);
        $content->update(['status' => 'archived']);
        return redirect()->route('content.content_view')->with('message', 'Content archived successfully!');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    


    public function destroy(Content $content)
    {
        if ($content->image_content) {
            Storage::disk('public')->delete($content->image_content);
        }
    
        foreach ($content->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    
        $content->delete();
    
        return redirect()->route('content.content_view')->with('message', 'Content deleted successfully!');
    }
}
