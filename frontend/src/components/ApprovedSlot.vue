<template>
	<div class="bg-gray-100 min-h-screen">
		<div class="container mx-auto p-4">
			<div class="overflow-auto h-[calc(100vh-2rem)]">
				<h3 class="text-xl font-semibold">Approved</h3>
				<!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> -->
				<TimeDisplay v-for="slot in slots" :key="slot.id" :slot="slot" />
				<!-- </div> -->
			</div>
		</div>
	</div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
// import axiosInstance from '../axiosConfig/customAxios'
import TimeDisplay from './TimeDisplay.vue'
import store from '../store'
import axiosInstance from '../axiosConfig/customAxios'

const slots = ref([]);

onMounted(async () => {
  if (store.state.role === 'student') {
	axiosInstance.get('/student/approved').then(response => {
	  slots.value = response.data.consultation_slots;
	}).catch(error => {
	  console.log(error);
	});
  } else {
	axiosInstance.get('/lecturer/schedule').then(response => {
	  slots.value = response.data.consultation_slots;
	}).catch(error => {
	  console.log(error);
	});
  }
});
</script>

<style>

</style>