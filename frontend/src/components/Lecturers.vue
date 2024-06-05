<template>
  <div class="flex flex-col items-center justify-center">
    <div class="mt-5">
      <h1 class="text-6xl font-bold">Lecturers</h1>
    </div>
    <div
      class="p-10 grid grid-cols-4 gap-8 p-10 w-9/12 my-5 bg-white shadow-xl rounded-lg"
      style="z-index: -2;"
    >
      <LecturerDisplay
        v-for="lecturer in lecturers"
        :key="lecturer.id"
        :lecturer="lecturer"
      />
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import store from "../store";
import LecturerDisplay from "./Lecturer-Display.vue";

const lecturers = ref([]);
const token = store.state.token;

// Set the default Authorization header for all Axios requests
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

async function getLecturers() {
  const response = await axios
    .get("http://localhost:8000/api/lecturers")
    .then((response) => {
      lecturers.value = response.data.lecturer;
      console.log(lecturers.value);
    })
    .catch((error) => {
      console.log(error);
    });
}

onMounted(() => {
  getLecturers();
});
</script>

<style></style>
