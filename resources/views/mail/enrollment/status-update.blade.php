@component('mail::message')
# Enrollment Status Update

Dear {{ $enrollee->first_name }},

Your enrollment application for {{ $enrollee->school_year }} has been updated to: **{{ ucfirst($status) }}**

@if($status === 'review')
Your application is currently under review. We will notify you once the review process is complete.
@elseif($status === 'interviewed')
You have completed the interview process. Please wait for further instructions.
@elseif($status === 'enrolled')
Congratulations! You have been successfully enrolled.
@endif

@if($remarks)
**Additional Information:**
{{ $remarks }}
@endif

{{-- @component('mail::button', ['url' => route('enrollment.status', $enrollee->id)])
View Enrollment Status
@endcomponent --}}

If you have any questions, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
