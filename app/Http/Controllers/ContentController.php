<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function create()
    {
        return view('content.content_create');
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function edit(Content $content)
    {
        return view('content.content_create', compact('content'));
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function store(Request $request)
    {
        $image_max_size = 51200; // 50mb
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:contents,slug',
            'content_type' => 'required|string',
            'body' => 'required|string',
            'content_status' => 'required|in:draft,published,archived',
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif|max:$image_max_size",
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => "nullable|image|mimes:jpeg,png,jpg,gif|max:$image_max_size",
            'enable_likes' => 'nullable|boolean',
            'enable_comments' => 'nullable|boolean',
            'enable_bookmark' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $user_id = Auth::id();
        $image_path = null;

        //  Single Image 
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $sanitized_title = preg_replace('/[^A-Za-z0-9\-]/', '_', $validated['title']);
            $new_filename = $sanitized_title . '_' . time() . '_' . $file->getClientOriginalName();
            $image_path = $file->storeAs('uploads/content/', $new_filename, 'public');
            $validated['image_content'] = $image_path;
        }

        $content = Content::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content_type' => $validated['content_type'],
            'body' => $validated['body'],
            'created_by' => $user_id,
            'content_status' => $validated['content_status'],
            'image_content' => $image_path,
            'approval_status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
            'views' => 0,
            'enable_likes' => $request->boolean('enable_likes', true),
            'enable_comments' => $request->boolean('enable_comments', true),
            'enable_bookmark' => $request->boolean('enable_bookmark', true),
            'published_at' => $validated['published_at'] ?? null,
            'is_featured' => $request->boolean('is_featured', false),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
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
            'slug' => 'required|string|max:255|unique:contents,slug,' . $id,
            'body' => 'required|string',
            'content_status' => 'required|in:draft,published,archived',
            'content_type' => 'required|string',
            'image' => "nullable|image|mimes:jpeg,png,jpg,gif|max:$image_max_size",
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => "nullable|image|mimes:jpeg,png,jpg,gif|max:$image_max_size",
            'enable_likes' => 'nullable|boolean',
            'enable_comments' => 'nullable|boolean',
            'enable_bookmark' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
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
        $content->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content_type' => $validated['content_type'],
            'body' => $validated['body'],
            'content_status' => $validated['content_status'],
            'image_content' => $validated['image_content'],
            'enable_likes' => $request->boolean('enable_likes', true),
            'enable_comments' => $request->boolean('enable_comments', true),
            'enable_bookmark' => $request->boolean('enable_bookmark', true),
            'published_at' => $validated['published_at'] ?? null,
            'is_featured' => $request->boolean('is_featured', false),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

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

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function content_index()
    {
        $contents = Content::latest()->paginate(perPage: 5);
        return view('content.index', compact('contents'));
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function archiveContent($id)
    {
        $content = Content::findOrFail($id);
        $content->update(['content_status' => 'archived']);
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
