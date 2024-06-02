<template>
	<!-- <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100"> -->
	<div class="w-full max-w-md p-4 bg-white rounded-lg shadow-md">
		<div class="flex flex-row">
			<input v-model="query" @keyup.enter="search" placeholder="Search for students or lecturers..."
				class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 flex-4">
			<button @click="search"
				class="w-full px-4 py-2 mx-4 font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 flex-1">
				Search
			</button>
		</div>

		<div v-if="results" class="mt-6">
			<div v-if="results.students.length">
				<h3 class="mb-2 text-xl font-semibold">Students</h3>
				<ul class="mb-4 space-y-2">
					<li v-for="student in results.students" :key="student.id" class="p-2 bg-gray-200 rounded">{{
						student.name }} ({{ student.email }})</li>
				</ul>
			</div>

			<div v-if="results.lecturers.length">
				<h3 class="mb-2 text-xl font-semibold">Lecturers</h3>
				<ul class="mb-4 space-y-2">
					<li v-for="lecturer in results.lecturers" :key="lecturer.id" class="p-2 bg-gray-200 rounded"><a
							href="/lecturer/{{ lecturer.id }}" class="block">{{ lecturer.name }}</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- </div> -->
</template>

<script setup>
import { ref } from 'vue';
import axios from '../axiosConfig/customAxios';

const query = ref('');
const results = ref(null);

const search = () => {
	if (query.value === '') {
		results.value = null;
		return;
	}
	axios.get('/search', { params: { search: query.value } })
		.then(response => {
			results.value = response.data;
		})
		.catch(error => {
			console.error('Search error:', error);
		});
};
</script>