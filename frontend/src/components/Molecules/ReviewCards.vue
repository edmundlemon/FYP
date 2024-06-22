<template>
  <div>
    <div class="mt-7 text-center font-bold text-5xl"><h1>Reviews</h1></div>
    <div class="w-full h-full flex items-center justify-center">
      <div
        class="w-10/12 flex space-x-3 overflow-y-auto justify-center items-center flex-wrap"
      >
        <ReviewDisplayCard
          v-for="(slot, index) in reviewslots"
          :key="slot.id"
          :slot="slot"
          :class="index === 0 ? 'ml-3' : ''"
          :role="setrole"
        />

      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted, ref } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import ReviewDisplayCard from "../Atom/ReviewDisplayCard.vue";

defineProps({
  reviewslots: {
    type: Object,
    required: true,
  },
  setrole: {
    type: String,
    required: true,
  },

});
</script>
