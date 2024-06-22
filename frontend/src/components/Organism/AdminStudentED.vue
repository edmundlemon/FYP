<template>
  <div
    class="min-w-screen min-h-screen bg-gray-100 flex items-center justify-center py-10"
  >
    <div class="w-10/12 bg-white shadow-lg rounded-lg p-6">
      <h1 class="text-3xl font-bold mb-6">Student List</h1>
      <div class="overflow-x-auto">
        <div v-for="student in students" :key="student.id"></div>

        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th
                class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left"
              >
                Student ID
              </th>
              <th
                class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left"
              >
                Name
              </th>
              <th
                class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left"
              >
                Email
              </th>
              <th
                class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left"
              >
                Faculty
              </th>
              <th
                class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left"
              >
                Programme
              </th>
              <th
                class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left"
              >
                Actions
              </th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="(student, index) in students"
              :key="index"
              class="border-t"
            >
              <td class="py-2 px-4">{{ student.id }}</td>
              <td class="py-2 px-4">{{ student.name }}</td>
              <td class="py-2 px-4">{{ student.email }}</td>
              <td class="py-2 px-4">{{ student.faculty }}</td>
              <td class="py-2 px-4">{{ student.program }}</td>
              <td class="py-2 px-4 flex flex-row space-x-2">
                <button
                  class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white rounded-full py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                  @click="editStudent(student.id)"
                >
                  Edit
                </button>
                <button
                  class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white rounded-full py-2 px-4 border border-red-500 hover:border-transparent rounded"
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
import store from "../../store";

const students = ref([]);

onMounted(() => {
  getStudents();
});

async function getStudents() {
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
</script>
<script>
export default {
  name: "StudentList",

  methods: {
    editStudent(studentId) {
      // Logic to edit student
      console.log(`Editing student with ID: ${studentId}`);
    },
    deleteStudent(studentId) {
      // Logic to delete student
      console.log(`Deleting student with ID: ${studentId}`);
      this.students = this.students.filter(
        (student) => student.id !== studentId
      );
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
