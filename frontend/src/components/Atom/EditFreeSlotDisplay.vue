<template>
  <div :id="slot.id" class="flex justify-center items-center relative">
    <div class="flex flex-col bg-white shadow-md rounded-md p-4 w-full border">
      <button
        @click="deleteSlot(slot.id)"
        type="button"
        class="absolute top-2 right-2 w-4 h-4"
      >
        <img src="../../assets/delete.png" alt="delete" />
      </button>
      <h3 class="text-lg font-bold mb-2 text-gray-800 text-center">
        Date: {{ slot.date }}
      </h3>
      <div class="flex flex-col space-y-2 justify-center items-center">
        <div class="flex flex-row items-center">
          <svg
            width="16"
            height="16"
            viewBox="0 0 16 16"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            class="w-4 h-4 text-green-500 flex"
          >
            <circle cx="8" cy="8" r="6" />
            <line x1="8" y1="8" x2="12" y2="8" />
          </svg>
          <span class="ml-0.5 font-bold text-green-500">{{
            slot.start_time
          }}</span>
        </div>
        <div class="flex flex-row items-center">
          <svg
            width="16"
            height="16"
            viewBox="0 0 16 16"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            class="w-4 h-4 text-red-500 flex"
          >
            <circle cx="8" cy="8" r="6" />
            <line x1="8" y1="8" x2="12" y2="8" />
          </svg>
          <span class="ml-0.5 font-bold text-red-500">{{ slot.end_time }}</span>
        </div>
      </div>
      <div class="flex justify-center space-x-5">
        <!-- Edit Free Slot Button -->
        <PillButton
          @click.prevent="$emit('edit-slot', slot)"
          class="mt-3 w-[8vw]"
          text="Edit Slot"
          v-if="store.state.role === 'lecturer'"
          type="1"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted, defineEmits } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import PillButton from "../Atom/Pill-button.vue";
import { ref } from "vue";

const role = store.state.role;
const emit = defineEmits(["getslots"]);

async function deleteSlot(slot) {
  if (confirm("Are you sure you want to delete this slot?")) {
    axiosInstance
      .delete(`/free-slots/delete/${slot}`)
      .then((response) => {
        console.log(response.data);
        emit("getslots")
      })
      .catch((error) => {
        console.error("Failed to delete slot:", error.response.data);
      });
  }
}


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
