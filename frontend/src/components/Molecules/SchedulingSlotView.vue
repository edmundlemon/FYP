<template>
  <div class="flex flex-col h-fit pb-20 items-center">
    <h3 class="text-4xl font-bold py-5 pt-10 letter-spaced">
      {{ text }}
    </h3>
    <div class="h-fit">
      <div class="container mx-auto px-4">
        <div class="h-full overflow-y-auto no-scrollbar pb-5">
          <!-- grid container here -->
          <div v-if="showLoading" class="w-full">
            <Loading style="padding-right: 1vw; padding-left: 0.4vw" />
          </div>
          <div
            class="load-in-animation max-h-full w-full rounded-lg"
            v-else-if="slots.length > 0 && !showLoading"
          >
            <div class="flex flex-wrap justify-center space-x-4">
              <div class="" v-for="day in [1, 2, 3, 4, 5]">
                <div
                  class="flex-1 max-h-full w-full border border-black flex flex-col items-center pb-5 rounded-lg shadow-lg bg-white mt-5"
                  :class="
                    day === sameday()
                      ? 'border-2 border-purple-500 bg-purple-50'
                      : 'border-2 border-gray-200'
                  "
                >
                  <p class="my-5 text-xl font-bold text-center">
                    {{ getDay(day) }}
                  </p>
                  <div
                    class="flex-1 min-h-[200px] w-full md:w-[15vw] space-y-2"
                    :class="{ 'h-full': !hasSlotsForDay(day) }"
                  >
                    <div class="space-y-3" v-if="hasSlotsForDay(day)">
                      <div v-for="slot in getSlotsForDay(day)" :key="slot.id">
                        <DisplaySchedulingSlot
                          class="mx-3"
                          :slot="slot"
                          @openRescheduleForm="PassingtoParent"
                          @getSchedule="getSchedule"
                        />
                      </div>
                    </div>
                    <div v-else>
                      <div class="flex justify-center items-center h-full">
                        <p class="text-xl font-semibold text-gray-800 px-5">
                          No consultations
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="h-full flex justify-center items-center">
            <h2 class="text-xl font-bold text-gray-800 animate-bounce my-5">
              Yay >w< you have no consultations!
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    PassingtoParent(data) {
      this.$emit("edit-slot", data);
    },
  },
};
</script>

<script setup>
import { onMounted, ref, defineProps } from "vue";
// import axiosInstance from '../axiosConfig/customAxios'
import DisplaySchedulingSlot from "../Atom/DisplaySchedulingSlot.vue";
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
    default: "Your Schedule",
  },
});

const showLoading = ref(true);
onMounted(async () => {
  getSchedule();
});

function getSchedule() {
  if (store.state.role === "student") {
    axiosInstance
      .get(`/student/schedule`)
      .then((response) => {
        slots.value = response.data.consultation_slots;
        days.value = slots.value.map((slot) => new Date(slot.date).getDay());
        console.log(response.data.consultation_slots);
        showLoading.value = false;
      })
      .catch((error) => {
        console.log(error);
      });
  } else {
    axiosInstance
      .get(`/lecturer/schedule`)
      .then((response) => {
        slots.value = response.data.consultation_slots;
        days.value = slots.value.map((slot) => new Date(slot.date).getDay());
        console.log(response.data.consultation_slots);
        showLoading.value = false;
      })
      .catch((error) => {
        console.log(error);
      });
  }
}

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

function sameday() {
  return new Date().getDay();
}
</script>
