<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon; // add

class ContentController extends Controller
{

    // content/index.blade.php (main)
    public function index()
    {
        $user = Auth::user();
        $myContent = Content::where('created_by', $user->id)->latest()->paginate(5, ['*'], 'myContent');
        $publishedContent = Content::where('content_status', 'published')->latest()->paginate(5, ['*'], 'publishedContent');
        $archived = Content::where('content_status', 'archived')->latest()->paginate(5, ['*'], 'archived');

        $needsRevision = null;
        if ($user->hasRole('Program Coordinator')) {
            $needsRevision = Content::where('created_by', $user->id)
                ->where('approval_status', 'needs_revision')
                ->latest()->paginate(5, ['*'], 'needsRevision');
        }

        $needsApproval = null;
        if ($user->hasRole('Content Manager')) {
            $needsApproval = Content::whereIn('approval_status', ['submitted', 'pending'])
                ->latest()->paginate(5, ['*'], 'needsApproval');
        }

        $submitted = null;
        if ($user->hasRole('Program Coordinator')) {
            $submitted = Content::where('created_by', $user->id)
                ->whereIn('approval_status', ['submitted', 'pending'])
                ->latest()->paginate(5, ['*'], 'submitted');
        }
        if (!isset($submitted)) {
            $submitted = null;
        }
        return view('content.index',
            compact('myContent',
                    'publishedContent',
                    'archived',
                    'needsApproval',
                    'needsRevision',
                    'submitted')
        );
    }


