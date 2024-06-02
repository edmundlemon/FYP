<template>

<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-4">
      <div class="overflow-auto h-[calc(100vh-2rem)]">
        <h3 class="text-xl font-semibold">Upcoming</h3>
        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> -->
		    <TimeDisplay v-for="slot in slots" :key="slot.id" :slot="slot" />
        <!-- </div> -->
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, onBeforeMount } from 'vue'
import TimeDisplay from './TimeDisplay.vue'
import axios from 'axios';
import store from '../store'
import axiosGet from '../axiosConfig/customAxios'
// import store from '../../../APIBackend/resources/js/store';
const slots = ref([]);
const token = store.state.token
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

onMounted(async () => {
	console.log('Token => ', token);
  console.log('Role => ', store.state.role);
  if (store.state.role === 'student') {
      axiosGet('/student/schedule').then(response => {
      slots.value = response.data.consultation_slots;
    }).catch(error => {
      console.log(error);
    });
  } else {
      axiosGet('/lecturer/schedule').then(response => {
      slots.value = response.data.consultation_slots;
    }).catch(error => {
      console.log(error);
    });
  }
  


  // if (store.state.role === 'student') {
  //   const response = await axios.get('http://localhost:8000/api/student/schedule');
  //   slots.value = response.data.consultation_slots;
  // } else {
  //   const response = await axios.get('http://localhost:8000/api/lecturer/schedule');
  //   slots.value = response.data.consultation_slots;
  // }
	
	// console.log(data);
  // const response = await axios.get('http://localhost:8000/api/student/schedule');
	// const data = await response.data.consultation_slots;
	// slots.value = data;
});
</script>

<style>

</style>