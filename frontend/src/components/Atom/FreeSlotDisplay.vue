<template>
	<div class="flex p-2"
	>
	  <div
		class="bg-gray-100 p-4 shadow rounded w-full mt-5 drop-shadow-xl"
	  >
		<h3>Date: {{ slot.date }}</h3>
		<div class="flex flex-row gap-10 justify-between">
		  <div>Start Time: <span class="ml-1 font-bold text-green-400 ">{{ slot.start_time }}</span></div>
		  <div>End Time: <span class="ml-1 font-bold text-red-400 ">{{ slot.end_time }}</span></div>
		</div>
		<h3 class="flex justify-end mt-7" v-if="role === 'lecturer'">
		  Booked by <a :href="'/student/'+ slot.student.id"><span class="ml-1 font-bold hover:opacity-70 transition-text duration-300">{{ slot.student.name }}</span></a>
		</h3>
	  </div>
	</div>
  </template>
  
  <script setup>
  import { defineProps, onMounted } from "vue";
  import store from "../../store";
  
  const role = store.state.role;
  
  const props = defineProps({
	slot: {
	  type: Object,
	  required: true,
	},
  });
  
  onMounted(() => {
	console.log("Role => ", role);
	console.log("Slot => ", props.slot);
  });
  </script>
  
  <style></style>
  