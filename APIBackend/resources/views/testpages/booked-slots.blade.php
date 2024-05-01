<x-layout>
	@foreach ($consultationSlots as $consultationSlot)
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">{{ $consultationSlot->date }}</h5>
				<h5 class="card-title">{{ $consultationSlot->start_time }}</h5>
				<p class="card-text">{{ $consultationSlot->end_time }}</p>
				<p class="card-text">{{ $consultationSlot->student_email }}</p>
				<p class="card-text">{{ $consultationSlot->lecturer_email }}</p>
			</div>
		</div>
	@endforeach
</x-layout>