<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Program;
use Illuminate\Support\Str;
use App\Models\ContentImage;
use Illuminate\Http\Request;
use App\Models\ContentComment;
use Illuminate\Support\Facades\Auth;
use App\Models\TeamMember;

class WebsiteController extends Controller
{
    public function index()
    {
        $featuredPost = Content::query()
            ->where('content_status', 'published')
            ->latest('created_at')
            ->first();

        $latestPosts = collect();

        if ($featuredPost instanceof Content) {
            $latestPosts = Content::query()
                ->where('content_status', 'published')
                ->where('id', '!=', $featuredPost->id)
                ->latest('created_at')
                ->take(5)
                ->get();
        }

        return view('website.index', [
            'featuredPost' => $featuredPost,
            'latestPosts'  => $latestPosts,
        ]);
    }


    public function viewContent($slug)
    {
        $content = Content::where('slug', $slug)->where('content_status', 'published')->firstOrFail();
        $content->increment('views'); //views

        // multiple images
        $galleryImages = ContentImage::where('content_id', $content->id)->get();

        // navigation
        $prevContent = Content::where('id', '<', $content->id)->where('content_status', 'published')->orderBy('id', 'desc')->first();
        $nextContent = Content::where('id', '>', $content->id)->where('content_status', 'published')->orderBy('id', 'asc')->first();

        // other contents
        $otherContents = Content::where('id', '!=', $content->id)->where('content_status', 'published')->orderBy('created_at', 'desc')->limit(10)->get();

        $comments = ContentComment::where('content_id', $content->id)->with('user')->latest()->get();

        return view('website.view-content', compact('content', 'galleryImages', 'prevContent', 'nextContent', 'otherContents', 'comments'));
    }

    // Helper function to get proper image URL
    public static function getImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return null;
        }

        $filename = basename($imagePath);
        //check file name if where it is
        if (preg_match('/\d+_[^\/]+$/', $filename)) {
            if (file_exists(public_path('storage/uploads/content/' . $filename))) {
                return asset('storage/uploads/content/' . $filename);
            }

            if (file_exists(public_path('storage/uploads/content_gallery/' . $filename))) {
                return asset('storage/uploads/content_gallery/' . $filename);
            }
        }

        // Default storage directory
        return asset('storage/' . $filename);
    }





    public function news()
    {
        return view('website.news'); // News
    }

    public function programs()
    {
        $now = now();
        $cutoff = now()->subDays(7);

        // Only programs that already ended, and ended within the last 7 days
        $programs = Program::whereRaw("TIMESTAMP(`date`, `end_time`) <= ?", [$now])
            ->whereRaw("TIMESTAMP(`date`, `end_time`) >= ?", [$cutoff])
            ->orderBy('date', 'desc')
            ->get();

        return view('website.programs', compact('programs'));
    }

    public function sponsors()
    {
        return view('website.sponsors'); // Sponsors & Partnership
    }

    public function about()
    {
        return view('website.about'); // About Us
    }

    public function team()
    {

        $founder = TeamMember::where('category', 'founder')->first();

        $executives = TeamMember::where('is_active', true)
            ->where('category', 'executive')
            ->orderBy('name', 'asc')
            ->get();

        $members = TeamMember::where('is_active', true)
            ->where('category', 'member')
            ->orderBy('name', 'asc')
            ->get();

        $developers = TeamMember::where('is_active', true)
            ->where('category', 'developer')
            ->orderBy('name', 'asc')
            ->get();


        return view(
            'website.team',
            compact(
                'founder',
                'executives',
                'members',
                'developers'
            )
        ); // Meet the team
    }

    public function donate()
    {
        return view('website.donate'); // Donate
    }

    public function forecast()
    {
        $OPEN_WEATHERMAP_KEY1 = env('OPEN_WEATHERMAP_KEY1');
        return view('weather-forecast.index', compact('OPEN_WEATHERMAP_KEY1'));
    }

    public function chatbot()
    {
        return view('chatbot.index');
    }
}
