<template>
  <div class="flex flex-col h-fit pb-20 items-center">
    <h3 class="text-2xl font-semibold py-5 pt-10 letter-spaced">
      {{ text }}
    </h3>
    <div class="h-fit">
      <div class="container mx-auto px-4">
        <div class="h-full overflow-y-auto no-scrollbar">
          <!-- grid container here -->
          <div v-if="showLoading" class="w-full">
            <Loading style="padding-right: 1vw; padding-left: 0.4vw" />
          </div>
          <div
            class="load-in-animation max-h-screen w-full rounded-lg"
            v-else-if="slots.length > 0 && !showLoading"
          >
          <div class="flex flex-wrap justify-center items-center space-x-4">

              <div
                class="flex-1 max-h-screen w-full border border-black flex flex-col items-center pb-5 rounded-lg shadow-lg bg-white mt-5"
                v-for="day in [1, 2, 3, 4, 5]"
              >
                <p class="my-5 text-xl font-bold">{{ getDay(day) }}</p>
                <div class="space-y-2" v-if="hasSlotsForDay(day)">
                  <div v-for="slot in getSlotsForDay(day)" :key="slot.id">
                    <EditFreeSlotDisplay class="mx-3" :slot="slot" />
                  </div>
                </div>
                <div v-else>
                  <div>
                    <div class="flex justify-center items-center">
                      <p class="text-xl font-semibold text-gray-800">
                        No available slots
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="h-full flex justify-center items-center">
            <h2 class="text-xl font-bold text-gray-800 animate-bounce my-5">
              Freeslots not available
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, defineProps } from "vue";
// import axiosInstance from '../axiosConfig/customAxios'
import EditFreeSlotDisplay from "../Atom/EditFreeSlotDisplay.vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import Loading from "../Atom/SkeletonLoading.vue";

const days = ref([]);
const slots = ref([]);
const props = defineProps({
  lecturerId: {
    type: String,
    required: true,
  },
  text: {
    type: String,
    default: "Available slots",
  },
});
// loading state
const showLoading = ref(true);
onMounted(async () => {
  axiosInstance
    .get(`/free-slots/${props.lecturerId}`)
    .then((response) => {
      slots.value = response.data.freeslots;
      showLoading.value = false;
      days.value = slots.value.map((slot) => new Date(slot.date).getDay());
      console.log(days.value);
    })
    .catch((error) => {
      console.log(error);
    });
  // if (store.state.role === "student") {
  //   axiosInstance
  // 	.get("/student/pending")
  // 	.then((response) => {
  // 	  slots.value = response.data.consultation_slots;
  // 	  showLoading.value = false;
  // 	})
  // 	.catch((error) => {
  // 	  console.log(error);
  // 	});
  // } else {
  //   axiosInstance
  // 	.get("/lecturer/schedule")
  // 	.then((response) => {
  // 	  slots.value = response.data.consultation_slots;
  // 	  showLoading.value = false;
  // 	})
  // 	.catch((error) => {
  // 	  console.log(error);
  // 	});
  // }
});

function hasSlotsForDay(day) {
  return days.value.includes(day);
}

function getSlotsForDay(day) {
  return slots.value.filter((slot) => new Date(slot.date).getDay() === day);
}

function getDay(day) {
  switch (day) {
    case 0:
      return "Sunday";
    case 1:
      return "Monday";
    case 2:
      return "Tuesday";
    case 3:
      return "Wednesday";
    case 4:
      return "Thursday";
    case 5:
      return "Friday";
    case 6:
      return "Saturday";
    default:
      return "Unknown";
  }
}
</script>

<style scoped>
.letter-spaced {
  letter-spacing: 0.1em;
}
</style>
