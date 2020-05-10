@component('mail::message')
# Hey, {{ $user['first_name'] }}


Please click the button below or click on the link to verify your email address.

@component('mail::button', ['url' =>  $url ])
Verify Email Address
@endcomponent

<a href="{{$url}}">{{$url}}</a>
<br>
<p>If you did not create an account, no further action is required.</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
