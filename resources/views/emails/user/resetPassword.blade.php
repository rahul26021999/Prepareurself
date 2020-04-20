@component('mail::message')
# Hey , {{ $user['first_name']}}

Your Request To reset Password is Successfull.
Please click below link to Reset your Password.

@component('mail::button', ['url' => $url ])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
