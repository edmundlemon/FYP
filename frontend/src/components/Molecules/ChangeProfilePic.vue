<template>
	<div class="flex flex-col items-center bg-gray-900 min-h-[30vh] min-w-[30vw] max-h-[70vh] h-full">
		<form @submit.prevent="changePfp" enctype="multipart/form-data" class="flex flex-col h-full">
			<div class="flex-grow">
				<div class="flex flex-col md:flex-row justify-center">
					<div class="flex flex-col mb-4 md:mb-0 md:mr-4">
						<label for="photo" class="font-bold block text-white mb-2">New Profile Picture: </label>
						<input type="file" id="photo" name="photo" accept="image/*" @change="previewImage" />
					</div>
					<div class="flex flex-col overflow-hidden max-h-[40vh]">
						<h3 class="font-bold block text-white mb-2">Image Preview:</h3>
						<img v-if="imageUrl" :src="imageUrl" alt="Image Preview" class="max-w-[200px] p-2 max-h-full h-auto object-contain" />
					</div>
				</div>
			</div>
			<div class="flex mt-auto">
				<button type="submit"
					class="glow-effect font-bold transition-all duration-300 bg-white text-darkgray rounded py-2 px-4 hover:bg-gray-900 hover:text-white w-1/2">Change</button>
				<button
					class="glow-effect font-bold transition-all duration-300 bg-white text-darkgray rounded py-2 px-4 hover:bg-gray-900 hover:text-white w-1/2"
					@click="closeModal">Cancel</button>
			</div>
		</form>
	</div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';
import axios from '../../axiosConfig/customAxios';
import store from '../../store';

const imageUrl = ref(null);
const id = store.state.user.data.id;
const emit = defineEmits(['close']);

console.log(id);
const closeModal = () => {
	emit('close');
};

const previewImage = (event) => {
	const file = event.target.files[0];
	if (file) {
		imageUrl.value = URL.createObjectURL(file);
	}
};

const changePfp = () => {
	const formData = new FormData();
	console.log(document.getElementById('photo').files[0]);
	// return;
	formData.append('photo', document.getElementById('photo').files[0]);
	if (store.state.role === 'student') {
		axios.post(`/student/change-photo/${id}`, formData, {headers: {
			'Content-Type': 'multipart/form-data'}
		})	
			.then((response) => {
				console.log(response);
				store.state.user.data.photo = response.data.photo;
				closeModal();
			})
			.catch((error) => {
				console.log(error);
			});
		return;
	}
	else if (store.state.role === 'lecturer') {
		axios.post(`/lecturer/change-photo/${id}`, formData, {headers: {
			'Content-Type': 'multipart/form-data'}
		})
			.then((response) => {
				console.log(response);
				store.state.user.data.photo = response.data.photo;
				closeModal();
			})
			.catch((error) => {
				console.log(error);
			});
		return;
	}
};

</script>

<style></style>