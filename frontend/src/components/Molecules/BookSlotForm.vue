<template>
  <div class="flex flex-col items-center bg-gray-900" style="width: 30vw">
    <form @submit.prevent="BookSlot" class="p-6 w-full load-in-animation">
      <div class="space-y-5">
        <div class="mb-4">
          <label for="date" class="font-bold block text-white mb-2">Date</label>
          <input
            type="date"
            id="date"
            class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
            v-model="slot.date"
            required
            disabled
          />
          <div v-if="errors.date" class="text-red-500 text-xs mt-1">
            {{ errors.date[0] }}
          </div>
        </div>
      </div>

      <!-- START AND END TIME -->
      <div class="flex flex-row space-x-3 w-full">
        <div class="mb-4 w-1/2">
          <label for="start_time" class="font-bold block text-white mb-2"
            >Start Time</label
          >
          <input
            type="time"
            id="start_time"
            class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
            v-model="slot.start_time"
            min="09:00"
            max="16:00"
            required
            disabled
          />
          <div v-if="errors.start_time" class="text-red-500 text-xs mt-1">
            {{ errors.start_time[0] }}
          </div>
        </div>
        <div class="mb-4 w-1/2">
          <label for="end_time" class="font-bold block text-white mb-2"
            >End Time</label
          >
          <input
            type="time"
            id="end_time"
            class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
            v-model="slot.end_time"
            min="09:00"
            max="17:00"
            required
            disabled
          />
          <div v-if="errors.end_time" class="text-red-500 text-xs mt-1">
            {{ errors.end_time[0] }}
          </div>
        </div>
      </div>

      <!-- Topic Container -->
      <div class="mb-4 w-full">
        <label for="topic" class="font-bold block text-white mb-2">Topic</label>
        <textarea
          id="topic"
          v-model="slot.topic"
          rows="7"
          class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
        ></textarea>
      </div>
      <div class="flex flex-row space-x-3">
        <button
          type="button"
          @click="$emit('closeBookingForm')"
          class="glow-effect font-bold transition-all duration-300 bg-white text-darkgray rounded py-2 px-4 hover:bg-gray-500 hover:text-white w-1/2"
        >
          Cancel
        </button>
        <button
          type="submit"
          class="glow-effect font-bold transition-all duration-300 bg-[#FFF] text-darkgray rounded py-2 px-4 hover:bg-gray-900 hover:text-white w-1/2"
          style="font-weight: bold"
        >
          Book
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, defineProps, onMounted } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";

let Booking = ref({});

const props = defineProps({
  slot: {
    type: Object,
    required: true,
  },
  lecturerid: {
    type: String,
    required: true,
  },
});

const errors = ref({});

function BookSlot() {
  Booking = {
    date: props.slot.date,
    start_time: props.slot.start_time,
    end_time: props.slot.end_time,
    lecturer_id: "",
    student_id: "",
    topic: props.slot.topic,
  };

  console.log(Booking);
  axiosInstance
    .post(`/book/${props.lecturerid}`, Booking)
    .then((response) => {
      console.log(response);
      alert("Booking successful!");
      window.location.reload();
    })
    .catch((error) => {
      console.log(error.response.data);
      errors.value = error.response.data.errors;
    });
}
</script>

<style scoped>
.glow-effect:hover {
  box-shadow: 0 0 7px #ffffff;
}
</style>
