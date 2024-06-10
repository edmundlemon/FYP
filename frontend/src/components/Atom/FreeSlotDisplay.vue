<template>
  <div class="flex justify-center items-center">
    <div class="flex flex-col bg-white shadow-md rounded-md p-4 w-full border">
      <h3 class="text-lg font-bold mb-2 text-gray-800">
        Date: {{ slot.date }}
      </h3>
      <div
        class="flex space-x-5 lg:flex-row md:flex-col sm:flex-col justify-center items-center"
      >
        <div class="flex flex-row items-center">
          <svg
            class="w-5 h-5 text-green-500"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 011 18z"
            />
          </svg>
          <span class="ml-2 font-bold text-green-500">{{
            slot.start_time
          }}</span>
        </div>
        <div class="flex flex-row items-center">
          <svg
            class="w-5 h-5 text-red-500"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 011 18z"
            />
          </svg>
          <span class="ml-2 font-bold text-red-500">{{ slot.end_time }}</span>
        </div>
      </div>
      <div class="flex justify-center">
        
		<PillButton @click.prevent="console.log('Booking Slot '+ slot.id + ' Clicked !')" class="mt-3" text="Book Slot" v-if="store.state.role === 'student'"/>
	  </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import PillButton from "../Atom/Pill-button.vue";
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
