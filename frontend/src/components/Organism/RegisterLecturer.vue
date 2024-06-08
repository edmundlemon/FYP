<template>
	<div>
		<h1>Register Lecturer</h1>
		<form @submit.prevent="saveLecturer" enctype="multipart/form-data">
		<div class="mb-3">
			<label for="id" class="form-label">Lecturer ID</label>
			<input type="text" class="form-control border border-gray-400 p-2" id="id" name="id"  v-model="lecturer.id" required>
			<div v-if="errors.id" class="text-red-500 text-xs mt-1">{{ errors.id[0] }}</div>
		</div>
		<div class="mb-3">
			<label for="name" class="form-label">Lecturer's Name</label>
			<input type="text" class="form-control border border-gray-400 p-2" id="name" name="name" v-model="lecturer.name"  required>
			<div v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</div>
		</div>
		<div class="mb-3">
			<label for="email" class="form-label">Lecturer Email</label>
			<input type="email" class="form-control border border-gray-400 p-2" id="email" name="email" v-model="lecturer.email"  required>
			<div v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</div>
		</div>
		<div class="mb-3">
			<label for="password" class="form-label">Password</label>
			<input type="password" class="form-control border border-gray-400 p-2" id="password" name="password" v-model="lecturer.password"  required>
			<div v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</div>
		</div>
		<div class="mb-3">
			<label for="password_confirmation" class="form-label">Confirm Password</label>
			<input type="password" class="form-control border border-gray-400 p-2" id="password_confirmation" name="password_confirmation" v-model="lecturer.password_confirmation" required>
			<div v-if="errors.password_confirmation" class="text-red-500 text-xs mt-1">{{ errors.password_confirmation[0] }}</div>
		</div>
		<div class="mb-3">
			<label for="faculty" class="form-label">Faculty</label>
			<input type="text" class="form-control border border-gray-400 p-2" id="faculty" name="faculty" v-model="lecturer.faculty" required>
			<div v-if="errors.faculty" class="text-red-500 text-xs mt-1">{{ errors.faculty[0] }}</div>
		</div>
		<div class="mb-3">
			<label for="office" class="form-label">Office</label>
			<input type="text" class="form-control border border-gray-400 p-2" id="office" name="office" v-model="lecturer.office" required>
			<div v-if="errors.office" class="text-red-500 text-xs mt-1">{{ errors.office[0] }}</div>
		</div>
		<div class="mb-3">
			<label for="photo" class="form-label">Lecturer's Photo</label>
			<input type="file" class="form-control border border-gray-400 p-2" id="photo" name="photo" ref="photo">
			<div v-if="errors.photo" class="text-red-500 text-xs mt-1">{{ errors.photo[0] }}</div>
		</div>
		<button type="submit" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">Register</button>
		</form>
	</div>
</template>

<script>
import axiosInstance from '../../axiosConfig/customAxios';

export default {
	name: 'RegisterLecturer',
	data(){
		return{
			lecturer: {},
			name: '',
			email: '',
			id: '',
			password: '',
			password_confirmation: '',
			faculty: '',
			office: '',
			photo: null,
			errors: {}
		}
	},
	methods:{
		async saveLecturer(){
			this.errors = {};
			// * Create a form data object
			if (this.errors.length !=0){
				let formData = new FormData();
				formData.append('name', this.lecturer.name);
				formData.append('email', this.lecturer.email);
				formData.append('id', this.lecturer.id);
				formData.append('password', this.lecturer.password);
				formData.append('password_confirmation', this.lecturer.password_confirmation);
				formData.append('faculty', this.lecturer.faculty);
				formData.append('office', this.lecturer.office);
				formData.append('photo', this.$refs.photo.files[0]);
				// console.log(formData.getAll());
				let url = 'register/lecturer';
				await axiosInstance.post(url, formData, {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}).then(response => {
					if(response.status == 201)
						console.log('Response:', response.data.message);
					console.log('Response:', response.data);
				}).catch(error => {
					console.log('Error: ', error.response.data);
					this.errors = error.response.data.errors;
				});
			}
		}
	}
}
</script>

<style>

</style>