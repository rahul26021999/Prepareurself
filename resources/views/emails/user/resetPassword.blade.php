@component('mail::message')
# Dear , {{ $user['first_name']}}


Your Request To reset password is Successfull.
Please click below Button or paste link in the browser to Reset your Password.



@component('mail::button', ['url' => $url ])
Reset Password
@endcomponent

<a href="{{$url}}">{{$url}}</a>

Sincerely ,<br>
{{ config('app.name') }}
@endcomponent
