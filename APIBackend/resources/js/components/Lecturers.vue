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

<script>
import axios from 'axios';
import store from '../store';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.state.token;
export default {
	name: 'Lecturers',
	data(){
		return{
			lecturers: [],
			store: store
		}
	},
	created(){
		this.getLecturers();
		console.log(store.state.token);
		// this.toFetchLec();
	},
	methods:{
		// * Fetching data using fetch JavaScript
		// async toFetchLec(){
		// 	fetch('http://127.0.0.1:8000/api/lecturers')
		// 	.then(response => {
		// 		console.log('Response:', response);
		// 		return response.json();
		// 	})
		// 	.then(data => {
		// 		this.lecturers = data.lecturer;
		// 		console.log('Data 1:', data)
		// 	})
		// 	.catch(error => console.log(error))
		// },

		// * Fetching data using axios
		async getLecturers(){
			const response = await axios.get('http://localhost:8000/api/lecturers').then(response => {
				this.lecturers = response.data.lecturer;
				console.log(response.data.lecturer);
			}).catch(error => {
				console.log(error);
			});
		},

		async fetchImg(lecId){
			console.log('http://localhost:8000/api/fetchImage/' + lecId);
			let url = 'http://localhost:8000/api/fetchImage/' + lecId;
			const response = await axios.get(url).then(response => {
				console.log(response);
				// console.log(response.headers['content-type']);
				
				return(response.data);
			}).catch(error => {
				console.log(error);
			});
		}
	},
	mounted(){
		console.log('mounted')
	}
}
</script>

<style>

</style>