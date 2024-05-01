@component('mail::message')
<div>
	{{-- <h1>{{ $details['title'] }}</h1> --}}
	<p>You have an upcoming appointment with {{$name}} at {{ $startTime }}</p>
	<p>Thank you</p>
</div>