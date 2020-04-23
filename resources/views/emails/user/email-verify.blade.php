@component('mail::message')
# Hey, {{ $user['first_name'] }}

Please click the button below or click on the link to verify your email address.

<a href="{{$url}}">{{$url}}</a>

@component('mail::button', ['url' =>  $url ])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
