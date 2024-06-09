<template>
  <div class="flex flex-col items-center justify-center w-9/12 m-auto">
    <div class="mt-5 mb-5">
      <h1 class="text-6xl font-bold">Students</h1>
    </div>

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
            @click="filterStudents('All'), console.log('Selected = All')"
          >
            All
          </li>
          <li
            class="text-center cursor-pointer hover:bg-gray-200 p-2 mx-2 rounded-lg"
            v-for="distFaculty in distinctfaculty.student"
            @click="
              filterStudents(distFaculty.faculty),
                console.log('Selected = ' + distFaculty.faculty)
            "
          >
            {{ distFaculty.faculty }}
          </li>
        </ul>
      </div>
    </div>

    <div
      class="p-10 grid grid-cols-4 gap-8 p-10 w-full my-5 bg-white shadow-xl rounded-lg"
      style="z-index: 0"
    >
      <StudentDisplay
        v-for="student in filteredStudents"
        :key="student.id"
        :student="student"
        class="load-in-animation"
      />
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import store from "../../store";
import StudentDisplay from "../Molecules/Student-Display.vue";

const students = ref([]);
const token = store.state.token;

const distinctfaculty = ref([]);
let filteredStudents = ref([]);
let dropdown = ref(false);
let SelectedFaculty = ref("All");

// Set the default Authorization header for all Axios requests
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

async function filterStudents(faculty) {
  if (faculty === "All") {
    filteredStudents.value = students.value;
    SelectedFaculty.value = "All";
    dropdown.value = !dropdown.value;
  } else {
    filteredStudents.value = students.value.filter(
      (lecturer) => lecturer.faculty === faculty
    );
    SelectedFaculty.value = faculty;
    dropdown.value = !dropdown.value;
  }
}

async function getStudents() {
  const response = await axios
    .get("http://localhost:8000/api/students")
    .then((response) => {
      students.value = response.data.students;
      filteredStudents.value = students.value;
      console.log(students.value);
    })
    .catch((error) => {
      console.log(error);
    });
}
async function getFaculty() {
  const response = await axios
    .get("http://localhost:8000/api/studentsfaculty")
    .then((response) => {
      distinctfaculty.value = response.data;
      console.log(response.data);
    })
    .catch((error) => {
      console.log(error);
    });
}
onMounted(() => {
  getStudents();
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

<style></style>
