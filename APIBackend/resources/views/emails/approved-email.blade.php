@component('mail::message')
<div class="flex justify-content">
	{{-- <h1>{{ $details['title'] }}</h1> --}}
	<p>Your appointment request with {{$name}} has been <span style="color: green; font-weight:900;">APPROVED</span></p>
	<br>
	<h3>Appointment Details</h3>
	<table>
		<tr>
			<td>Appointment Date:</td>
			<td>{{$date}}</td>
		</tr>
		<tr>
			<td>Appointment Time:</td>
			<td>{{$start_time}}</td>
		</tr>
	</table>
	<h4>Thank you</h4>
</div>