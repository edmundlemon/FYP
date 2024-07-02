<template>
  <div class="bg-gray-100 flex justify-center relative">
    <div class="flex flex-col w-full items-center">
      <div class="mt-7 text-center font-bold text-5xl">
        <h1>Lecturer Reviews</h1>
      </div>
      <div
        class="w-full max-w-4xl p-4"
        v-if="lecturers.length && showing"
      >
        <AdminLecturerReviewDisplay
          v-for="lecturer in lecturers"
          :lecturer="lecturer"
          @show-review="showReview"
        />
      </div>
    </div>
    <div
      v-if="showReviews"
      class="booking-container w-9/12 rounded-xl shadow-lg absolute"
      style="background-color: rgba(255, 255, 255, 0.8);"
    >
      <div class="text-white flex justify-end mr-3 mt-3">
        <span
          @click.prevent="refreshandclose"
          class="cursor-pointer bg-red-500 rounded-full"
        >
          <img src="../../assets/close.png" alt="close" class="w-7 h-7 p-2 spin180degs" />
        </span>
      </div>
      <ReviewCards
        class="fade-in-animation flex flex-col justify-center items-center"
        :reviewslots="showingReviews"
        setrole="lecturer"
        :loading="false"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import AdminLecturerReviewDisplay from "../Molecules/AdminLecturerReviewDisplay.vue";
import ReviewCards from "../Molecules/ReviewCards.vue";
const lecturers = ref({});
const showReviews = ref(false);
const showingReviews = ref({});
const showing = ref(true);

function showReview(reviews) {
  showReviews.value = true;
  showingReviews.value = reviews;
  console.log(reviews);
}

onMounted(() => {
  getLecturers();
});

function refreshandclose() {
  showReviews.value = false;
  showing.value = false;
  setTimeout(() => {
    showing.value = true;
  }, 100);
}

function getLecturers() {
  showingReviews.value = {};
  axiosInstance
    .get("/lecturers")
    .then((response) => {
      console.log(response.data);
      lecturers.value = response.data.lecturer;
    })
    .catch((error) => {
      console.error(error);
    });
}
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
.transition-transform {
  transition: transform 0.2s;
}
</style>
