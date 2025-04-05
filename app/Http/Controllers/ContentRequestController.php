<?php

namespace App\Http\Controllers;

use App\Models\ContentRequest;
use App\Models\ContentRequestImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContentRequestController extends Controller {   
    public function create() {
        return view('content_requests.create');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    


    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:51200', 
        ]);
    
        // Content Request
        $contentRequest = ContentRequest::create([
            'title' => $request->title,
            'description' => $request->description,
            'requested_by' => Auth::id(),
            'notes' => $request->notes,
        ]);
    
        // Multiple Image Uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '_', $request['title']);
                // $filename = Str::slug($request->title) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filename = $sanitized_title . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/content_requests/', $filename, 'public');
    
                ContentRequestImage::create([
                    'request_id' => $contentRequest->id,
                    'image_url' => $filePath,
                ]);
            }
        }
    
        return redirect()->route('content_requests.create')->with('message', 'Content request created successfully!');
    }
}
