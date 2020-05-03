@component('mail::message')
# Hey, {{ $user['first_name'] }}


Your Password is changed.
If, It is not done by you please free feel to contact us and change change your Password now.


@component('mail::button', ['url' => 'mailto:contact@prepareurself.in'])
Contact us
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
