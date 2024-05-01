@component('mail::message')
<div>
	{{-- <h1>{{ $details['title'] }}</h1> --}}
	<p>You have an upcoming appointment with {{$requestor}} has been reschedule from {{$oldDate}} at {{$oldStartTime}} to {{$newDate}} at {{$newStartTime}}.</p>
	<p>Thank you</p>
</div>