<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentImage;
use App\Models\ContentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function createfromRequest(Request $request)
    {
        $request_id = $request->query('request_id');
        $request_data = null;
        $request_data_images = [];

        if ($request_id) {
            $request_data = ContentRequest::find($request_id);
            $request_data_images = $request_data ? $request_data->images : [];
        }

        return view('content.content_create', compact('request_id', 'request_data', 'request_data_images'));
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    public function create()
    {
        return view('content.content_create');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════



    public function edit(Content $content)
    {
        // $content = Content::find($content->id);
        $contentRequest = $content->contentRequest;

        return view('content.content_create', compact('content', 'contentRequest'));
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    

    public function store(Request $request)
    {
        // $request_id = $request->input('request_id');
        $image_max_size = 51200; // 50mb
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'body' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif|max:$image_max_size",
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => "nullable|image|mimes:jpeg,png,jpg,gif|max:$image_max_size",
            // 'request_id' => $request_id,
        ]);

        $user_id = Auth::id();
        $image_path = null;

        //  Single Image 
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '_', $validated['title']);
            $new_filename = $sanitized_title . '_' . time() . '_' . $file->getClientOriginalName(); //concat title to the image
            $image_path = $file->storeAs('uploads/content/', $new_filename, 'public');

            $validated['image_content'] = $image_path;
        }


        // Create Content
        $content = Content::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'body' => $validated['body'],
            'created_by' => $user_id,
            'status' => $validated['status'],
            'image_content' => $image_path,
            'slug' => Str::slug($validated['title']),
        ]);

        // Multiple Image 
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file->isValid()) {
                    $new_filename = time() . '_' . $file->getClientOriginalName();
                    $gallery_path = $file->storeAs('uploads/content_gallery/', $new_filename, 'public');

                    ContentImage::create([
                        'content_id' => $content->id,
                        'image_path' => $gallery_path,
                    ]);
                }
            }
        }

        // If published and linked to request, mark request as completed
        if ($validated['status'] === 'published' && $request->filled('request_id')) {
            ContentRequest::where('id', $request->request_id)->update(['status' => 'completed']);
        }

        return redirect()->route('content.content_view')->with('toast', [
            'message' => 'Content created successfully!',
            'type' => 'success'
        ]);
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    

    public function update(Request $request, $id)
    {
        $image_max_size = 51200; // 50mb
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:draft,published',
            'type' => 'required|string',
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif|max:$image_max_size",
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => "nullable|image|mimes:jpeg,png,jpg,gif|max:$image_max_size",
        ]);

        $content = Content::findOrFail($id);

        // Single Image Update
        if ($request->hasFile('image')) {
            if ($content->image_content) {
                Storage::disk('public')->delete($content->image_content);
            }
            $file = $request->file('image');
            $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '_', $validated['title']);
            $new_filename = $sanitized_title . '_' . time() . '_' . $file->getClientOriginalName();
            $validated['image_content'] = $file->storeAs('uploads/content/', $new_filename, 'public');
        } else {
            $validated['image_content'] = $content->image_content; // Keep old image if no new one uploaded
        }

        // Update Content
        $content->update($validated);

        // Check if content request exists and update its status if content is published
        if ($content->contentRequest && $validated['status'] === 'published') {
            $content->contentRequest->update(['status' => 'completed']);
        }

        // Gallery Image Update
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                if ($file->isValid()) {
                    $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '_', $validated['title']);
                    $new_filename = $sanitized_title . '_' . time() . '_' . $file->getClientOriginalName();
                    $gallery_path = $file->storeAs('uploads/content_gallery/', $new_filename, 'public');

                    ContentImage::create([
                        'content_id' => $content->id,
                        'image_path' => $gallery_path,
                    ]);
                }
            }
        }

        return redirect()->route('content.content_view')->with('toast', [
            'message' => 'Content updated successfully!',
            'type' => 'success'
        ]);
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    

    public function destroyImage($id)
    {
        $image = ContentImage::findOrFail($id);

        // Delete image from storage
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete record from database
        $image->delete();

        return back()->with('toast', [
            'message' => 'Image deleted successfully!',
            'type' => 'success'
        ]);
    }
}
