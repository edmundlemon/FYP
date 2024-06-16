<template>
	<div class="flex flex-col items-center bg-gray-900" style="width: 30vw">
		<form @submit.prevent="bookTime" class="p-6 w-full load-in-animation">
			<div class="space-y-5">
				<div class="mb-4">
					<label for="date" class="font-bold block text-white mb-2">Date</label>
					<input type="date" id="date"
						class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
						v-model="booking.date" required />
					<div v-if="errors.date" class="text-red-500 text-xs mt-1">
						{{ errors.date[0] }}
					</div>
				</div>
			</div>

			<!-- START AND END TIME -->
			<div class="flex flex-row space-x-3 w-full">
				<div class="mb-4 w-1/2">
					<label for="start_time" class="font-bold block text-white mb-2">Start Time</label>
					<input type="time" id="start_time"
						class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
						v-model="booking.start_time" min="09:00" max="16:00" required />
					<div v-if="errors.start_time" class="text-red-500 text-xs mt-1">
						{{ errors.start_time[0] }}
					</div>
				</div>
				<div class="mb-4 w-1/2">
					<label for="end_time" class="font-bold block text-white mb-2">End Time</label>
					<input type="time" id="end_time"
						class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
						v-model="booking.end_time" min="09:00" max="17:00" required />
					<div v-if="errors.end_time" class="text-red-500 text-xs mt-1">
						{{ errors.end_time[0] }}
					</div>
				</div>
			</div>

			<!-- Topic Container -->
			<div class="mb-4 w-full" v-if="store.state.role === 'student'">
				<label for="topic" class="font-bold block text-white mb-2">Topic</label>
				<textarea id="topic" v-model="booking.topic" rows="7"
					class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"></textarea>
			</div>
			<div class="flex flex-row space-x-3">
				<button type="button" @click="$emit('closeRescheduleForm')"
					class="glow-effect font-bold transition-all duration-300 bg-white text-darkgray rounded py-2 px-4 hover:bg-gray-500 hover:text-white w-1/2">
					Cancel
				</button>
				<button type="submit"
					class="glow-effect font-bold transition-all duration-300 bg-[#FFF] text-darkgray rounded py-2 px-4 hover:bg-gray-900 hover:text-white w-1/2"
					style="font-weight: bold">
					Reschedule
				</button>
			</div>
		</form>
	</div>
</template>

<script setup>
import { ref, defineProps, onMounted, watch } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";

const props = defineProps({
	slot: {
		type: Object,
		required: true,
	},
	// showBookingform: {
	// 	type: Boolean,
	// 	required: true,
	// },
});

let uri = '';
const emit = defineEmits(['reschedule-success']);
const errors = ref({});
const booking = ref({
	...props.slot.slot,
});
console.log(props.slot.slot.date);
watch(() => props.slot, (newData) => {
	booking.value = { ...newData };
}, { deep: true });

function bookTime() {
	console.log(booking.value);
	errors.value = {};
	if (store.state.role === "student") {
		uri = `/student/reschedule/${booking.value.id}`;
		console.log(uri);
	} else {
		uri = `/lecturer/reschedule/${booking.value.id}`;
		console.log(uri);
	}
	axiosInstance
		.put(uri, booking.value)
		.then((response) => {
			console.log(response);
			alert("Reschedule Successful");
			window.location.reload();
		})
		.catch((error) => {
			console.log(error.response.data.errors);
			errors.value = error.response.data.errors;
		});
}
</script>

<style scoped>
.glow-effect:hover {
	box-shadow: 0 0 7px #ffffff;
}
</style>