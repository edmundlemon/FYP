<template>
	<div class="flex flex-row p-5">
		<form @submit.prevent="bookTime">
			<div class="flex-1 mb-3">
				<div class="flex flex-row">
					<label for="date" class="flex-1 p-2">Date</label>
					<input type="date" class="flex-5 p-2" v-model="booking.date" required>
				</div>
				<div v-if="errors.date" class="text-red-500 text-xs mt-1">{{ errors.date[0] }}</div>
			</div>
			<div class="flex-1 mb-3">
				<div class="flex flex-row">
					<label for="start_time" class="flex-1 p-2">Start time</label>
					<input type="time" v-model="booking.start_time" min="09:00" max="16:00" required>
				</div>
				<div v-if="errors.start_time" class="text-red-500 text-xs mt-1">{{ errors.start_time[0] }}</div>
			</div>
			<div class="flex-1 mb-3">
				<div class="flex flex-row">
					<label for="end_time" class="flex-1 p-2">End time</label>
					<input type="time" v-model="booking.end_time" min="09:00" max="17:00" required>
				</div>
				<div v-if="errors.end_time" class="text-red-500 text-xs mt-1">{{ errors.end_time[0] }}</div>
			</div>
			<button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">Book</button>
		</form>
	</div>
</template>

<script setup>
import { ref, defineProps, onMounted } from 'vue'
import store from '../store'
import axiosInstance from '../axiosConfig/customAxios'

const props = defineProps({
	lecturerId: {
		type: String,
		required: true,
	},
});

const errors = ref({});
const booking = ref({
	date: '',
	start_time: '',
	end_time: '',
	lecturer_id: '',
	student_id: ''
})

function bookTime() {
	errors.value = {};
	axiosInstance.post(`/book/${props.lecturerId}`, booking.value)
		.then(response => {
			console.log(response.data);
		})
		.catch(error => {
			errors.value = error.response.data.errors;
			console.error('Failed to book time:', error.response.data.errors);
		});
}
</script>

<style></style>