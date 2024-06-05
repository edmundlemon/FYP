<template>
	<div class="flex flex-col items-center justify-center border border-gray-400 p-4" v-if="student">
		<img :src="student.photo" alt="Descriptive Alt Text" class="max-h-40 object-contain">
		<div class="flex flex-col items-center justify-center">
			<h1 class="text-4xl font-bold my-1.5">{{ student.name }}</h1>
			<p class="text-lg my-1.5">{{ student.email }}</p>
			<p class="text-lg my-1.5">{{ student.id }}</p>
		</div>
	</div>
</template>

<script setup>
import { defineProps, onMounted, ref } from 'vue';
import axiosInstance from '../axiosConfig/customAxios';
import { useRoute } from 'vue-router';

const route = useRoute();
const student = ref(null);

onMounted(async () => {
	const studentId = route.params.id;
	// console.log(route.path);
	console.log(studentId);
	try {
		const response = await axiosInstance.get(`/view/student/${studentId}`);
		student.value = response.data.student;
	} catch (error) {
		console.error('Failed to fetch student details:', error);
	}
});


</script>

<style></style>