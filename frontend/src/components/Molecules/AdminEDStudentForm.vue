<template>
  <div
    class="relative w-full h-full flex justify-center items-center bg-gray-100 py-10"
  >
    <div class="absolute inset-0 bg-black opacity-50 backdrop-blur-sm"></div>
    <div
      class="relative z-10 bg-white rounded-lg shadow-md p-6 w-full max-w-md"
    >
      <h2 class="text-2xl font-bold text-gray-800 mb-4">
        Edit Student Details
      </h2>
      <hr class="mb-4" />
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label
            for="student-name"
            class="block text-sm font-bold text-gray-700"
            >Name</label
          >
          <input
            type="text"
            id="student-name"
            v-model="student.name"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="mb-4">
          <label for="student-id" class="block text-sm font-bold text-gray-700"
            >Student ID</label
          >
          <input
            type="text"
            id="student-id"
            v-model="student.id"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed"
            readonly
          />
        </div>
        <div class="mb-4">
          <label
            for="student-email"
            class="block text-sm font-bold text-gray-700"
            >Email</label
          >
          <input
            type="email"
            id="student-email"
            v-model="student.email"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="mb-4">
          <label
            for="student-faculty"
            class="block text-sm font-bold text-gray-700"
            >Faculty</label
          >
          <input
            type="text"
            id="student-faculty"
            v-model="student.faculty"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="mb-4">
          <label
            for="student-programme"
            class="block text-sm font-bold text-gray-700"
            >Programme</label
          >
          <input
            type="text"
            id="student-programme"
            v-model="student.programme"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="flex justify-end space-x-4">
          <button
            type="button"
            @click="refreshDetails"
            class="px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
          >
            Refresh
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

<script>
import { ref } from "vue";

export default {
  name: "StudentEdit",
  setup() {
    const originalStudent = ref({
      id: "S123456", // This would be fetched from the backend
      name: "John Doe",
      email: "john.doe@example.com",
      faculty: "Engineering",
      programme: "Computer Science",
    });

    const student = ref({ ...originalStudent.value });

    const refreshDetails = () => {
      student.value = { ...originalStudent.value };
    };

    const submitForm = () => {
      // Handle form submission here
      console.log("Student data saved", student.value);
    };

    return {
      student,
      refreshDetails,
      submitForm,
    };
  },
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
