@component('mail::message')
# Hey, {{ $user['first_name'] }}

Thankyou, for giving us your valuable feedback.
<br>
We are on our way to provide you with best Resources.
<br>
Keep Exploring and Keep Learning!!

Thanks<br>
{{ config('app.name') }}
@endcomponent
