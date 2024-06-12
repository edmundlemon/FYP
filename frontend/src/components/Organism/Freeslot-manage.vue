<template>
  <div class="flex justify-center">
    <div class="w-10/12 bg-gray-100 my-5 rounded-lg shadow-lg relative ">
      <button
        class="z-[0] right-[2vh] bottom-[2vh] border border-black border-opacity-20 transition duration-300 ease-in-out absolute rounded-full bg-white hover:bg-gray-100 focus:outline-none spin180degs z-50 w-12 h-12"
        type="button"
        @click="freeslotform = !freeslotform"
        title="Add Free Slot"
      >
        <img
          class="w-7 h-7 mx-auto"
          src="../../assets/add.png"
          alt="Book Appointment"
        />
      </button>
      <!-- Your component content goes here -->
      <EditFreeSlot
        :text="'Current Free Slots'"
        :lecturerId="store.state.user.data.id"
      />
      <div
        v-if="freeslotform"
        class="booking-container fixed top-0 left-0 w-full h-full bg-white bg-opacity-50 z-50 flex justify-center items-center"
      >
        <FreeSlotForm
          class="border border-gray-600 rounded-xl border-2 fadein-animation"
          style="filter: drop-shadow(0px 4px 10px black)"
          :lecturer-id="lecturerId"
          @closeBookingForm="freeslotform = false"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import EditFreeSlot from "../Molecules/Edit-FreeSlot.vue";
import FreeSlotForm from "../Molecules/FreeSlotForm.vue";
import store from "../../store";
import { onMounted } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import { ref } from "vue";

let freeslotform = ref(false);

console.log(store.state.user.data.id);
</script>

<style scoped>
/* Your component styles go here */
</style>
