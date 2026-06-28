@component('mail::message')
# Profile Updated

Dear {{ $student->name }},

Your profile information has been successfully updated on **{{ now()->format('F d, Y \a\t h:i A') }}**.

@component('mail::panel')
**Updated Details**

- **Name:** {{ $student->name }}
- **Email:** {{ $student->email }}
@if($student->studentProfile?->contact_number)
- **Contact Number:** {{ $student->studentProfile->contact_number }}
@endif
@if($student->studentProfile?->parent_name)
- **Parent / Guardian:** {{ $student->studentProfile->parent_name }}
@endif
@endcomponent

If you did not make this change, please contact the school registrar immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
