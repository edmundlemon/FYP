<template>
  <div
    class="min-w-screen min-h-screen bg-gray-100 flex items-center justify-center py-10"
  >
    <div class="w-10/12 bg-white shadow-lg rounded-lg p-6">
      <h1 class="text-3xl font-bold mb-6">Lecturer List</h1>
      <div class="overflow-x-auto">
        <div v-for="lecturer in lecturers" :key="lecturer.id"></div>

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
                Actions
              </th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(lecturer, index) in lecturers"
              class="border-t"
              :key="index"
            >
              <td class="py-2 px-4">{{ lecturer.id }}</td>
              <td class="py-2 px-4">{{ lecturer.name }}</td>
              <td class="py-2 px-4">{{ lecturer.email }}</td>
              <td class="py-2 px-4">{{ lecturer.faculty }}</td>
              <td class="py-2 px-4">{{ lecturer.program }}</td>
              <td class="py-2 px-4 flex flex-row space-x-2">
                <button
                  class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white rounded-full py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                  @click="editLecturer(lecturer.id)"
                >
                  Edit
                </button>
                <button
                  class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white rounded-full py-2 px-4 border border-red-500 hover:border-transparent rounded"
                  @click.prevent="deleteLecturer(lecturer.id)"
                  >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import router from "../../router/routes";

const lecturers = ref([]);

onMounted(() => {
  getLecturers();
});

async function getLecturers() {
  axiosInstance
    .get("/lecturers")
    .then((response) => {
      lecturers.value = response.data.lecturer;
      console.log(response.data);
    })
    .catch((error) => {
      console.error(error);
    });
}

function deleteLecturer(lecturerId) {
  if (confirm("Are you sure you want to delete this lecturer?")) {
    axiosInstance
      .delete(`/delete/lecturer/${lecturerId}`)
      .then((response) => {
        console.log(response.data);
        getLecturers();
      })
      .catch((error) => {
        console.error(error);
      });
  }
}
</script>

<script>
export default {
  name: "lecturerList",

  methods: {
    editLecturer(lecturerId) {
      // Logic to edit lecturer
      console.log(`Editing lecturer with ID: ${lecturerId}`);
      router.push({ name: 'adminEDLecturer', params: { lecturerId } });
    },
  },
};
</script>

<style scoped>
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
