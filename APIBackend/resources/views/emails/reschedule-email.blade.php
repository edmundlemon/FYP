@component('mail::message')
<div>
	{{-- <h1>{{ $details['title'] }}</h1> --}}
	<p>You have an upcoming appointment with {{$requestor}} has been reschedule <span style="color:red; font-weight:900;">RESCHEDULED</span></p>

	<br>
	<h3>Appointment Details</h3>
	<table>
		<tr>
			<td>Old Appointment Date:</td>
			<td>{{$oldDate}}</td>
		</tr>
		<tr>
			<td>Old Appointment Time:</td>
			<td>{{$oldStartTime}}</td>
		</tr>
	</table>
	<br>
	<table>
		<tr>
			<td>New Appointment Date:</td>
			<td>{{$newDate}}</td>
		</tr>
		<tr>
			<td>New Appointment Time:</td>
			<td>{{$newStartTime}}</td>
		</tr>
	<h4>Thank you</h4>
</div>