@component('mail::message')
# Congratulation Dr. {{ $doctor->name }},

You have been added as a staff to Virtual-health.

Click on the link to login to your portal. The default password is "vhealth123".
We recommend changing your password after logging in

{{-- @component('mail::button', ['url' => '/'])
Button Text
@endcomponent
 --}}
Thanks,<br>
{{ config('app.name') }}
@endcomponent
