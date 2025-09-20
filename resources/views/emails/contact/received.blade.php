<x-mail::message>
# Thank You for Contacting Us!

Dear {{ $contactInquiry->name }},

Thank you for reaching out to **Youmanitarian International**. We have received your message and our team will review it carefully.

## Your Message Details
@if($contactInquiry->subject)
- **Subject:** {{ $contactInquiry->subject }}
@endif
- **Date:** {{ $contactInquiry->created_at->format('F d, Y \a\t g:i A') }}

## What Happens Next?
Our team will carefully review your inquiry and respond to you as soon as possible. We typically respond within 24-48 hours during business days.

## Stay Connected
Follow us on our social media platforms to stay updated with our latest programs and initiatives:

- **Website:** [youmanitarian.org]({{ route('website.index') }})
- **Programs:** [View Our Programs]({{ route('website.programs') }})

Thank you for your interest in Youmanitarian International and for being part of our mission to make a positive impact in our community.

<x-mail::button :url="route('website.index')">
Visit Our Website
</x-mail::button>

Best regards,<br>
**Youmanitarian International Team**

---
*This is an automated message. Please do not reply to this email.*
</x-mail::message>
