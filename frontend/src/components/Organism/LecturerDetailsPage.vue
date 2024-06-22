<template>
  <div
    class="flex flex-col items-center justify-center border border-gray-700 w-10/12 m-auto rounded-lg shadow-lg bg-white mt-5 fade-in-animation"
    v-if="lecturer != null && !fail"
  >
    <LecturerDetails :lecturer="lecturer" :rating="rating" />

    <!-- Lecturer Freeslot view here -->
    <div
      class="border border-gray-500 border-opacity-50 h-full w-full flex flex-col justify-center items-center relative"
    >
      <!-- <p class="font-bold text-center">Insert lecturer schedule here!</p> -->
      <free-slot :lecturer-id="lecturerId"></free-slot
      ><button
        class="z-[0] right-[2vh] bottom-[2vh] border border-black border-opacity-20 transition duration-300 ease-in-out absolute rounded-full bg-green-300 hover:bg-green-400 active:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50 z-50 w-12 h-12 gelatine"
        type="button"
        @click="showBookingform = !showBookingform"
        title="Custom Booking"
        v-if="store.state.role === 'student'"
      >
        <img
          class="w-6 h-6 mx-auto shadow-md"
          src="../../assets/calendar.png"
          alt="Book Appointment"
        />
      </button>
    </div>

    <!-- Booking form -->
    <div
      v-if="showBookingform"
      class="booking-container fixed top-0 left-0 w-full h-full bg-white bg-opacity-50 z-50 flex justify-center items-center"
    >
      <booking-form
        class="border border-gray-600 rounded-xl border-2 fadein-animation"
        style="filter: drop-shadow(0px 4px 10px black)"
        :lecturer-id="lecturerId"
        @closeBookingForm="showBookingform = false"
      />
    </div>
    <div class="w-full mb-10" v-if="rating != null">
      <ReviewCards :loading="loading" :reviewslots="ratingSlots" setrole="lecturer" class=""/>
    </div>
  </div>
  <div
    v-else-if="fail"
    class="flex flex-col items-center justify-center mt-[13vh] font-semibold"
  >
    <span>User does not exists...</span>
    <img
      src="../../assets/edmund.gif"
      alt="goofy"
      class="border border-gray-400 shadow-2xl rounded-lg w-[8vw]"
    />
  </div>
  <div
    v-else
    class="relative justify-center items-center flex-row flex w-10/12 h-full m-auto rounded-lg mt-[13vh]"
  >
    <div class="loader"></div>
  </div>
  <div class="h-5"></div>
</template>

<script setup>
import SkeletonLoading from "../Atom/SkeletonLoading.vue";
import { defineProps, onMounted, ref } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import { useRoute } from "vue-router";
import BookingForm from "../Molecules/CustomBookingForm.vue";
import FreeSlot from "../Molecules/LecturerFreeSlot.vue";
import store from "../../store";
import LecturerDetails from "../Molecules/LecturerDetails.vue";
import ReviewCards from "../Molecules/ReviewCards.vue";

let showBookingform = ref(false);
const route = useRoute();
const lecturer = ref(null);
const lecturerId = route.params.id;
const fail = ref(false);
const rating = ref(0.00);
const ratingSlots = ref({});
const loading = ref(true);
onMounted(async () => {
  console.log(lecturerId);
  try {
    const response = await axiosInstance.get(`/view/lecturer/${lecturerId}`);
    lecturer.value = response.data.lecturer;
  } catch (error) {
    fail.value = true;
    console.error("Failed to fetch lecturer details:", error);
  }

  axiosInstance
    .get(`/rating/${lecturerId}`)
    .then((response) => {
      ratingSlots.value = response.data.reviews;
      rating.value = response.data.rating;
      loading.value = false;
    })
    .catch((error) => {
      console.log(error);
    });
});
</script>

<style scoped></style>
