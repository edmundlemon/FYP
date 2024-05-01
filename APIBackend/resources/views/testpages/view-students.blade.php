<x-layout>
	<h1 class="text-2xl font-bold mb-4">View Students</h1>
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
			@foreach ($students as $student)
				<tr>
					<td class="border">{{$student->name}}</td>
					<td class="border">{{$student->email}}</td>
					<td class="border">{{$student->faculty}}</td>
					<td class="border">{{$student->program}}</td>
					<td class="border">
						<img src="{{asset('storage/'.$student->photo)}}" alt="" class="w-24">
					</td>
				</tr>
			@endforeach
		</tbody>
</x-layout>