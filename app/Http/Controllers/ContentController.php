<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $myContent = Content::where('created_by', $user->id)->latest()->paginate(5, ['*'], 'myContent');
        $publishedContent = Content::where('content_status', 'published')->latest()->paginate(5, ['*'], 'publishedContent');
        $drafts = Content::where('created_by', $user->id)
            ->where('content_status', 'draft')
            ->where('approval_status', 'draft')
            ->latest()->paginate(5, ['*'], 'drafts');
        $submitted = Content::where('created_by', $user->id)
            ->where('content_status', 'draft')
            ->where('approval_status', 'submitted')
            ->latest()->paginate(5, ['*'], 'submitted');
        $archived = Content::where('created_by', $user->id)->where('content_status', 'archived')->latest()->paginate(5, ['*'], 'archived');
        $rejected = Content::where('created_by', $user->id)
            ->whereIn('approval_status', ['rejected', 'needs_revision'])
            ->latest()->paginate(5, ['*'], 'rejected');
        $needsApproval = null;
        if ($user->hasRole('Content Manager')) {
            $needsApproval = Content::whereIn('approval_status', ['submitted', 'pending'])
                ->whereHas('user', function($q) {
                    $q->whereHas('roles', function($qr) {
                        $qr->where('role_name', 'Program Coordinator');
                    });
                })
                ->latest()->paginate(5, ['*'], 'needsApproval');
        }
        return view('content.index',
        compact('myContent',
                        'publishedContent',
                                    'needsApproval',
                                    'drafts',
                        'submitted',
                                    'archived',
                                    'rejected'));
    }


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

    // When saving as draft:
    //   content_status = draft
    //   approval_status = draft

    // When submitting for approval:
    //   content_status = draft
    //   approval_status = pending (if content manager)

    // When approved:
    //   content_status = published
    //   approval_status = approved (if content manager)
    private function setContentApprovalStatus($request, $user)
    {
        $publishing_action = $request->input('publishing_action', 'draft');
        if ($publishing_action === 'published') {
            return [
                'content_status' => 'published',
                'approval_status' => 'approved',
                'approved_by' => $user->id,
                'approved_at' => now(),
            ];
        } elseif ($publishing_action === 'submitted') {
            return [
                'content_status' => 'draft',
                'approval_status' => 'submitted',
                'approved_by' => null,
                'approved_at' => null,
            ];
        } else {
            return [
                'content_status' => 'draft',
                'approval_status' => 'draft',
                'approved_by' => null,
                'approved_at' => null,
            ];
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $image_max_size = 51200; // 50mb
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:contents,slug',
            'content_type' => 'required|string',
            'body' => 'required|string',
            // 'content_status' => 'required|in:draft,published,archived',
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

        // Auto-generate slug if not provided (pero meron naman na using js)
        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;

            // Check if slug exists and add number kung may existing na
            while (Content::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $user_id = Auth::id();
        $image_path = null;

        //  Single Image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', $validated['title']);
            $timestamp = time();
            $uniqueId = uniqid();
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$sanitizedName}_{$timestamp}_{$uniqueId}.{$extension}";
            $image_path = $file->storeAs('uploads/content/', $newFilename, 'public');
            $validated['image_content'] = $image_path;
        }

        // Prepare boolean fields - handle unchecked checkboxes properly
        $enable_likes = $request->has('enable_likes') ? true : false;
        $enable_comments = $request->has('enable_comments') ? true : false;
        $enable_bookmark = $request->has('enable_bookmark') ? true : false;
        $is_featured = $request->has('is_featured') ? true : false;

        $statusArr = $this->setContentApprovalStatus($request, $user);

        $content = Content::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content_type' => $validated['content_type'],
            'body' => $validated['body'],
            'created_by' => $user_id,
            'content_status' => $statusArr['content_status'],
            'image_content' => $image_path,
            'approval_status' => $statusArr['approval_status'],
            'approved_by' => $statusArr['approved_by'],
            'approved_at' => $statusArr['approved_at'],
            'views' => 0,
            'enable_likes' => $enable_likes,
            'enable_comments' => $enable_comments,
            'enable_bookmark' => $enable_bookmark,
            'published_at' => $validated['published_at'] ?? null,
            'is_featured' => $is_featured,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        // Func. call - Multiple
        $this->handleGalleryImages($request, $content->id, $validated['title']);

        return redirect()->route('content.index')->with('toast', [
            'message' => 'Content created successfully!',
            'type' => 'success'
        ]);
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $image_max_size = 51200; // 50mb
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:contents,slug,' . $id,
            'body' => 'required|string',
            // 'content_status' => 'required|in:draft,published,archived',
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

        // Single Image - Only update if new image is uploaded
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($content->image_content) {
                Storage::disk('public')->delete($content->image_content);
            }
            $file = $request->file('image');
            $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', $validated['title']);
            $timestamp = time();
            $uniqueId = uniqid();
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$sanitizedName}_{$timestamp}_{$uniqueId}.{$extension}";
            $validated['image_content'] = $file->storeAs('uploads/content/', $newFilename, 'public');
            // [Title]_[Timestamp]_[uniqid].jpg
            // MyContentTitle_1717581234_662a1b2c3d4e5.jpg
        } else {
            $validated['image_content'] = $content->image_content; // Keep old image if no new one uploaded
        }

        // Prepare boolean fields - handle unchecked checkboxes properly
        $enable_likes = $request->has('enable_likes') ? true : false;
        $enable_comments = $request->has('enable_comments') ? true : false;
        $enable_bookmark = $request->has('enable_bookmark') ? true : false;
        $is_featured = $request->has('is_featured') ? true : false;

        $statusArr = $this->setContentApprovalStatus($request, $user);

        $content->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content_type' => $validated['content_type'],
            'body' => $validated['body'],
            'content_status' => $statusArr['content_status'],
            'image_content' => $validated['image_content'],
            'enable_likes' => $enable_likes,
            'enable_comments' => $enable_comments,
            'enable_bookmark' => $enable_bookmark,
            'published_at' => $validated['published_at'] ?? null,
            'is_featured' => $is_featured,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        // Func. call - Multiple
        $this->handleGalleryImages($request, $content->id, $validated['title']);

        return redirect()->route('content.index')->with('toast', [
            'message' => 'Content updated successfully!',
            'type' => 'success'
        ]);
    }


    // Insert into content_images table
    private function handleGalleryImages(Request $request, $contentId, $title)
    {
        if ($request->hasFile('gallery_images')) {
            $files = $request->file('gallery_images');

            // If only one file is uploaded, $files may not be an array (kase nga isa lang)
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
                    $timestamp = time();
                    $uniqueId = uniqid();
                    $extension = $file->getClientOriginalExtension();
                    $newFilename = "{$sanitizedName}_{$timestamp}_{$uniqueId}.{$extension}";
                    $gallery_path = $file->storeAs('uploads/content_gallery/', $newFilename, 'public');

                    $contentImage = ContentImage::create([
                        'content_id' => $contentId,
                        'image_path' => $gallery_path,
                    ]);
                }
            }
        }
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function destroyImage($id)
    {
        $image = ContentImage::findOrFail($id);

        // Delete image from storage (directory)
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

    public function archiveContent($id)
    {
        $content = Content::findOrFail($id);
        $content->update(['content_status' => 'archived']);
        return redirect()->route('content.index')->with('toast', [
            'message' => 'Content archived successfully!',
            'type' => 'success'
        ]);
    }

    // Approve content
    public function approveContent($id)
    {
        $content = Content::findOrFail($id);
        $user = Auth::user();

        // Only Content Manager can approve
        if (!($user->hasRole('Content Manager') || $user->id === $content->created_by)) {
            abort(403, 'You are not authorized to approve this content.');
        }

        // only approve if pending
        if ($content->approval_status !== 'pending') {
            return redirect()->route('content.index')->with('toast', [
                'message' => 'Content is not pending approval.',
                'type' => 'info'
            ]);
        }

        $content->update([
            'approval_status' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
            'content_status' => 'published',
        ]);

        return redirect()->route('content.index')->with('toast', [
            'message' => 'Content approved and published!',
            'type' => 'success'
        ]);
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    // public function destroy(Content $content)
    // {
    //     if ($content->image_content) {
    //         Storage::disk('public')->delete($content->image_content);
    //     }

    //     foreach ($content->images as $image) {
    //         Storage::disk('public')->delete($image->image_path);
    //         $image->delete();
    //     }

    //     $content->delete();

    //     return redirect()->route('content.index')->with('toast', [
    //         'message' => 'Content deleted successfully!',
    //         'type' => 'success'
    //     ]);
    // }
}
