@component('mail::message')
# Dear , {{ $user['first_name']}}


Your Request To reset password is Successfull.
Please click below Button or paste link in the browser to Reset your Password.


<a href="{{$url}}">{{$url}}</a>

@component('mail::button', ['url' => $url ])
Reset Password
@endcomponent

Sincerely ,<br>
{{ config('app.name') }}
@endcomponent
