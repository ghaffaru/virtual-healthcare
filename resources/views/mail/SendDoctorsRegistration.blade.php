@component('mail::message')
# Congratulation Dr. {{ $doctor->name }},

You have been employed 

{{-- @component('mail::button', ['url' => '/'])
Button Text
@endcomponent
 --}}
Thanks,<br>
{{ config('app.name') }}
@endcomponent
