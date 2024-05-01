<x-layout>
	<head>
		<style>
			/* #box {
				display: none;
			} */
			.box{
				position: fixed;
				/* top: 50%;
				left: 50%; */
				z-index: -1;
				transition: all 0.3s ease-in-out;
			}
			.box.open{
				opacity: 1;
				/* display: flex;
				align-items: center;
				justify-content: center; */
				z-index: 2;
			}
		</style>
	<div>
		<h1 class="text-2xl font-bold mb-4">Free Slots</h1>
		<table class="table-auto w-full">
			<thead>
				<tr>
					<th class="border">Lecturer ID</th>
					<th class="border">Date</th>
					<th class="border">Start Time</th>
					<th class="border">End Time</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($freeslots as $freeslot)
					<tr>
						<td class="border">{{$freeslot->lecturer_id}}</td>
						<td class="border">{{$freeslot->date}}</td>
						<td class="border">{{$freeslot->start_time}}</td>
						<td class="border">{{$freeslot->end_time}}</td>
						<td class="border">
							<form method="POST" action="/free-slots/delete/{{$freeslot->id}}">
								@csrf
								@method('DELETE')
								<button class="bg-red-400 text-white px-4 py-2" type="submit">Delete</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<form method="POST"	action="/free-slots">
			@csrf
			<h1>Add a free slot here</h1>
			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="lecturer_id">Date</label>
				<input type="date" name="date" id="start_time" value="{{old('date')}}">
				@error('date')
					<p class="text-red-500 text-xs mt-2">{{$message}}</p>
				@enderror
			</div>
			<div class="mb-4">
				<label class="block text-gray-700 text-sm font-bold mb-2" for="lecturer_id">Start Time</label>
				<input type="time" name="start_time" id="start_time" value="{{old('start_time')}}">
				@error('start_time')
					<p class="text-red-500 text-xs mt-2">{{$message}}</p>
				@enderror
			</div>
			<div>
				<label class="block text-gray-700 text-sm font-bold mb-2" for="lecturer_id">End Time</label>
				<input type="time" name="end_time" id="end_time" value="{{old('start_time')}}">
				@error('end_time')
					<p class="text-red-500 text-xs mt-2">{{$message}}</p>
				@enderror
			</div>
			<button class="bg-blue-400 text-white mt-4 px-4 py-2" type="submit">Submit</button>
		</form>
	</div>
	{{-- <script>
		// Get the date-time input field
		var dateTimeField = document.getElementById('datetime_field');

		// Add an event listener to validate the input when it changes
		dateTimeField.addEventListener('change', function() {
			// Get the current value of the input
			var value = dateTimeField.value;

			// Validate the input using a regular expression
			var regex = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/;
			if (!regex.test(value)) {
				// If the input does not match the expected format, clear the value
				dateTimeField.value = '';
				alert('Invalid date-time format. Please enter in YYYY-MM-DDTHH:MM format.');
			}
		});
	</script> --}}
	<script>
		var openBox = document.getElementById('openBox');
		var box = document.getElementById('box');
		var closeBox = document.getElementById('closeBox');

		openBox.addEventListener('click', function() {
			box.classList.add('open');
		});

		closeBox.addEventListener('click', function() {
			box.classList.remove('open');
		});
	</script>
</x-layout>