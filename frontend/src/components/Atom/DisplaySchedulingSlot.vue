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
      <div class="flex flex-col items-center justify-center">
        <!-- Edit Free Slot Button -->
        <PillButton
          @click.prevent="$emit('openRescheduleForm', slot)"
          class="mt-3 w-[8vw]"
          text="Reschedule"
          v-if="
            store.state.role === 'lecturer' || store.state.role === 'student'
          "
          type="1"
        />
        <PillButton
          @click.prevent="markCompleted(slot.id)"
          class="mt-3 w-[8vw]"
          text="Completed"
          type="2"
          v-if="
            store.state.role === 'lecturer' || store.state.role === 'student'
          "
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import PillButton from "../Atom/Pill-button.vue";
import { ref } from "vue";
import RescheduleForm from "../Molecules/RescheduleForm.vue";

const role = store.state.role;

function reloadPage() {
  window.location.reload();
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

function markCompleted(slotId) {
  if (confirm("Are you sure you want to mark this slot as completed?")) {
    if (role === "lecturer") {
      axiosInstance
        .put(`/lecturer/complete/${slotId}`)
        .then((response) => {
          console.log(response);
          reloadPage();
        })
        .catch((error) => {
          console.log(error);
        });
    } else {
      axiosInstance
        .put(`/student/complete/${slotId}`)
        .then((response) => {
          console.log(response);
          reloadPage();
        })
        .catch((error) => {
          console.log(error);
        });
    }
  }
}
</script>

<style></style>
