<x-layout>
	<h1 class="text-2xl font-bold mb-4">Upcoming Free Courses</h1>
	<table class="table-auto w-full">
		<thead>
			<tr>
				<th class="border">Course Name</th>
				<th class="border">Course Description</th>
				<th class="border">Course Duration</th>
				<th class="border">Course Start Date</th>
				<th class="border">Course End Date</th>
				<th class="border">Course Photo</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($upcomings as $upcoming)
				<tr>
					<td class="border">{{$upcoming->lecturer_id}}</td>
					<td class="border">{{$upcoming->date}}</td>
					<td class="border">{{$upcoming->start_time}}</td>
					<td class="border">{{$upcoming->end_time}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</x-layout>