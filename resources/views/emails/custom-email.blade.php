@component('mail::message')
# Hey, {{ $user['first_name'] }}

{!! html_entity_decode($body) !!} 

Thanks<br>
{{ config('app.name') }}
@endcomponent
