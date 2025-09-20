<x-mail::message>
# Program Request Approved!

Dear {{ $programRequest->name }},

Great news! Your program request **"{{ $programRequest->title }}"** has been approved by our team.

## Request Details
- **Program Title:** {{ $programRequest->title }}
- **Target Audience:** {{ $programRequest->target_audience }}
- **Location:** {{ $programRequest->location }}
@if($programRequest->proposed_date)
- **Proposed Date:** {{ \Carbon\Carbon::parse($programRequest->proposed_date)->format('F d, Y') }}
@endif

## What Happens Next?
Our team will now begin planning and organizing your approved program. We will contact you soon with more details about the implementation timeline and next steps.

## Stay Connected
Follow us on our social media platforms to stay updated with our latest programs and initiatives.

Thank you for your valuable contribution to Youmanitarian International!

<x-mail::button :url="route('website.programs')">
View Our Programs
</x-mail::button>

Best regards,<br>
**Youmanitarian International Team**

---
*This is an automated message. Please do not reply to this email.*
</x-mail::message>
