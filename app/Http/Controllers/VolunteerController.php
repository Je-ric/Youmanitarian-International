<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VolunteerController extends Controller
{
    // volunteers/index.blade.php (main)
    public function gotoVolunteersList(Request $request)
    {
        // Get the current tab from the request
        $currentTab = $request->get('tab', 'applications');
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'asc'); // Default to earliest first

        // Get the page number for the current tab
        $page = $request->get('page', 1);

        // Build queries with search and sorting
        $applicationsQuery = Volunteer::with('user')
            ->where('application_status', 'pending');

        $deniedQuery = Volunteer::with('user')
            ->where('application_status', 'denied');

        $approvedQuery = Volunteer::with('user')
            ->where('application_status', 'approved');

        // Apply search filter
        if ($search) {
            $applicationsQuery->whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });

            $deniedQuery->whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });

            $approvedQuery->whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $applicationsQuery->orderBy($sortBy, $sortOrder);
        $deniedQuery->orderBy($sortBy, $sortOrder);
        $approvedQuery->orderBy($sortBy, $sortOrder);

        $applications = $applicationsQuery->paginate(10, ['*'], 'page', $currentTab === 'applications' ? $page : 1);
        $deniedApplications = $deniedQuery->paginate(10, ['*'], 'page', $currentTab === 'denied' ? $page : 1);
        $approvedVolunteers = $approvedQuery->paginate(10, ['*'], 'page', $currentTab === 'approved' ? $page : 1);

        // Preserve search parameters in pagination links
        $applications->appends(['tab' => 'applications', 'search' => $search, 'sort_by' => $sortBy, 'sort_order' => $sortOrder]);
        $deniedApplications->appends(['tab' => 'denied', 'search' => $search, 'sort_by' => $sortBy, 'sort_order' => $sortOrder]);
        $approvedVolunteers->appends(['tab' => 'approved', 'search' => $search, 'sort_by' => $sortBy, 'sort_order' => $sortOrder]);

        $total = $approvedVolunteers->count() + $deniedApplications->count();
        $approvalRate = $total > 0 ? round(($approvedVolunteers->count() / $total) * 100) : 0;

        $recentActivities = $applications->merge($deniedApplications)->merge($approvedVolunteers)
            ->sortByDesc('updated_at')
            ->take(5);

        return view(
            'volunteers.index',
            compact(
                'applications',
                'deniedApplications',
                'approvedVolunteers',
                'approvalRate',
                'recentActivities',
                'search',
                'sortBy',
                'sortOrder'
            )
        );
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    // volunteers/volunteer-details.blade.php (main)
    public function gotoVolunteerDetails($id)
    {
        //  volunteer with associated programs and consultation hours (through user)
        $volunteer = Volunteer::with(['programs', 'user.consultationHours'])->findOrFail($id);

        return view('volunteers.volunteer-details', compact('volunteer'));
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function myProfile()
    {
        $user = Auth::user();

        $volunteer = Volunteer::with([
            'user.roles',
            'programs',
            'attendanceLogs.program',
            'application',
            'member.payments'
        ])->where('user_id', $user->id)->first();

        if (!$volunteer) {
            return redirect()
                ->route('volunteers.form')
                ->with('toast', [
                    'message' => 'You have not created a volunteer profile yet. Please apply first.',
                    'type' => 'info'
                ]);
        }

        return view('volunteers.volunteer-details', compact('volunteer'));
    }
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_pic' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
        ]);

        $user = Auth::user();

        // Delete old stored file if it lives in our managed folder
        if ($user->profile_pic && str_starts_with($user->profile_pic, 'storage/uploads/profile_photo/')) {
            $oldPath = str_replace('storage/', '', $user->profile_pic); // convert to disk-relative
            Storage::disk('public')->delete($oldPath);
        }

        $file = $request->file('profile_pic');

        // Sanitize name (letters & numbers only). Fallback 'User' if becomes empty.
        $sanitizedName = preg_replace('/[^A-Za-z0-9]/', '', $user->name);
        if ($sanitizedName === '') {
            $sanitizedName = 'User';
        }

        $dateString = now()->format('Ymd');
        $timestamp  = time();
        $extension  = $file->getClientOriginalExtension();
        $newFilename = "{$sanitizedName}_{$dateString}_{$timestamp}.{$extension}";

        // Store as: storage/uploads/profile_photo/[SanitizedName]_[YYYYMMDD]_[timestamp].ext
        $storedRelativePath = $file->storeAs('uploads/profile_photo', $newFilename, 'public');

        $user->update([
            'profile_pic' => 'storage/' . $storedRelativePath,
        ]);

        return back()->with('toast', [
            'message' => 'Profile photo updated.',
            'type' => 'success'
        ]);
    }
}
