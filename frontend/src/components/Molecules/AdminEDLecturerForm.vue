<template>
  <div
    class="booking-container fixed relative w-full h-full flex justify-center items-center bg-gray-100 py-10"
  >
    <div class="absolute inset-0 bg-black opacity-50 backdrop-blur-sm"></div>
    <div
      class="relative z-10 bg-white rounded-lg shadow-md p-6 w-full max-w-md"
    >
      <h2 class="text-2xl font-bold text-gray-800 mb-4">
        Edit Lecturer Details
      </h2>
      <hr class="mb-4" />
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label
            for="lecturer-name"
            class="block text-sm font-bold text-gray-700"
            >Name</label
          >
          <input
            type="text"
            id="lecturer-name"
            v-model="lecturer.name"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="mb-4">
          <label for="lecturer-id" class="block text-sm font-bold text-gray-700"
            >Lecturer ID</label
          >
          <input
            type="text"
            id="lecturer-id"
            v-model="lecturer.id"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed"
            readonly
          />
        </div>
        <div class="mb-4">
          <label
            for="lecturer-email"
            class="block text-sm font-bold text-gray-700"
            >Email</label
          >
          <input
            type="email"
            id="lecturer-email"
            v-model="lecturer.email"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="mb-4">
          <label
            for="lecturer-faculty"
            class="block text-sm font-bold text-gray-700"
            >Faculty</label
          >
          <select
            v-model="lecturer.faculty"
            id="faculty"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          >
            <option value="" disabled selected>Select Faculty</option>
            <option value="FCI">FCI</option>
            <option value="FOE">FOE</option>
            <option value="FCM">FCM</option>
            <option value="FCA">FCA</option>
          </select>
        </div>
        <div class="mb-4">
          <label
            for="lecturer-office"
            class="block text-sm font-bold text-gray-700"
            >Office</label
          >
          <input
            type="text"
            id="lecturer-office"
            v-model="lecturer.office"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="flex justify-end space-x-4">
          <button
            type="button"
            @click="cancel"
            class="px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
          >
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRoute } from "vue-router";
import route from "../../router/routes";
import axiosInstance from "../../axiosConfig/customAxios";

const router = useRoute();
const lecturerId = router.params.lecturerId;
const lecturer = ref({});
axiosInstance.get(`/lecturer-details/${lecturerId}`).then((response) => {
  // return response.data;
  console.log(response.data);
  lecturer.value = response.data.lecturer;
});
const submitForm = () => {
  // Handle form submission here
  axiosInstance
    .put(`/edit/lecturer/${lecturerId}`, lecturer.value)
    .then((response) => {
      console.log(response.data);
    })
    .catch((error) => {
      console.error(error);
    });
  console.log("Lecturer data saved", lecturer.value);
};

const cancel = () => {
  route.push({ name: "edit-details/lecturers" });
};
</script>

<style scoped>
.relative {
  position: relative;
}

.absolute {
  position: absolute;
}

.inset-0 {
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

.bg-gray-100 {
  background-color: rgba(255, 255, 255, 0.8);
}

.backdrop-blur-sm {
  backdrop-filter: blur(4px);
}

.rounded-md {
  border-radius: 0.375rem;
}

.py-10 {
  padding-top: 2.5rem;
  padding-bottom: 2.5rem;
}
</style>
