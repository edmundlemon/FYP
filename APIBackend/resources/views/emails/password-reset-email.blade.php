@component('mail::message')
<div>
	{{-- <h1>{{ $details['title'] }}</h1> --}}
	{{-- <p>{{$message}}</p> --}}
	<p>Your OTP is:</p>
	<h1>{{$otp}}</h1>
</div>