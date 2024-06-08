<template>
  <div
    class="bg-style relative bg-gray-100 flex flex-col items-center justify-center border border-gray-300 p-5 w-full rounded-lg shadow-md pt-6 hover:shadow-2xl hover:scale-105 transition duration-300 ease-in-out"
  >
    <div
      class="absolute left-3 rounded-t-lg blur-bottom"
      style="top: -2%; background-color: #f15a59; z-index: 5000"
    >
      <p class="text-lg px-6 font-semibold text-center">
        {{ student.faculty }}
      </p>
    </div>
    <!-- student Image -->
    <a class="mb-5" :href="'/student/' + student.id">
      <img
        :src="student.photo"
        alt="Descriptive Alt Text"
        class="max-h-40 object-contain rounded-full shadow-md"
      />
    </a>

    <!-- student Faculty Display -->

    <!-- Name pill box with student name-->
    <div
      class="space-y-1 flex flex-col items-center justify-center w-full mt-0 z-10"
    >
      <div
        class="transition duration-300 ease-in-out transform hover:scale-105 relative flex flex-col justify-center z-10"
      >
        <p
          class="font-semibold absolute bg-green-400 rounded-full p-3 w-7 h-7 text-xl flex items-center justify-center border border-black"
          style="left: -8%; z-index: 10"
        >
          @
        </p>
        <!-- student name block -->
        <a :href="'/student/' + student.id">
          <h1
            class="bg-gray-300 rounded-full py-2 px-5 text-2xl font-bold my-1.5 border border-black"
          >
            {{ student.name }}
          </h1>
        </a>
      </div>

      <a
        class="transition duration-300 ease-in-out transform hover:scale-105 z-10"
        :href="'mailto:' + student.email"
      >
        <p class="text-lg my-1.5">{{ student.email }}</p>
      </a>
      <p class="text-lg my-1.5 z-10">{{ student.id }}</p>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted } from "vue";

const props = defineProps({
  student: {
    type: Object,
    required: true,
  },
});
</script>

<style scoped>
.blur-bottom::after {
  content: "";
  position: absolute;
  bottom: -2px; /* Adjust as needed */
  left: 0;
  right: 0;
  height: 5px; /* Adjust as needed */
  background: inherit;
  filter: blur(4px); /* Adjust blur radius as needed */
  z-index: -1; /* To place the blur behind the original div content */
  border-bottom-left-radius: inherit; /* To match the border radius */
  border-bottom-right-radius: inherit; /* To match the border radius */
}
</style>
