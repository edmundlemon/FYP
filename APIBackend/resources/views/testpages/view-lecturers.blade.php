<x-layout>
	<h1 class="text-2xl font-bold mb-4">View Lecturers</h1>
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
	@foreach ($lecturers as $lecturer)
			<tbody>
				<tr>
					<td class="border"><a href="/upcoming/{{$lecturer->id}}"></a>{{$lecturer->name}}</td>
					<td class="border">{{$lecturer->email}}</td>
					<td class="border">{{$lecturer->faculty}}</td>
					<td class="border">{{$lecturer->program}}</td>
					<td class="border">
						<img src="{{asset('storage/'.$lecturer->photo)}}" alt="" class="w-24">
					</td>
				</tr>
			</tbody>
	@endforeach
	</table>
</x-layout>