@component('mail::message')
# Congratulation {{ $employee->name }},

You have been added as a staff in the {{ $employee->staffDepartment->department }} of Virtual-healthcare.

Click on the link below to login to your portal. The default password is "vhealth123".
We recommend changing your password after your first login.

@component('mail::button', ['url' => config('app.url').'/oauth/token'])
login
@endcomponent

Thanks,<br>
Adminstrator<br>
{{ config('app.name') }}
@endcomponent
