<template>
  <div class="space-y-3" v-if="reviewsize">
    <div class="font-bold text-lg ml-1">
      This student has made {{ reviewsize }} review(s) so far!
    </div>
    <div v-for="review in review">
      <div class="border border-gray-400 rounded-xl p-2">
        <LecturerInfo :lecturerid="review.lecturer_id" />
        <!-- Star rating shows here! -->
        <StarRating :rating="review.rating" class="my-1" />
        <p class="ml-2">{{ review.comment }}</p>
      </div>
    </div>
  </div>
  <div v-else>
    <p class="font-semibold">No reviews by this student yet...</p>
  </div>
</template>

<script setup>
import StarRating from "../Atom/StarRating.vue";
import LecturerInfo from "../Atom/DisplayLecturerInfo.vue";
import { defineProps, ref, onMounted } from "vue";

const props = defineProps({
  review: Object,
  reviewsize: Number,
});
</script>
