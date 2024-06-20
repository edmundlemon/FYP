<template>
  <div class="bg-gray-100  p-4 flex justify-center">
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
                <span class="text-3xl font-bold">{{
                lecturer.averageRating.toFixed(1)
                }}</span>
                <span class="text-green-500 ml-2">
                <i class="fas fa-star"></i><i class="fas fa-star"></i
                ><i class="fas fa-star"></i><i class="fas fa-star"></i
                ><i class="fas fa-star-half-alt"></i>
                </span>
            </div>
            </div>
            <div class="flex space-x-4">
            <div class="text-center">
                <div class="text-sm text-gray-500">Reviewed Students</div>
                <div class="text-xl font-bold text-green-500">
                {{ lecturer.reviewedPercentage }}%
                </div>
            </div>
            <div class="text-center">
                <div class="text-sm text-gray-500">Total Comments</div>
                <div class="text-xl font-bold text-green-500">
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
