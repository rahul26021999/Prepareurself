@extends('emails.makdowncopy')

@section('content')

{!! html_entity_decode($body) !!} 

@endsection