<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Models\Member;

class MemberInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $acceptUrl;
    public $declineUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Member $member)
    {
        try {
            // Load the user relationship
            $member->load('user');
            
            if (!$member->user) {
                throw new \Exception('User not found for member');
            }
            
            $this->member = $member;
            
            // Generate signed URLs that expire in 7 days
            $this->acceptUrl = URL::temporarySignedRoute(
                'member.invitation.accept',
                now()->addDays(7),
                ['member' => $member->id]
            );
            
            $this->declineUrl = URL::temporarySignedRoute(
                'member.invitation.decline',
                now()->addDays(7),
                ['member' => $member->id]
            );

            Log::info('MemberInvitation mailable constructed successfully', [
                'member_id' => $member->id,
                'user_email' => $member->user->email
            ]);
        } catch (\Exception $e) {
            Log::error('Error constructing MemberInvitation mailable', [
                'error' => $e->getMessage(),
                'member_id' => $member->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'YouManitarian International - Membership Invitation'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): \Illuminate\Mail\Mailables\Content
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.member-invitation'
        );
    }
} 