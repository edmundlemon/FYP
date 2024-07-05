<template>
  <div>
    <div class="mt-7 text-center font-bold text-5xl"><h1>Reviews {{ setrole === "student" ? " you've made so far" : "" }}</h1></div>
    <div class="w-full h-full flex items-center justify-center">
      <div v-if="loading" class="loader mt-10 "></div>

      <div
        class="w-10/12 flex space-x-3 overflow-y-auto justify-center items-center flex-wrap load-in-animation"
        v-else-if="reviewslots.length"
      >
        <ReviewDisplayCard
          v-for="(slot, index) in reviewslots"
          :key="slot.id"
          :slot="slot"
          :class="index === 0 ? 'ml-3' : ''"
          :role="setrole"
        />
      </div>

      <div v-else class="h-full flex justify-center items-center">
        <h2 class="text-xl font-bold text-gray-800 animate-bounce my-5">
          No reviews yet!
        </h2>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted, ref } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import ReviewDisplayCard from "../Atom/ReviewDisplayCard.vue";
import Loading from "../Atom/SkeletonLoading.vue";
defineProps({
  reviewslots: {
    type: Object,
    required: true,
  },
  setrole: {
    type: String,
    required: true,
  },
  loading: {
    type: Boolean,
    required: true,
  },
});
</script>

<style scoped>
/* HTML: <div class="loader"></div> */

</style>
