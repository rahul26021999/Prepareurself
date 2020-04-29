@component('mail::message')
# Hey, {{ $user['first_name'] }}

<b class="appColor">Thankyou</b>, for giving us your valuable feedback.
<br>
We are on our way to provide you with best Resources.
<br>
Keep Exploring and Keep Learning!!

Thanks<br>
<b class="appColor">{{ config('app.name') }}</b>
@endcomponent
