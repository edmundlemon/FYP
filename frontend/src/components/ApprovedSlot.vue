<template>
  <div class="flex flex-col">
    <h3 class="text-2xl font-semibold ml-5 py-5">Approved Consultations</h3>
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
import { onMounted, ref } from "vue";
// import axiosInstance from '../axiosConfig/customAxios'
import TimeDisplay from "./TimeDisplay.vue";
import store from "../store";
import axiosInstance from "../axiosConfig/customAxios";
import Loading from "./Atom/SkeletonLoading.vue";

const slots = ref([]);
// loading state
const showLoading = ref(true);

onMounted(async () => {
  if (store.state.role === "student") {
    axiosInstance
      .get("/student/approved")
      .then((response) => {
        slots.value = response.data.consultation_slots;
      })
      .catch((error) => {
        console.log(error);
      });
  } else {
    axiosInstance
      .get("/lecturer/schedule")
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
});
</script>

<style></style>
