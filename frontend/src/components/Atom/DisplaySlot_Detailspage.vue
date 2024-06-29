<template>
  <div :id="slot.id" class="flex justify-center items-center relative">
    <div class="flex flex-col bg-white shadow-md rounded-md w-full border">
      <!-- Slot topic -->
      <div class="items-center group relative absolute top-1 left-1 w-fit">
        <div class="flex flex-row items-center w-fit">
          <img
            src="../../assets/info.png"
            alt="topic_icon"
            class="w-4 h-4 mr-1"
          />
          <p>Info</p>
        </div>
        <div
          class="w-[13vw] fade-down-animation absolute left-0 top-6 font-semibold hidden group-hover:flex flex-col p-2 bg-gray-200 rounded-xl border-gray-400 border"
        >
          <div class="font-normal">
            <p>Consultation with</p>
            <a
              :href="
                store.state.role === 'lecturer'
                  ? `/student/${slot.student.id}`
                  : `/lecturer/${slot.lecturer.id}`
              "
              ><p class="font-bold text-blue-500">
                {{
                  store.state.role === "lecturer"
                    ? slot.student.name
                    : slot.lecturer.name
                }}
              </p>
            </a>
          </div>
          <div class="font-normal mt-2">
            <p class="underline">Topic</p>
            <p class="font-bold">{{ slot.topic ? slot.topic : "No topic" }}</p>
          </div>
        </div>
      </div>

      <!-- Slot date and time -->
      <div class="pt-2 pb-4">
        <h3 class="text-lg font-bold mb-2 text-gray-800 text-center">
          Date: {{ slot.date }}
        </h3>
        <div class="flex flex-col space-y-2 justify-center items-center">
          <div class="flex flex-row items-center">
            <svg
              width="16"
              height="16"
              viewBox="0 0 16 16"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              class="w-4 h-4 text-green-500 flex"
            >
              <circle cx="8" cy="8" r="6" />
              <line x1="8" y1="8" x2="12" y2="8" />
            </svg>
            <span class="ml-0.5 font-bold text-green-500">{{
              slot.start_time
            }}</span>
          </div>
          <div class="flex flex-row items-center">
            <svg
              width="16"
              height="16"
              viewBox="0 0 16 16"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              class="w-4 h-4 text-red-500 flex"
            >
              <circle cx="8" cy="8" r="6" />
              <line x1="8" y1="8" x2="12" y2="8" />
            </svg>
            <span class="ml-0.5 font-bold text-red-500">{{
              slot.end_time
            }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted, defineEmits } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import { ref } from "vue";
import RescheduleForm from "../Molecules/RescheduleForm.vue";

const emit = defineEmits(["getSchedule"]);

const props = defineProps({
  slot: {
    type: Object,
    required: true,
  },
});
</script>

<style></style>
