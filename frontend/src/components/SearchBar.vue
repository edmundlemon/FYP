<template>
  <!-- <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100"> -->
  <div class="w-full flex flex-col">
    <div class="flex flex-row items-center p-2">
      <div class="flex items-center justify-center">
        <input
          v-model="query"
          @keyup.enter="search"
          placeholder="Search for students or lecturers..."
          class="w-full px-4 py-2 h-9 w-96 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 flex-4"
        />
      </div>
      <button
        class="w-fit p-1 py-2 px-2 font-semibold text-white bg-blue-500 rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
        @click="search"
      >
        <img src="../assets/search.png" alt="search" class="h-5" />
      </button>
    </div>

    <!-- Search results -->
    <div
      v-if="results"
      class="p-3 pt-2 absolute right-50 z-10 mt-16 w-1/4 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    >
      <div v-if="results.students.length">
        <h3 class="mb-2 text-xl font-semibold">Students</h3>
        <ul class="mb-4 space-y-2">
          <li
            v-for="student in results.students"
            :key="student.id"
            class="p-2 y-bg-gra200 rounded"
          >
            {{ student.name }} ({{ student.email }})
          </li>
        </ul>
      </div>

      <div v-if="results.lecturers.length">
        <h3 class="mb-2 text-xl font-semibold">Lecturers</h3>
        <ul class="mb-4 space-y-2">
          <li
            v-for="lecturer in results.lecturers"
            :key="lecturer.id"
            class="p-2 bg-gray-200 rounded"
          >
            <a href="/lecturer/{{ lecturer.id }}" class="block">
              {{ lecturer.name }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- </div> -->
</template>

<script setup>
import { ref } from "vue";
import axios from "../axiosConfig/customAxios";

const query = ref("");
const results = ref(null);

const search = () => {
  if (query.value === "") {
    results.value = null;
    return;
  }
  axios
    .get("/search", { params: { search: query.value } })
    .then((response) => {
      results.value = response.data;
    })
    .catch((error) => {
      console.error("Search error:", error);
    });
};
</script>
