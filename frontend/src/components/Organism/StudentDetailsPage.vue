<template>
  <div
    class="relative flex flex-col border border-gray-700 w-10/12 m-auto rounded-lg shadow-lg bg-white mt-5 fade-in-animation"
    v-if="student != null && !fail"
  >
    
  <StudentDetails :student="student" />

	<!-- Reviews -->
    <ViewReview class="m-5" :review="review" :reviewsize="review.length"/>
  </div>
  <div v-else-if="fail" class="flex flex-col items-center justify-center mt-[13vh] font-semibold">
    <span>User does not exists...</span>
    <img src="../../assets/edmund.gif" alt="goofy" class="border border-gray-400 shadow-2xl rounded-lg w-[8vw]">
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
import { defineProps, onMounted, ref } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import { useRoute } from "vue-router";
import ViewReview from "../Molecules/ViewReview.vue";
import StudentDetails from "../Molecules/StudentDetails.vue";

const route = useRoute();
const student = ref(null);
const review = ref(null);
const fail = ref(false);

onMounted(() => {
  getStudentInfo();
  getReview();
});

async function getStudentInfo() {
  const studentId = route.params.id;
  // console.log(route.path);
  console.log(studentId);
  try {
    const response = await axiosInstance.get(`/view/student/${studentId}`);
    student.value = response.data.student;
  } catch (error) {
    fail.value = true;
    console.error("Failed to fetch student details:", error);
  }
}

async function getReview() {
  const studentId = route.params.id;
  try {
    const response = await axiosInstance.get(`/student/reviews/${studentId}`);
    review.value = response.data.reviews;
    console.log(review.value);
  } catch (error) {
    console.error("Failed to fetch student review:", error);
  }
}
</script>

<style></style>
