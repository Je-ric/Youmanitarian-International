<x-mail::message>
# Thank You for Your Program Request!

Dear {{ $programRequest->name }},

Thank you for submitting your program request to **Youmanitarian International**. We have received your request and our team will review it carefully.

## Request Details
- **Program Title:** {{ $programRequest->title }}
- **Target Audience:** {{ $programRequest->target_audience }}
- **Location:** {{ $programRequest->location }}
@if($programRequest->proposed_date)
- **Proposed Date:** {{ \Carbon\Carbon::parse($programRequest->proposed_date)->format('F d, Y') }}
@endif

## What Happens Next?
Our team will carefully review your program request and evaluate how it aligns with our mission and current initiatives. We will contact you soon with our decision and next steps.

## Contact Information
If you have any questions or need to provide additional information, please don't hesitate to reach out to us.

Thank you for your interest in partnering with Youmanitarian International to make a positive impact in our community.

<x-mail::button :url="route('website.programs')">
View Our Programs
</x-mail::button>

Best regards,<br>
**Youmanitarian International Team**

---
*This is an automated message. Please do not reply to this email.*
</x-mail::message>
