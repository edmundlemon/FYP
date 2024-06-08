<template>
  <div class="flex flex-col items-center bg-gray-900 h-fit  w-1/2">
    <form
      @submit.prevent="bookTime"
      class="border border-blue-700 p-6 bg-gray-800 w-1/2 rounded shadow-md flex flex-row items-center justify-center flex-wrap space-x-5"
    >
      <div class="space-y-5 border border-red-700 ">
        <div class="mb-4 ">
          <label for="date" class="block text-white mb-2 ">Date</label>
          <input
            type="date"
            id="date"
            class=" p-2 bg-gray-700 text-white rounded"
            v-model="booking.date"
            required
          />
          <div v-if="errors.date" class="text-red-500 text-xs mt-1">
            {{ errors.date[0] }}
          </div>
        </div>
      </div>

      <!-- START AND END TIME -->
      <div class="flex flex-row space-x-3  border border-white">
        <div class="mb-4 w-1/2">
          <label for="start_time" class="block text-white mb-2"
            >Start Time</label
          >
          <input
            type="time"
            id="start_time"
            class="  p-2 bg-gray-700 text-white rounded"
            v-model="booking.start_time"
            min="09:00"
            max="16:00"
            required
          />
          <div v-if="errors.start_time" class="text-red-500 text-xs mt-1">
            {{ errors.start_time[0] }}
          </div>
        </div>
        <div class="mb-4 w-1/2">
          <label for="end_time" class=" block text-white mb-2">End Time</label>
          <input
            type="time"
            id="end_time"
            class=" p-2 bg-gray-700 text-white rounded"
            v-model="booking.end_time"
            min="09:00"
            max="17:00"
            required
          />
          <div v-if="errors.end_time" class="text-red-500 text-xs mt-1">
            {{ errors.end_time[0] }}
          </div>
        </div>
      </div>
      <!-- Topic Container -->
      <div class="mb-4 ">
        <label for="topic" class="block text-white mb-2 ">Topic</label>
        <textarea
          id="topic"
          v-model="booking.topic"
          rows="4"
          cols="55"
          class=" p-2 bg-gray-700 text-white rounded "
        ></textarea>
      </div>
      <button
        type="submit"
        class=" bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-600"
      >
        Book
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, defineProps, onMounted } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";

const props = defineProps({
  lecturerId: {
    type: String,
    required: true,
  },
});

const errors = ref({});
const booking = ref({
  date: "",
  start_time: "",
  end_time: "",
  lecturer_id: "",
  student_id: "",
  topic: "",
});

function bookTime() {
  errors.value = {};
  axiosInstance
    .post(`/book/${props.lecturerId}`, booking.value)
    .then((response) => {
      console.log(response.data);
    })
    .catch((error) => {
      errors.value = error.response.data.errors;
      console.error("Failed to book time:", error.response.data.errors);
    });
}
</script>

<style scoped>

</style>
