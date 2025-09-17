<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Program;
use App\Models\Content;
use App\Models\Donation;
use App\Models\MembershipPayment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        // Admin metrics
        if ($user->hasRole('Admin')) {
            $data['admin'] = [
                'usersCount' => User::count(),
                'programsCount' => Program::count(),
                'contentsCount' => Content::count(),
                'donationsTotal' => Donation::where('status', 'Confirmed')->sum('amount'),
                'pendingDonations' => Donation::where('status', 'Pending')->count(),
            ];
        }

        // Content Manager metrics
        if ($user->hasRole('Content Manager')) {
            $data['cm'] = [
                'needsApproval' => Content::whereIn('approval_status', ['submitted', 'pending'])->count(),
                'published' => Content::where('content_status', 'published')->count(),
                'myDrafts' => Content::where('created_by', $user->id)
                                     ->where('content_status', 'draft')
                                     ->count(),
            ];
        }

        // Program Coordinator metrics
        if ($user->hasRole('Program Coordinator')) {
            $now = now();
            $data['pc'] = [
                'myPrograms' => Program::where('created_by', $user->id)->count(),
                'ongoing' => Program::whereRaw("TIMESTAMP(`date`, `start_time`) <= ?", [$now])
                                    ->whereRaw("TIMESTAMP(`date`, `end_time`) >= ?", [$now])
                                    ->count(),
                'upcoming' => Program::whereRaw("TIMESTAMP(`date`, `end_time`) > ?", [$now])->count(),
            ];
        }

        // Financial Coordinator metrics
        if ($user->hasRole('Financial Coordinator')) {
            $data['fc'] = [
                'membershipRevenue' => MembershipPayment::where('payment_status', 'paid')->sum('amount'),
                'overduePayments' => MembershipPayment::where('payment_status', 'overdue')->count(),
                'donationsPending' => Donation::where('status', 'Pending')->count(),
                'donationsConfirmed' => Donation::where('status', 'Confirmed')->count(),
            ];
        }

        // Volunteer metrics
        if ($user->hasRole('Volunteer')) {
            $volunteer = $user->volunteer;
            $totalHours = $volunteer?->total_hours ?? 0;

            if ($totalHours === 0 && $volunteer) {
                $totalHours = $volunteer->attendanceLogs()->sum('hours_logged');
            }

            $joinedProgramsCount = Program::whereHas('volunteers', function ($q) use ($user) {
                $q->where('volunteers.user_id', $user->id)
                  ->where('program_volunteers.status', 'approved');
            })->count();

            $data['volunteer'] = [
                'joinedPrograms' => $joinedProgramsCount,
                'totalHours' => $totalHours,
            ];
        }

        return view('dashboard', [
            'user' => $user,
            'data' => $data,
        ]);
    }
}
