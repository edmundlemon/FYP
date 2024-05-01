<x-layout>
	<x-slot name="title">Consultation</x-slot>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			Consultation
		</h2>
	</x-slot>
	<div class="py-12">
		<table>
			<tr>
				<td>Start Date</td>
				<td>Start Time</td>
				<td>End Time</td>
				<td>Lecturer</td>
			</tr>
			@foreach($consultation_slots as $consultation)
			<tr>
				<td>{{ $consultation->date }}</td>
				<td>{{ $consultation->start_time }}</td>
				<td>{{ $consultation->end_time }}</td>
				<td>{{ $consultation->lecturer->name }}</td>
				<td>
					<form action="/student/reschedule/{{$consultation->id}}" method="POST" id="{{$consultation->id}}">
						@csrf
						@method('PUT')
						<div class="mb-4">
							Date: <input type="date" name="date" value="{{$consultation->date}}"><br>
							Start Time: <input type="time" name="start_time" value="{{$consultation->start_time}}"><br>
							@error('start_time')
								<p class="text-red-500 text-xs mt-2">{{$message}}</p>
							@enderror
						</div>
						<div class="mb-4">
							End Time: <input type="time" name="end_time" value="{{$consultation->end_time}}"><br>
							@error('end_time')
								<p class="text-red-500 text-xs mt-2">{{$message}}</p>
							@enderror	
						</div>
						<button class="bg-blue-400 text-white mt-4 px-4 py-2" type="button" onclick="submitForm({{$consultation->id}})">Reschedule</button>
					</form>
				</td>
			</tr>
			@endforeach
		</table>
	</div>

	<script>
		function submitForm(formId) {
    		var form = document.getElementById(formId);
   			 form.submit();
		}
	</script>
</x-layout>