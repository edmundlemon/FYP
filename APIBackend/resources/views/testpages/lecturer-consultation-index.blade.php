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
				<td class="border border-gray-400 m-4 p-5">Start Date</td>
				<td class="border border-gray-400 m-4 p-5">Start Time</td>
				<td class="border border-gray-400 m-4 p-5">End Time</td>
				<td class="border border-gray-400 m-4 p-5">Student</td>
				<td class="border border-gray-400 m-4 p-5">Rescheduling</td>
				<td class="border border-gray-400 m-4 p-5" colspan="2">Action</td>
			</tr>
			@foreach($consultation_slots as $consultation)
			<tr>
				<td class="border border-gray-400 m-4">{{ $consultation->date }}</td>
				<td class="border border-gray-400 m-4">{{ $consultation->start_time }}</td>
				<td class="border border-gray-400 m-4">{{ $consultation->end_time }}</td>
				<td class="border border-gray-400 m-4">{{ $consultation->student->name }}</td>
				<td class="border border-gray-400 m-4">
					<form action="/lecturer/reschedule/{{$consultation->id}}" method="POST" id="{{$consultation->id}}">
						@csrf
						@method('PUT')
						<div class="mb-4">
							Date: <input type="date" name="date" value="{{$consultation->date}}"><br>
							@error('date')
								<p class="text-red-500 text-xs mt-2">{{$message}}</p>
							@enderror
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
				<td class="border border-gray-400 m-4">
					<form action="/approve/{{$consultation->id}}" method="POST" id="approve{{$consultation->id}}">
						@csrf
						@method('PUT')
						{{-- <input type="date" name="date" class="hidden" value="{{$consultation->date}}"><br>
						<input type="time" name="start_time" class="hidden" value="{{$consultation->start_time}}"><br>
						<input type="time" name="end_time" class="hidden" value="{{$consultation->end_time}}"><br> --}}

						<button class="bg-blue-400 text-white mt-4 px-4 py-2" type="button" onclick="submitForm('approve{{$consultation->id}}')">Approve</button>
						@if(session('error'))
							<div class="alert alert-danger">
								{{ session('error') }}
							</div>
						@endif
					</form>
				</td>
				<td class="border border-gray-400 m-4">
					<form action="/lecturer/reject/{{$consultation->id}}" method="POST" id="reject{{$consultation->id}}">
						@csrf
						@method('DELETE')
						<button class="bg-red-400 text-white mt-4 px-4 py-2" type="button" onclick="submitForm('reject{{$consultation->id}}')">Reject</button>
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