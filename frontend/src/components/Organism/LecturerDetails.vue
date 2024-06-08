<template>
  {{ lecturer }}
  <div
    class="flex flex-row items-center justify-center border border-gray-700 p-4 w-9/12 m-auto"
    v-if="lecturer"
  >
    <div
      class="space-y-3 py-12 border border-red-700 w-5/12 flex flex-col justify-center items-center mr-4 orange-bg rounded-lg shadow-md"
    >
      <img
        :src="lecturer.photo"
        alt="Descriptive Alt Text"
        class="max-h-40 max-w-40 object-contain rounded-full shadow-md"
      />
      <div class="flex flex-col items-center justify-center">
        <h1 class="text-4xl font-bold my-1.5">{{ lecturer.name }}</h1>

        <div class="contact-container space-y-3">
          <!-- Email -->
          <div class="flex flex-row text-lg my-1.5 items-center">
            <img
              title="Email"
              class="icons w-6 h-6 mr-2"
              src="../../assets/email.png"
              alt=""
            /><span>{{ lecturer.email }}</span>
          </div>

          <!-- Office -->
          <div class="flex flex-row text-lg my-1.5 items-center">
            <img
              title="Office"
              class="icons w-6 h-6 mr-2"
              src="../../assets/office.png"
              alt=""
            /><span>{{ lecturer.office }}</span>
          </div>

          <!-- Faculty -->
          <div class="flex flex-row text-lg my-1.5 items-center">
            <img
              title="Faculty"
              class="icons w-6 h-6 mr-2"
              src="../../assets/faculty.png"
              alt=""
            /><span>{{ lecturer.faculty }}</span>
          </div>

          <!-- User since -->
          <div class="flex flex-row text-lg my-1.5 items-center">
            <img
              title="User since"
              class="icons w-6 h-6 mr-2"
              src="../../assets/clock.png"
              alt=""
            /><span>{{
              new Date(lecturer.created_at).toLocaleDateString()
            }}</span>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showBookingform" class="transition-all booking-container z-50 absolute border border-black w-full h-full border flex justify-center items-center" >
      <booking-form
        class=" border border-gray-600 rounded-xl border-2 fadein-animation "
        style="filter: drop-shadow(0px 4px 10px black);"
        :lecturer-id="lecturerId"
        @closeBookingForm="showBookingform = false"
      />
    </div>
  </div>
  <button class="absolute z-50"type="button" @click="showBookingform = !showBookingform">
    BUTTON
  </button>
</template>

<script setup>
import { defineProps, onMounted, ref } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import { useRoute } from "vue-router";
import BookingForm from "../Molecules/BookingForm.vue";

let showBookingform = ref(false);
const route = useRoute();
const lecturer = ref(null);
const lecturerId = route.params.id;

onMounted(async () => {
  console.log(lecturerId);
  try {
    const response = await axiosInstance.get(`/view/lecturer/${lecturerId}`);
    lecturer.value = response.data.lecturer;
  } catch (error) {
    console.error("Failed to fetch lecturer details:", error);
  }
});
</script>

<style scoped>
.icons {
  filter: invert(1) brightness(2) drop-shadow(0px 2px 3px black);
}

.booking-container{
  backdrop-filter: blur(10px);
  height: 103.2vh;
    
  }
</style>
