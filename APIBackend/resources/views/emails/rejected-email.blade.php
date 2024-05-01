@component('mail::message')
<div>
	{{-- <h1>{{ $details['title'] }}</h1> --}}
	<p>Your appointment request with {{$name}} has been REJECTED.</p>
	<p>Appointment Date: {{$date}}</p>
	<p>Appointment Time: {{$start_time}}</p>
	<p>Thank you</p>
</div>