<template>
  <div
    class="bg-white p-4 rounded-lg shadow-md mb-4 cursor-pointer transition-transform transform hover:-translate-y-1 hover:shadow-xl hover:bg-gray-50"
    @click.prevent="$emit('show-review', reviews)"
  >
    <div class="flex justify-between items-center space-x-4">
      <div>
        <div class="text-sm text-gray-600">
          <!-- Total {{ lecturer.totalReviews }} reviews found -->
        </div>
        <div class="flex items-center">
          <div class="flex items-center mt-2">
            <!-- Star rating here -->
            <StarRating :rating="averageRating" class="mr-2" />
            <p
              class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400"
            >
              {{ returnRating(averageRating) }}
            </p>
            <div class="flex flex-row" v-if="averageRating > 0">
              <p
                class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap"
              >
                out of
              </p>
              <p
                class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400"
              >
                5
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Total reviews and Comments -->
      <div class="flex space-x-4">
        <div class="text-center">
          <div class="text-sm font-bold text-gray-500">Students Reviewed</div>
          <div class="text-xl font-bold text-purple-400">
            {{ returnPercentage(distinct_count / student_count) }}%
          </div>
        </div>
        <div class="text-center">
          <div class="text-sm font-bold text-gray-500">Total Comments</div>
          <div class="text-xl font-bold text-purple-400">
            {{ commentcount }}
          </div>
        </div>
      </div>

      <!-- lecturer information -->
      <div class="flex items-center w-[20%] z-50">
        <a :href="'/lecturer/' + lecturer.id">
          <img
            :src="lecturer.photo"
            alt="lecturer photo"
            class="w-12 h-12 rounded-full"
          />
        </a>
        <div class="ml-2">
          <a :href="'/lecturer/' + lecturer.id">
            <div class="text-sm font-bold">{{ lecturer.name }}</div>
          </a>
          <div class="text-sm text-gray-500">{{ lecturer.faculty }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, defineEmits, defineProps } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import StarRating from "../Atom/StarRating.vue";

const props = defineProps({
  lecturer: {
    type: Object,
    required: true,
  },
});

const reviews = ref({});
const averageRating = ref(0);
const distinct_count = ref(0);
const student_count = ref(0);
const commentcount = ref(0);
onMounted(async () => {
  getReviews();
});

function getReviews() {
  axiosInstance
    .get(`/rating/${props.lecturer.id}`)
    .then((response) => {
      reviews.value = response.data.reviews;
      commentcount.value = response.data.comment_count;
      averageRating.value = response.data.rating;
      distinct_count.value = response.data.distinct_count;
      student_count.value = response.data.student_count;
    })
    .catch((error) => {
      console.error(error);
    });
}

function returnRating(rating) {
  if (rating === null) {
    return "No rating yet";
  } else {
    return rating.toFixed(2);
  }
}

function returnPercentage(value) {
  return value * 100;
}
</script>
