<template>
	<div class="flex flex-row p-5">
		<form @submit.prevent="addSlot">
			<div class="flex flex-row">
				<label for="date">Date: </label>
				<input v-model="booking.date" type="date" placeholder="Date" required>
				<div v-if="errors.date" class="text-red-500 text-xs mt-1">{{ errors.date[0] }}</div>
			</div>
			<div class="flex flex-row">
				<label for="start_time">Start date: </label>
				<input v-model="booking.start_time" type="time" placeholder="Start Time" required>
				<div v-if="errors.start_time" class="text-red-500 text-xs mt-1">{{ errors.start_time[0] }}</div>
			</div>
			<div class="flex flex-row">
				<label for="end_time">End date: </label>
				<input v-model="booking.end_time" type="time" placeholder="End Time" required>
				<div v-if="errors.end_time" class="text-red-500 text-xs mt-1">{{ errors.end_time[0] }}</div>
			</div>
			<button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">Add Slot</button>
		</form>
	</div>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import axiosInstance from '../../axiosConfig/customAxios';

// const props = defineProps({
// 	lecturerId: {
// 		type: String,
// 		required: true,
// 	},
// });
const booking = ref({
	date: '',
	start_time: '',
	end_time: '',
})
const errors = ref({});

function addSlot() {
	console.log(booking);
	// return;
	errors.value = {};
	axiosInstance.post('/free-slots', booking.value)
		.then(response => {
			console.log(response.data);
			alert('Slot added successfully');
			window.location.reload();
		})
		.catch(error => {
			errors.value = error.response.data.errors;
			console.error('Failed to add time:', error.response.data);
		});
}
</script>