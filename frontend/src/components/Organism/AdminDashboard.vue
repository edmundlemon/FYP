<template>
  <div class="w-full h-full flex justify-center bg-gray-100">
    <div class="mt-5 w-9/12 shadow-xl bg-white rounded-xl mb-5">
      <div class="bg-white shadow px-6 py-4 w-full pt-10 pb-10 mt-5 ">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900">
          Welcome Aboard, Admin
        </h1>
      </div>

      <!-- This is the Counter of each box -->
      <div class="bg-white flex justify-around py-2">
        <!-- Students Chart -->
        <div class="w-full md:w-1/3 px-2">
          <div class="rounded-lg shadow-sm mb-4 mx-6">
            <div
              class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden"
            >
              <div class="px-3 pt-8 pb-10 text-center relative z-10">
                <h4 class="text-sm uppercase text-gray-500 leading-tight">
                  Students
                </h4>
                <h3
                  class="text-3xl text-gray-700 font-semibold leading-tight my-3"
                >
                  {{ students.length }}
                </h3>
              </div>
              <div class="absolute bottom-0 inset-x-0">
              </div>
            </div>
          </div>
        </div>
        <!-- Lecturers Chart -->
        <div class="w-full md:w-1/3 px-2">
          <div class="rounded-lg shadow-sm mb-4 mx-6">
            <div
              class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden"
            >
              <div class="px-3 pt-8 pb-10 text-center relative z-10">
                <h4 class="text-sm uppercase text-gray-500 leading-tight">
                  Lecturers
                </h4>
                <h3
                  class="text-3xl text-gray-700 font-semibold leading-tight my-3"
                >
                  {{ lecturers.length }}
                </h3>
              </div>
              <div class="absolute bottom-0 inset-x-0">
              </div>
            </div>
          </div>
        </div>
        <!-- Lecturer Reviews Chart -->
        <div class="w-full md:w-1/3 px-2">
          <div class="rounded-lg shadow-sm mb-4 mx-6">
            <div
              class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden"
            >
              <div class="px-3 pt-8 pb-10 text-center relative z-10">
                <h4 class="text-sm uppercase text-gray-500 leading-tight">
                  Lecturer Reviews
                </h4>
                <h3
                  class="text-3xl text-gray-700 font-semibold leading-tight my-3"
                >
                  {{ R_count }}
                </h3>
              </div>
              <div class="absolute bottom-0 inset-x-0">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- This is lecturer list -->
      <div class="w-10/12 bg-white shadow-lg rounded-t-lg p-6 w-full">
        <h1 class="text-3xl font-bold mb-2">Lecturer List</h1>
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border-2">
            <thead>
              <tr>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Lecturer ID
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Name
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Email
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Faculty
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Office
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Schedule
                </th>
              </tr>
            </thead>
            <!-- {{lecturers}} -->
            <tbody>
              <tr v-for="lecturer in lecturers" class="border-t">
                <td class="py-2 px-4">{{ lecturer.id }}</td>
                <td class="py-2 px-4">{{ lecturer.name }}</td>
                <td class="py-2 px-4">{{ lecturer.email }}</td>
                <td class="py-2 px-4">{{ lecturer.faculty }}</td>
                <td class="py-2 px-4">{{ lecturer.office }}</td>
                <td class="py-2 px-4 flex flex-row space-x-2">
                  <button
                    class="bg-transparent hover:bg-purple-500 text-purple-700 font-semibold hover:text-white rounded-full py-2 px-4 border border-purple-500 hover:border-transparent rounded"
                    @click="$router.push('/Lecturer/' + lecturer.id)"
                  >
                    Check
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- This is student list -->
      <div class="w-10/12 bg-white shadow-lg rounded-b-lg p-6 w-full">
        <h1 class="text-3xl font-bold mb-2">Student List</h1>
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white border-2 mb-5">
            <thead>
              <tr>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Student ID
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Name
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Email
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Faculty
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Programme
                </th>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Schedule
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="student in students"
                :key="student.id"
                class="border-t"
              >
                <td class="py-2 px-4">{{ student.id }}</td>
                <td class="py-2 px-4">{{ student.name }}</td>
                <td class="py-2 px-4">{{ student.email }}</td>
                <td class="py-2 px-4">{{ student.faculty }}</td>
                <td class="py-2 px-4">{{ student.program }}</td>
                <td class="py-2 px-4 flex flex-row space-x-2">
                  <button
                    class="bg-transparent hover:bg-purple-500 text-purple-700 font-semibold hover:text-white rounded-full py-2 px-4 border border-purple-500 hover:border-transparent rounded"
                    @click="$router.push('/Student/' + student.id)"
                  >
                    Check
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import store from "../../store";

const lecturers = ref([]);
const R_count = ref(0); //review count

onMounted(() => {
  getLecturers();
});

function getLecturers() {
  axiosInstance
    .get("/lecturers")
    .then((response) => {
      lecturers.value = response.data.lecturer;
      console.log(response.data.lecturer);
    })
    .catch((error) => {
      console.error(error);
    });
}

const students = ref([]);

onMounted(() => {
  getStudents();

  getReviewCount();
});

function getStudents() {
  axiosInstance
    .get("/students")
    .then((response) => {
      students.value = response.data.students;
      console.log(response.data);
    })
    .catch((error) => {
      console.error(error);
    });
}

function getReviewCount() {
  axiosInstance
    .get("/reviewcount")
    .then((response) => {
      R_count.value = response.data.count;
      console.log(response.data);
    })
    .catch((error) => {
      console.error(error);
    });
}
</script>

<style scoped>
/* Add any component-specific styles here if needed */
table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  padding: 0.75rem;
  text-align: left;
}

th {
  background-color: #f3f4f6;
}

tbody tr:nth-child(odd) {
  background-color: #f9fafb;
}
</style>
