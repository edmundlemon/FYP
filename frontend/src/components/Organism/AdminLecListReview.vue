<template>
  <div class="bg-gray-100 p-4 flex justify-center">
    <div class="w-full max-w-4xl p-4 min-h-screen">
      <div
        v-for="lecturer in lecturers"
        :key="lecturer.id"
        @click="viewLecturerDetails(lecturer.id)"
        class="bg-white p-4 rounded-lg shadow-md mb-4 cursor-pointer transition-transform transform hover:-translate-y-1 hover:shadow-xl hover:bg-gray-50"
      >
        <div class="flex justify-between items-center space-x-4">
          <div>
            <div class="text-sm text-gray-600">
              Total {{ lecturer.totalReviews }} reviews found
            </div>
            <div class="flex items-center">
              <!-- <span class="text-3xl font-bold">{{ lecturer.averageRating.toFixed(1) }}</span> -->
              <div class="flex items-center mt-2">
                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                  <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                  <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                  <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
                <svg class="w-4 h-4 text-yellow-300 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                  <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
                <svg class="w-4 h-4 text-gray-300 me-1 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                  <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
                <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">{{ lecturer.averageRating }}</p>
                <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">out of</p>
                <p class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400">5</p>
              </div>
            </div>
          </div>
          <div class="flex space-x-4">
            <div class="text-center">
              <div class="text-sm  font-bold text-gray-500">Reviewed Students</div>
              <div class="text-xl font-bold text-purple-400">
                {{ lecturer.reviewedPercentage }}%
              </div>
            </div>
            <div class="text-center">
              <div class="text-sm font-bold text-gray-500">Total Comments</div>
              <div class="text-xl font-bold text-purple-400">
                {{ lecturer.totalComments }}
              </div>
            </div>
          </div>
          <div class="flex items-center">
            <img
              :src="lecturer.photo"
              alt="lecturer photo"
              class="w-12 h-12 rounded-full"
            />
            <div class="ml-2">
              <div class="text-sm font-bold">{{ lecturer.name }}</div>
              <div class="text-sm text-gray-500">{{ lecturer.faculty }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      lecturers: [
        {
          id: 1,
          name: "Satya Nadella",
          faculty: "Computer Science",
          photo: "https://randomuser.me/api/portraits/men/3.jpg",
          totalReviews: 100,
          averageRating: 4.3,
          reviewedPercentage: 88,
          totalComments: 93,
        },
        // More lecturer objects here...
      ],
    };
  },
  methods: {
    viewLecturerDetails(id) {
      // Logic to navigate to the lecturer's detail page
      this.$router.push({ name: "LecturerDetails", params: { id } });
    },
  },
};
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
.transition-transform {
  transition: transform 0.2s;
}
</style>