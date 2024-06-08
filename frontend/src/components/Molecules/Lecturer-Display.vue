<template>
  <div
    class="bg-style relative bg-gray-100 flex flex-col items-center justify-center border border-gray-300 p-5 w-full rounded-lg shadow-md pt-6 hover:shadow-2xl hover:scale-105 transition duration-300 ease-in-out"
  >
    <div
      class="absolute left-3 rounded-t-lg blur-bottom"
      style="top: -2%; background-color: #f15a59; z-index: 5000"
    >
      <p class="text-lg px-6 font-semibold text-center">
        {{ lecturer.faculty }}
      </p>
    </div>
    <!-- Lecturer Image -->
    <a class="mb-5" :href="'/lecturer/' + lecturer.id">
      <img
        :src="lecturer.photo"
        alt="Descriptive Alt Text"
        class="max-h-40 object-contain rounded-full shadow-md"
      />
    </a>

    <!-- Lecturer Faculty Display -->

    <!-- Name pill box with lecturer name-->
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
        <!-- Lecturer name block -->
        <a :href="'/lecturer/' + lecturer.id">
          <h1
            class="bg-gray-300 rounded-full py-2 px-5 text-2xl font-bold my-1.5 border border-black"
          >
            {{ lecturer.name }}
          </h1>
        </a>
      </div>

      <a
        class="transition duration-300 ease-in-out transform hover:scale-105 z-10"
        :href="'mailto:' + lecturer.email"
      >
        <p class="text-lg my-1.5">{{ lecturer.email }}</p>
      </a>
      <p class="text-lg my-1.5 z-10">{{ lecturer.id }}</p>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted } from "vue";

const props = defineProps({
  lecturer: {
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
