<template>
	<div class="flex flex-col items-center justify-center border border-gray-400 p-4" v-if="lecturer">
		<img :src="lecturer.photo" alt="Descriptive Alt Text" class="max-h-40 object-contain">
		<div class="flex flex-col items-center justify-center">
			<h1 class="text-4xl font-bold my-1.5">{{ lecturer.name }}</h1>
			<p class="text-lg my-1.5">{{ lecturer.email }}</p>
			<p class="text-lg my-1.5">{{ lecturer.id }}</p>
		</div>
	</div>
</template>

<script setup>
import { defineProps, onMounted, ref } from 'vue';
import axiosInstance from '../axiosConfig/customAxios';
import { useRoute } from 'vue-router';

const route = useRoute();
const lecturer = ref(null);

onMounted(async () => {
	const lecturerId = route.params.id;
	// console.log(route.path);
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