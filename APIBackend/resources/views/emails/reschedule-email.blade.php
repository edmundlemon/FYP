@component('mail::message')
<div>
	{{-- <h1>{{ $details['title'] }}</h1> --}}
	<p>You have an upcoming appointment with {{$requestor}} has been <span style="color:red; font-weight:900;">RESCHEDULED</span></p>

	<br>
	<h3>Appointment Details</h3>
	<table>
		<tr>
			<td>New Appointment Date:</td>
			<td>{{$newDate}}</td>
		</tr>
		<tr>
			<td>New Appointment Time:</td>
			<td>{{$newStartTime}}</td>
		</tr>
	</table>
	<h4>Thank you</h4>
</div>