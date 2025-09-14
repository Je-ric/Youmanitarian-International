<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MembershipPayment;
use App\Models\Member;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // notifications/index.blade.php (main)
    public function index(Request $request)
    {
        $user = $request->user();

        // Pinned invitation notifications (all of them)
        $invitationNotifications = $user->notifications()
            ->where('data->type', 'member_invitation')
            ->latest()
            ->get();

        // Normal (paginated) notifications (leave as-is)
        $notifications = $user->notifications()
            ->latest()
            ->paginate(15);

        // If you want to EXCLUDE invitations from the paginated list uncomment below:
    //  $notifications->setCollection(
    //      $notifications->getCollection()->reject(fn($n) => ($n->data['type'] ?? null) === 'member_invitation')
    //  );

        return view('notifications.index', compact('notifications', 'invitationNotifications'));
    }

    /**
     * Mark a specific notification as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    // notifications/index.blade.php (main)
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);

        if(!$notification->read_at) {
            $notification->markAsRead();
        }

        $type = $notification->data['type'] ?? 'general';

        if ($type === 'member_invitation') {
            return redirect()->route('notifications.invitation.show', $notification->id);
        }
        if ($type === 'payment_reminder') {
            return redirect()->route('notifications.show_payment_reminder', ['notification' => $notification->id]);
        }
        if (isset($notification->data['action_url'])) {
            return redirect($notification->data['action_url']);
        }

        return back();
    }

    /**
     * Mark all unread notifications as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // notifications/index.blade.php (main)
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    // notifications/paymentReminder.blade.php (main)
    public function showPaymentReminder(Request $request, DatabaseNotification $notification)
    {
        if ($notification->notifiable_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $payment = MembershipPayment::with('member.user')->findOrFail($notification->data['membership_payment_id']);
        $member = $payment->member;

        return view('notifications.paymentReminder', compact('notification', 'payment', 'member'));
    }

    // notifications/show-invitation.blade.php (main)
    public function showInvitation(Request $request, DatabaseNotification $notification)
    {
        if ($notification->notifiable_id !== $request->user()->id) {
            abort(403);
        }

        if (($notification->data['type'] ?? null) !== 'member_invitation') {
            abort(404);
        }

        // Mark as read if still unread
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $memberId = $notification->data['member_id'] ?? null;
        $member   = $memberId ? Member::with('user')->findOrFail($memberId) : null;

        $invitationMessage = $notification->data['message'] ?? null;

        // Adjust these route names if you have specific accept/decline routes
        $acceptUrl  = $member ? route('member.invitation.accept', $member->id) : '#';
        $declineUrl = $member ? route('member.invitation.decline', $member->id) : '#';

        return view('notifications.show-invitation', compact(
            'notification',
            'member',
            'invitationMessage',
            'acceptUrl',
            'declineUrl'
        ));
    }
}
