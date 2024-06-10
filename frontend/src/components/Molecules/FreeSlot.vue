<template>
  <div class="flex flex-col">
    <h3 class="text-2xl font-semibold ml-5 py-5">Free Slots</h3>
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
			<div class="grid grid-cols-5 gap-4">
			  <div v-for="day in [1, 2, 3, 4, 5]">
				<p class="text-xl font-semibold">{{ getDay(day) }}</p>
				<div v-if="hasSlotsForDay(day)">
				  <div v-for="slot in getSlotsForDay(day)" :key="slot.id">
					<free-slot-display class="mr-3" :slot="slot" />
				  </div>
				</div>
				<div v-else>
				  <p>No free slot for this day</p>
				</div>
			  </div>
			</div>
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
import { onMounted, ref, defineProps } from "vue";
// import axiosInstance from '../axiosConfig/customAxios'
import FreeSlotDisplay from "../Atom/FreeSlotDisplay.vue";
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

<style></style>
