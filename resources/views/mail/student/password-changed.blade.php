@component('mail::message')
# Password Changed

Dear {{ $student->name }},

Your account password was successfully changed on **{{ now()->format('F d, Y \a\t h:i A') }}**.

@component('mail::panel')
**Account Details**

- **Name:** {{ $student->name }}
- **Email:** {{ $student->email }}
- **Changed at:** {{ now()->format('F d, Y h:i A') }}
@endcomponent

If you did not make this change, please contact the school registrar immediately to secure your account.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
