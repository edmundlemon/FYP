<template>
  <div>
    <!-- Your HTML code here -->
    <div class="flex flex-row space-x-2 items-center">
      <h2 class="font-semibold ml-1">Consulted by</h2>

      <div class="items-center group relative mx-5">
        <a
          :href="'/lecturer/' + lecturerInfo.id"
          class="transition-text duration-300 ease-in-out font-bold hover:text-blue-500 whitespace-nowrap"
          >{{ lecturerInfo.name }}</a
        >
        <img
          class="rounded-full w-11 h-11 fade-down-animation absolute left-[110%] bottom-[-10px] font-semibold hidden group-hover:flex flex-col bg-gray-200 border-gray-400 border  "
          :src="lecturerInfo.photo"
          alt="Lecturer Photo"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import axiosInstance from "../../axiosConfig/customAxios";
import { ref, onMounted, defineProps } from "vue";

const lecturerInfo = ref({});

const props = defineProps({
  lecturerid: String,
});

onMounted(async () => {
  // Your code here
  axiosInstance
    .get(`/view/lecturer/${props.lecturerid}`)
    .then((response) => {
      lecturerInfo.value = response.data.lecturer;
      console.log(response.data);
    })
    .catch((error) => {
      console.log(error);
    });
});
</script>

<style scoped>
/* Your component's styles here */
</style>
