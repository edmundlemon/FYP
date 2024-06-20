<template>
  <div class="w-full h-full flex justify-center bg-gray-200 rounded-lg">
    <div class="mt-5 w-9/12 shadow-xl bg-white">
      <div class="bg-gray-50 shadow px-6 py-4 w-full pt-10 pb-10">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900">
          Welcome Aboard, Admin
        </h1>
      </div>

      <!-- This is the Counter of each box -->
      <div class="bg-gray-50 flex justify-around py-2">
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
                  3,682
                </h3>
                <p class="text-xs text-green-500 leading-tight">▲ 57.1%</p>
              </div>
              <div class="absolute bottom-0 inset-x-0">
                <canvas id="chart1" height="70"></canvas>
              </div>
            </div>
          </div>
        </div>
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
                  11,427
                </h3>
                <p class="text-xs text-red-500 leading-tight">▼ 42.8%</p>
              </div>
              <div class="absolute bottom-0 inset-x-0">
                <canvas id="chart2" height="70"></canvas>
              </div>
            </div>
          </div>
        </div>
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
                  8,028
                </h3>
                <p class="text-xs text-green-500 leading-tight">▲ 8.2%</p>
              </div>
              <div class="absolute bottom-0 inset-x-0">
                <canvas id="chart3" height="70"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- This is lecturer list -->
      <div class="w-10/12 bg-gray-50 shadow-lg rounded-lg p-6 w-full">
        <h1 class="text-3xl font-bold mb-2">Lecturer List</h1>
        <div class="overflow-x-auto">
          <div v-for="lecturer in lecturers" :key="lecturer.id"></div>

          <table class="min-w-full bg-white border-2">
            <thead>
              <tr>
                <th
                  class="py-2 px-4 bg-gray-200 text-gray-600 font-bold uppercase text-sm text-left border-b-2"
                >
                  Lectuer ID
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

            {{
              lecturers
            }}
            <tbody>
              <tr v-for="(lecturer, index) in lecturers" class="border-t">
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
      <div class="w-10/12 bg-gray-50 shadow-lg rounded-lg p-6 w-full">
        <h1 class="text-3xl font-bold mb-2">Student List</h1>
        <div class="overflow-x-auto">
          <div v-for="student in students" :key="student.id"></div>

          <table class="min-w-full bg-white border-2">
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

            {{
              students
            }}
            <tbody>
              <tr v-for="(student, index) in students" class="border-t">
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
      <div></div>
    </div>
  </div>
</template>

<script>
import { Chart } from "chart.js";

export default {
  name: "DashboardComponent",
  data() {
    return {
      chartOptions: {
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        tooltips: {
          enabled: false,
        },
        elements: {
          point: {
            radius: 0,
          },
        },
        scales: {
          xAxes: [
            {
              gridLines: false,
              scaleLabel: false,
              ticks: {
                display: false,
              },
            },
          ],
          yAxes: [
            {
              gridLines: false,
              scaleLabel: false,
              ticks: {
                display: false,
                suggestedMin: 0,
                suggestedMax: 10,
              },
            },
          ],
        },
      },
    };
  },
  mounted() {
    this.createChart(
      "chart1",
      [1, 2, 1, 3, 5, 4, 7],
      "rgba(101, 116, 205, 0.1)",
      "rgba(101, 116, 205, 0.8)"
    );
    this.createChart(
      "chart2",
      [2, 3, 2, 9, 7, 7, 4],
      "rgba(246, 109, 155, 0.1)",
      "rgba(246, 109, 155, 0.8)"
    );
    this.createChart(
      "chart3",
      [2, 5, 1, 3, 2, 6, 7],
      "rgba(246, 153, 63, 0.1)",
      "rgba(246, 153, 63, 0.8)"
    );
  },
  methods: {
    createChart(chartId, data, backgroundColor, borderColor) {
      const ctx = document.getElementById(chartId).getContext("2d");
      new Chart(ctx, {
        type: "line",
        data: {
          labels: data,
          datasets: [
            {
              backgroundColor: backgroundColor,
              borderColor: borderColor,
              borderWidth: 2,
              data: data,
            },
          ],
        },
        options: this.chartOptions,
      });
    },
  },
};
</script>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import store from "../../store";

const lecturers = ref([]);

onMounted(() => {
  getLecturers();
});

async function getLecturers() {
  axiosInstance
    .get("/lecturers")
    .then((response) => {
      lecturers.value = response.data;
      console.log(response.data);
    })
    .catch((error) => {
      console.error(error);
    });
}

const students = ref([]);

onMounted(() => {
  getStudents();
});

async function getStudents() {
  axiosInstance
    .get("/students")
    .then((response) => {
      students.value = response.data;
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
