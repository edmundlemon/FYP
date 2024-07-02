<template>
  <div
    class="space-y-3 py-12 border-b border-gray-500 border-opacity-50 w-full h-fit flex flex-col justify-center items-center orange-bg rounded-t-lg shadow-lg"
  >
    <img
      :src="lecturer.photo"
      alt="Descriptive Alt Text"
      class="h-24 w-24 object-contain rounded-lg shadow-xl ring-2 ring-white"
    />
    <div class="flex flex-col items-center justify-center">
      <div class="flex flex-row items-end justify-center">
        <h1 class="text-4xl font-bold my-1.5">{{ lecturer.name }}</h1>
        <div class="flex flex-row items-center ml-2 mb-2">
          ( <span>{{ returnRating(rating) }}</span>)
          <svg
            class="w-4 h-4 ms-1 text-yellow-300"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 22 20"
            style="filter: drop-shadow(0px 1px 1px black)"
          >
            <path
              d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"
            />
          </svg>
        </div>
      </div>

      <div class="flex flex-row contact-container space-x-12">
        <!-- Email -->
        <div class="flex flex-row text-lg my-1.5 items-center">
          <img
            title="Email"
            class="icons w-6 h-6 mr-2"
            src="../../assets/email.png"
            alt=""
          /><a :href="'mailto:' + lecturer.email"
            ><span>{{ lecturer.email }}</span></a
          >
        </div>

        <!-- Office -->
        <div class="flex flex-row text-lg my-1.5 items-center">
          <img
            title="Office"
            class="icons w-6 h-6 mr-2"
            src="../../assets/office.png"
            alt=""
          />
          <span>{{ lecturer.office }}</span>
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
</template>

<script>
import { ref } from 'vue';
export default {
  props: {
    lecturer: {
      type: Object,
      required: true,
    },
    rating: {
      type: Number,
      required: true,
    },
  },
  methods: {
    returnRating(rating) {
      if (rating === null) {
        return 'No rating yet';
      }
      else {
        return rating.toFixed(2); 
      }
    },
  },
};


</script>
