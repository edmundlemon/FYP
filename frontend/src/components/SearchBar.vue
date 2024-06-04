<template>
  <!-- <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100"> -->
  <div class="w-full flex flex-col">
    <div class="flex flex-row items-center p-2">
      <div class="flex items-center justify-center w-full">
        <input
          v-model="query"
          @keyup.enter="search"
          placeholder="Search for students or lecturers..."
          class="transition-all duration-500 w-full px-4 py-2 h-9 border border-gray-300 rounded-l-lg flex-4"
        />
      </div>
      <button
        class="transition-all duration-500 w-fit p-1 py-2 px-2.5 font-semibold text-white bg-gray-300 rounded-r-lg hover:bg-white hover:opecity-50 focus:outline-none focus:ring-2 focus:ring-white opacity-80 hover:cursor-pointer"
        @click="search"
      >
        <img
          src="../assets/search.png"
          alt="search"
          class="h-5"
          title="Search"
        />
      </button>
    </div>

    <!-- Search results -->
    <div
      v-if="results"
      class="p-3 pt-2 absolute z-10 mt-16 w-1/4 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      ref="resultsContainer"
    >
      <!-- container that shows the search results or no query results -->
      <div>
        <div class="w-full" v-if="results.students.length">
          <h3 class="mb-2 text-l font-bold">Students</h3>
          <ul class="mb-4 space-y-2">
            <li
              v-for="student in results.students"
              :key="student.id"
              class="p-2 bg-gray-200 rounded"
            >
              {{ student.name }} ({{ student.email }})
            </li>
          </ul>
        </div>

        <div v-if="results.lecturers.length">
          <h3 class="mb-2 text-l font-semibold">Lecturers</h3>
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

        <div
          v-if="results.lecturers.length == 0 && results.students.length == 0"
        >
          No results for this query...
        </div>
      </div>
      <div class="absolute top-3 right-3">
        <img
          class="h-4 w-4 hover:cursor-pointer transition-all duration-500 ease-in-out hover:opacity-50"
          src="../assets/close.png"
          alt="close"
          @click="results = null"
          title="Close Result"
        />
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
const noresults = ref(null);

const search = () => {
  if (query.value.trim() === "") {
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
