<template>
  <div class="flex flex-col items-center justify-center w-9/12 m-auto">
    <div class="mt-5 mb-5">
      <h1 class="text-6xl font-bold">Lecturers</h1>
    </div>

    <!-- Faculty sorting option -->
    <div class="w-full flex justify-end items-center">
      <p class="mr-2 font-semibold">Filter by Faculty:</p>
      {{ SelectedFaculty }}

      <div class="ml-2 w-fit dropdown relative">
        <button
          class="dropbtn bg-gray-600 p-1 h-8 w-8 text-white rounded-md flex flex-row justify-center items-center"
          @click="filter()"
        >
          <img
            id="filter-icon"
            class="icons fade-in-animation arrow-down h-5 w-5"
            src="../../assets/filter.png"
            alt="arrow-down"
            v-if="!dropdown"
          />
          <img
            id="closefilter-icon"
            class="icons close-filter h-4 w-4 transition-all duration-500 turn90degs"
            src="../../assets/close.png"
            alt="close-filter-menu"
            v-else
          />
        </button>

        <ul
          class="space-y-3 dropdown-content mt-1 absolute z-50 bg-white text-gray-700 py-2 rounded-md shadow-md border border-gray-300 fade-down-animation"
          style="left: 0; width: 5vw; transition: all 0.5s ease-in-out"
          v-if="dropdown"
        >
          <li
            class="text-center cursor-pointer hover:bg-gray-200 p-2 mx-2 rounded-lg"
            @click="filterLecturers('All'), console.log('Selected = All')"
          >
            All
          </li>
          <li
            class="text-center cursor-pointer hover:bg-gray-200 p-2 mx-2 rounded-lg"
            v-for="distFaculty in distinctfaculty.lecturer"
            @click="
              filterLecturers(distFaculty.faculty),
                console.log('Selected = ' + distFaculty.faculty)
            "
          >
            {{ distFaculty.faculty }}
          </li>
        </ul>
      </div>
    </div>

    <div
      class="p-10 grid grid-cols-4 gap-8 p-10 w-full my-5 bg-white shadow-xl rounded-lg relative"
      style="z-index: 0"
    >
      <div
        v-if="filteredLecturers.length === 0"
        class="loader absolute left-[50%] top-[50%]"
        style="transform: translate(-50%, -50%)"
      ></div>
      <LecturerDisplay
        v-for="lecturer in filteredLecturers"
        :key="lecturer.id"
        :user="lecturer"
        role="lecturer"
        class="load-in-animation"
        v-else-if="filteredLecturers.length"
      />
      <div v-else>
        <div
          class="absolute left-[50%] top-[50%] text-2xl font-bold"
          style="transform: translate(-50%, -50%)"
        >
          No lecturers found.
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import store from "../../store";
import LecturerDisplay from "../Molecules/UserDisplayCard.vue";
import dist from "vuex-persistedstate";

const lecturers = ref([]);
const distinctfaculty = ref([]);
let filteredLecturers = ref([]);
let dropdown = ref(false);
let SelectedFaculty = ref("All");

const token = store.state.token;

// Set the default Authorization header for all Axios requests
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

async function filterLecturers(faculty) {
  if (faculty === "All") {
    filteredLecturers.value = lecturers.value;
    SelectedFaculty.value = "All";
    dropdown.value = !dropdown.value;
  } else {
    filteredLecturers.value = lecturers.value.filter(
      (lecturer) => lecturer.faculty === faculty
    );
    SelectedFaculty.value = faculty;
    dropdown.value = !dropdown.value;
  }
}

async function getLecturers() {
  const response = await axios
    .get("http://localhost:8000/api/lecturers")
    .then((response) => {
      lecturers.value = response.data.lecturer;
      filteredLecturers.value = lecturers.value; // set default value
      console.log(lecturers.value);
    })
    .catch((error) => {
      console.log(error);
    });
}

async function getFaculty() {
  const response = await axios
    .get("http://localhost:8000/api/lecturersfaculty")
    .then((response) => {
      distinctfaculty.value = response.data;
      console.log(distinctfaculty.value);
    })
    .catch((error) => {
      console.log(error);
    });
}

onMounted(() => {
  getLecturers();
  getFaculty();
});

async function filter() {
  let hold = dropdown.value;
  dropdown.value = !dropdown.value;

  const closeFilterIcon = document.getElementById("closefilter-icon");
  if (closeFilterIcon) {
    if (hold) {
      closeFilterIcon.style.transform = "rotate(-90deg)";
    } else {
      closeFilterIcon.style.transform = "rotate(90deg)";
    }
  }
}
</script>

<style scoped></style>