    // content/content_create.blade.php (main)
    public function create()
    {
        return view('content.content_create');
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    // content/content_create.blade.php (main)
    public function edit(Content $content)
    {
        $user = Auth::user();

        // Base rule: review mode if not the owner
        $reviewMode = $user->id !== $content->created_by;

        // lock Program Coordinator's own published content (no direct editing)
        if (
            $user->id === $content->created_by &&
            $content->content_status === 'published' &&
            $user->hasRole('Program Coordinator') &&
            !$user->hasRole('Content Manager') &&
            !$user->hasRole('Admin')
        ) {
            $reviewMode = true;
        }

        return view('content.content_create', compact('content', 'reviewMode'));
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
        // If resubmitting from needs_revision, allow transition to submitted/pending
        if ($publishing_action === 'published') {
            return [
                'content_status' => 'published',
                'approval_status' => 'approved',
                'approved_by' => $user->id,
                'approved_at' => now(),
            ];
        } elseif ($publishing_action === 'submitted') {
            // If Content Manager, set to pending; else, set to submitted
            $isContentManager = $user->hasRole('Content Manager');
            return [
                'content_status' => 'draft',
                'approval_status' => $isContentManager ? 'pending' : 'submitted',
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

    // content/content_create.blade.php (main)
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
            // removed: 'published_at' => 'nullable|date',
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

        // Default published_at -> now() when publishing directly or auto-approved
        $publishedAt = null;
        if (($statusArr['content_status'] ?? null) === 'published' || ($statusArr['approval_status'] ?? null) === 'approved') {
            $publishedAt = now();
        }

        $content = Content::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content_type' => $validated['content_type'],
            'body' => $validated['body'],
            'created_by' => $user->id,
            'content_status' => $statusArr['content_status'],
            'image_content' => $image_path,
            'approval_status' => $statusArr['approval_status'],
            'approved_by' => $statusArr['approved_by'],
            'approved_at' => $statusArr['approved_at'],
            'views' => 0,
            'enable_likes' => $enable_likes,
            'enable_comments' => $enable_comments,
            'enable_bookmark' => $enable_bookmark,
            'published_at' => $publishedAt, // set automatically
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

    // content/content_create.blade.php (main)
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
            // removed: 'published_at' => 'nullable|date',
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

        // prepare
        $enable_likes = $request->has('enable_likes') ? true : false;
        $enable_comments = $request->has('enable_comments') ? true : false;
        $enable_bookmark = $request->has('enable_bookmark') ? true : false;
        $is_featured = $request->has('is_featured') ? true : false;

        $statusArr = $this->setContentApprovalStatus($request, $user);

        $newApprovalStatus = $statusArr['approval_status'];
        $newContentStatus = $statusArr['content_status'];

        // Preserve existing published_at, set now() if publishing/approving and not set yet
        $publishedAt = $content->published_at;
        if ($newContentStatus === 'published' || $newApprovalStatus === 'approved') {
            $publishedAt = $publishedAt ?: now();
        }

        $content->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content_type' => $validated['content_type'],
            'body' => $validated['body'],
            'content_status' => $newContentStatus,
            'approval_status' => $newApprovalStatus,
            'approved_by' => $statusArr['approved_by'] ?? $content->approved_by,
            'approved_at' => $statusArr['approved_at'] ?? $content->approved_at,
            'image_content' => $validated['image_content'],
            'enable_likes' => $enable_likes,
            'enable_comments' => $enable_comments,
            'enable_bookmark' => $enable_bookmark,
            'published_at' => $publishedAt, // auto-managed
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

    // content/content_create.blade.php (main)
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

    // content/index.blade.php (main)
    public function archiveContent($id)
    {
        $content = Content::findOrFail($id);
        $content->update(['content_status' => 'archived']);
        return redirect()->route('content.index')->with('toast', [
            'message' => 'Content archived successfully!',
            'type' => 'success'
        ]);
    }

    // content/index.blade.php (main)
    public function approveContent($id)
    {
        $content = Content::findOrFail($id);
        $user = Auth::user();

        // Only Content Manager can approve
        if (!($user->hasRole('Content Manager') || $user->id === $content->created_by)) {
            abort(403, 'You are not authorized to approve this content.');
        }

        // only approve if pending or submitted
        if (!in_array($content->approval_status, ['pending', 'submitted'])) {
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
            'published_at' => $content->published_at ?: now(), // keep if already set, else now
        ]);

        return redirect()->route('content.index')->with('toast', [
            'message' => 'Content approved and published!',
            'type' => 'success'
        ]);
    }

    // content/index.blade.php (main)
    public function needsRevisionContent($id)
    {
        $content = Content::findOrFail($id);
        $user = Auth::user();

        if (!$user->hasRole('Content Manager')) {
            abort(403, 'You are not authorized to mark this content as needs revision.');
        }

        // if submitted or pending
        if (!in_array($content->approval_status, ['submitted', 'pending'])) {
            return redirect()->route('content.index')->with('toast', [
                'message' => 'Content is not awaiting review.',
                'type' => 'info'
            ]);
        }

        $content->update([
            'approval_status' => 'needs_revision',
            'content_status' => 'draft',
        ]);

        return redirect()->route('content.index')->with('toast', [
            'message' => 'Content marked as needing revision.',
            'type' => 'warning'
        ]);
    }

    // unused (kinomment muna sa preview)
    // content/index.blade.php (main)
    // public function rejectContent($id)
    // {
    //     $content = Content::findOrFail($id);
    //     $user = Auth::user();

    //     if (!$user->hasRole('Content Manager')) {
    //         abort(403, 'You are not authorized to reject this content.');
    //     }

    //     //  if submitted or pending
    //     if (!in_array($content->approval_status, ['submitted', 'pending'])) {
    //         return redirect()->route('content.index')->with('toast', [
    //             'message' => 'Content is not awaiting review.',
    //             'type' => 'info'
    //         ]);
    //     }

    //     $content->update([
    //         'approval_status' => 'rejected',
    //         'content_status' => 'draft',
    //     ]);

    //     return redirect()->route('content.index')->with('toast', [
    //         'message' => 'Content rejected.',
    //         'type' => 'error'
    //     ]);
    // }

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

    // content/content_create.blade.php (main)
    public function review(Content $content)
    {
        // only review if content is pending or submitted
        if (!in_array($content->approval_status, ['pending', 'submitted'])) {
            return redirect()->route('content.index')->with('toast', [
                'message' => 'Content is not awaiting review.',
                'type' => 'info'
            ]);
        }
        $reviewMode = true;
        return view('content.content_create', compact('content', 'reviewMode'));
    }
}
