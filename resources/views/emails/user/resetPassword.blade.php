@component('mail::message')
# Prepareurself

Your Request To reset Password is Successfull.
Please click below link to Reset your Password.

@component('mail::button', ['url' => $url ])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
