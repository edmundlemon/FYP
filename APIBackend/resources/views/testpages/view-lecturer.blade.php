<x-layout>
	<h1 class="text-2xl font-bold mb-4">View Lecturer</h1>
	<table class="table-auto w-full">
		<thead>
			<tr>
				<th class="border">Name</th>
				<th class="border">Email</th>
				<th class="border">Faculty</th>
				<th class="border">Program</th>
				<th class="border">Photo</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="border"><a href="/upcoming/{{$lecturer->id}}">{{$lecturer->name}}</a></td>
				<td class="border">{{$lecturer->email}}</td>
				<td class="border">{{$lecturer->faculty}}</td>
				<td class="border">{{$lecturer->program}}</td>
				<td class="border">
					<img src="{{asset('storage/'.$lecturer->photo)}}" alt="" class="w-24">
				</td>
			</tr>
		</tbody>
	</table>
	<div class="p-4">
		<form method="POST" action="/book/{{$lecturer->id}}">
			@csrf
			<div class="mb-4">
				<label for="date" class="sr-only">Date</label>
				<input type="date" name="date" id="date" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{old('date')}}">
				@error('date')
					<div class="text-red-500 mt-2 text-sm">
						{{$message}}
					</div>
				@enderror
			</div>
			<div class="mb-4">
				<label for="start_time" class="sr-only">Start Time</label>
				<input type="time" name="start_time" id="start_time" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{old('start_time')}}">
				@error('start_time')
					<div class="text-red-500 mt-2 text-sm">
						{{$message}}
					</div>
				@enderror
			</div>
			<div class="mb-4">
				<label for="end_time" class="sr-only">end_time</label>
				<input type="time" name="end_time" id="end_time" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{old('end_time')}}">
				@error('end_time')
					<div class="text-red-500 mt-2 text-sm">
						{{$message}}
					</div>
				@enderror
			</div>
			<button type="submit" class="bg-blue-500 text-white p-2">Book</button>
		</form>
	</div>
</x-layout>