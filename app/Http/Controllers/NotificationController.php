<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MembershipPayment;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->paginate(10);

        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a specific notification as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        
        if(!$notification->read_at) {
            $notification->markAsRead();
        }

        if (isset($notification->data['action_url'])) {
            return redirect($notification->data['action_url']);
        }

        $notificationType = $notification->data['type'] ?? 'general';

        if ($notificationType === 'payment_reminder') {
            return redirect()->route('notifications.show_payment_reminder', ['notification' => $notification->id]);
        }

        return redirect()->back();
    }

    /**
     * Mark all unread notifications as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function showPaymentReminder(Request $request, DatabaseNotification $notification)
    {
        if ($notification->notifiable_id !== $request->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $payment = MembershipPayment::with('member.user')->findOrFail($notification->data['membership_payment_id']);
        $member = $payment->member;

        return view('notifications.paymentReminder', compact('notification', 'payment', 'member'));
    }
}
