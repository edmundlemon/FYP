<template>
  <div class="flex flex-col">
    <h3 class="text-2xl font-semibold ml-5 py-5">Upcoming Consultations</h3>
    <div class="h-fit">
      <div class="container mx-auto px-4">
        <div style="height: 60vh">
          <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"> -->
          <div v-if="showLoading" class="h-full w-full">
            <Loading style="padding-right: 1vw; padding-left: 0.4vw" />
          </div>
          <div
            class="overflow-y-auto load-in-animation"
            v-else-if="slots.length > 0 && !showLoading"
            style="height: 60vh"
          >
            <TimeDisplay
              class="mr-3"
              v-for="slot in slots"
              :key="slot.id"
              :slot="slot"
            />
          </div>
          <div v-else class="w-full h-full flex justify-center items-center">
            <h2 class="text-xl font-bold text-gray-800 animate-bounce">
              No consultation info...
            </h2>
          </div>
          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, onBeforeMount } from "vue";
import TimeDisplay from "./TimeDisplay.vue";
import axios from "axios";
import store from "../store";
import axiosGet from "../axiosConfig/customAxios";
import Loading from "./Atom/SkeletonLoading.vue";
// import store from '../../../APIBackend/resources/js/store';
const slots = ref([]);
const token = store.state.token;
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

// loading state
const showLoading = ref(true);

onMounted(async () => {
  console.log("Token => ", token);
  console.log("Role => ", store.state.role);
  if (store.state.role === "student") {
    axiosGet("/student/schedule")
      .then((response) => {
        slots.value = response.data.consultation_slots;
      })
      .catch((error) => {
        console.log(error);
      });
  } else {
    axiosGet("/lecturer/schedule")
      .then((response) => {
        slots.value = response.data.consultation_slots;
      })
      .catch((error) => {
        console.log(error);
      });
  }

  setTimeout(() => {
    showLoading.value = false;
    console.log("showLoading", showLoading.value);
  }, 2500);
  // if (store.state.role === 'student') {
  //   const response = await axios.get('http://localhost:8000/api/student/schedule');
  //   slots.value = response.data.consultation_slots;
  // } else {
  //   const response = await axios.get('http://localhost:8000/api/lecturer/schedule');
  //   slots.value = response.data.consultation_slots;
  // }

  // console.log(data);
  // const response = await axios.get('http://localhost:8000/api/student/schedule');
  // const data = await response.data.consultation_slots;
  // slots.value = data;
});
</script>

<style>

</style>
