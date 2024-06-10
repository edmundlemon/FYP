<template>
  <div class="flex p-2">
    <div class="bg-gray-100 p-4 shadow rounded w-full mt-5 drop-shadow-xl">
      <h3 class="text-lg font-bold mb-2">Date: {{ slot.date }}</h3>
      <div class="flex flex-row space-x-5">
        <div class="flex flex-row justify-center items-center">
			<svg
            class="w-4 h-4 text-green-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 5h10M11 9h6M11 13h4M11 17h2"
            />
          </svg>
          <span class="ml-1 font-bold text-green-400">
            {{ slot.start_time }}
          </span>
        </div>
        <div class="flex flex-row justify-center items-center">
          <svg
            class="w-4 h-4 text-red-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 5h10M11 9h6M11 13h4M11 17h2"
            />
          </svg>
          <span class="ml-1 font-bold text-red-400">{{ slot.end_time }}</span>
        </div>
      </div>
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
