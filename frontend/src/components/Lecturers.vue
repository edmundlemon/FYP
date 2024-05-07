<template>
  	<div class="flex flex-col items-center justify-center h-screen">
		<h1 class="text-4xl font-bold">Lecturer</h1>
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>ID</th>
				</tr>
			</thead>
			<tbody v-for="lecturer in lecturers" :key="lecturer.id">
				<tr>
					<td>{{lecturer.name}}</td>
					<td>{{lecturer.email}}</td>
					<td>{{lecturer.id}}</td>
					<td><img v-if="lecturer.photo" :src="lecturer.photo" alt=""></td>
				</tr>
			</tbody>
		</table>
	</div>	
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import store from '../store';

const lecturers = ref([]);
const token = store.state.token;

// Set the default Authorization header for all Axios requests
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

async function getLecturers(){
	console.log('User authenticated: ', store.state.isAuthenticated);
	console.log('User profile: ', store.state.user.data);
	console.log ('Getting lecturers: ', token);
	const response = await axios.get('http://localhost:8000/api/lecturers').then(response => {
		lecturers.value = response.data.lecturer;
		console.log(lecturers.value);
	}).catch(error => {
		console.log(error);
	});
}

onMounted(() => {
		getLecturers();
})

</script>

<style>

</style>