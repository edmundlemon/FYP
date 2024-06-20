<template>
  <div class="flex flex-col items-center bg-gray-900" style="width: 30vw">
    <form @submit.prevent="submitReview" class="p-6 w-full load-in-animation">
      <!-- Lecturer info  -->
      <div class="text-white">
        <h1 class="text-white font-bold text-center text-3xl mb-10">Lecturer Review</h1>
        <div class="flex flex-col items-center space-x-3 mt-3">
          <img :src="slot.lecturer.photo" alt="" class="rounded-full w-28 h-28" />
          <h1 class="font-bold text-2xl pb-5">{{ slot.lecturer.name }}</h1>
        </div>
      </div>
      <label for="topic" class="font-bold block text-white mb-2">Rating</label>
      <StarRatingInput
        :rating="reviewSlot.rating"
        @rating="updateRating"
        class="mb-3"
      />

      <!-- Comments -->
      <div class="mb-4 w-full">
        <label for="topic" class="font-bold block text-white mb-2"
          >Comment</label
        >
        <textarea
          id="topic"
          v-model="reviewSlot.comment"
          rows="7"
          class="p-2 bg-gray-700 text-white rounded w-full transition duration-300 ease-in-out w-full rounded-md border-0 shadow-sm ring-1 ring-inset ring-gray-700 focus:ring-2 focus:ring-inset focus:ring-white"
        ></textarea>
      </div>
      <div class="flex flex-row space-x-3">
        <button
          type="button"
          @click="$emit('closeReviewForm')"
          class="glow-effect font-bold transition-all duration-300 bg-white text-darkgray rounded py-2 px-4 hover:bg-gray-500 hover:text-white w-1/2"
        >
          Cancel
        </button>
        <button
          type="submit"
          class="glow-effect font-bold transition-all duration-300 bg-[#FFF] text-darkgray rounded py-2 px-4 hover:bg-gray-900 hover:text-white w-1/2"
          style="font-weight: bold"
        >
          Review
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, defineProps } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import store from "../../store";
import StarRatingInput from "../Atom/StarRatingInput.vue";
import { defineEmits } from "vue";
const props = defineProps({
  slot: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['closeReviewForm', 'runtimeout']);

const reviewSlot = ref({
  rating: 0,
  comment: "",
  slot_id: props.slot.id,
});

function updateRating(rating) {
  reviewSlot.value.rating = rating;
}

function submitReview() {
  axiosInstance
    .post(`/review/${props.slot.lecturer_id}`, reviewSlot.value)
    .then((response) => {
      console.log(response.data);
      emit('closeReviewForm');
      emit('runtimeout');
    })
    .catch((error) => {
      console.log(error);
    });
}
</script>
