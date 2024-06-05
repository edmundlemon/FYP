<template>
	<div class="flex flex-col items-center justify-center border border-gray-400 p-4" v-if="lecturer">
		<img :src="lecturer.photo" alt="Descriptive Alt Text" class="max-h-40 object-contain">
		<div class="flex flex-col items-center justify-center">
			<h1 class="text-4xl font-bold my-1.5">{{ lecturer.name }}</h1>
			<p class="text-lg my-1.5">{{ lecturer.email }}</p>
			<p class="text-lg my-1.5">{{ lecturer.id }}</p>
		</div>
		<booking-form :lecturer-id="lecturerId" />
	</div>
</template>

<script setup>
import { defineProps, onMounted, ref } from 'vue';
import axiosInstance from '../axiosConfig/customAxios';
import { useRoute } from 'vue-router';
import BookingForm from './BookingForm.vue';

const route = useRoute();
const lecturer = ref(null);
const lecturerId = route.params.id;

onMounted(async () => {
	console.log(lecturerId);
	try {
		const response = await axiosInstance.get(`/view/lecturer/${lecturerId}`);
		lecturer.value = response.data.lecturer;
	} catch (error) {
		console.error('Failed to fetch lecturer details:', error);
	}
});


</script>

<style></style>