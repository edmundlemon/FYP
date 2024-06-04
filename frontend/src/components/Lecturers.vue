<template>
  <div class="flex justify-center">
    <div
      class="grid grid-cols-4 gap-4 p-4 w-10/12 mt-5"
      style="border: 1px red solid"
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
