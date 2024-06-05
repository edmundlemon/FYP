<template>
  <div class="flex flex-col">
    <h3 class="text-xl font-semibold  ml-5 pt-5">Pending</h3>
    <div class="h-fit">
      <div class="container mx-auto px-4">
        <div class="overflow-y-auto" style="height: 58vh">
          <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> -->
          <TimeDisplay
            class="mr-3"
            v-for="slot in slots"
            :key="slot.id"
            :slot="slot"
          />
          <!-- </div> -->
        </div>
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
	 axiosInstance.get('/student/pending').then(response => {
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