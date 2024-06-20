<template>
  <!-- <search-bar v-if="store.state.token" /> -->

  <!-- Upcoming/Approved/Pending slots are here -->
  <div class="wrapper flex justify-center w-full">
    <div
      class="container flex justify-center items-center"
    >
      <!-- Dashboard User Info -->
      <div class="flex justify-center w-11/12" >
        <div class="flex flex-col w-full " >
          <div class="bg-white w-full py-5 rounded my-3 shadow-md">
            <h1 class="font-bold text-4xl pl-6 pb-6">
              Welcome to your Dashboard, {{ user.name + "!" }}
            </h1>
            <div class="flex-row flex ml-6">
              <div>
                <img class="rounded-full" :src="user.photo" alt="user photo" />
              </div>
              <div class="flex flex-col justify-center gap-1">
                <h2 class="font-bold text-2xl pl-3">
                  E-mail: <span class="font-normal">{{ user.email }}</span>
                </h2>
                <h2 class="font-bold text-2xl pl-3">
                  Faculty: <span class="font-normal">{{ user.faculty }}</span>
                </h2>
                <h2
                  v-if="store.state.role == 'lecturer'"
                  class="font-bold text-2xl pl-3"
                >
                  Office: <span class="font-normal">{{ user.office }}</span>
                </h2>
              </div>
            </div>
          </div>
          <div
            class="flex flex-row space-x-3 justify-center items-center w-full"
          >
            <upcoming-slot
              class="bg-white shadow-md rounded flex-1 w-1/3 pb-5"
            />
            <approved-slot
              class="bg-white shadow-md rounded flex-1 w-1/3 pb-5"
              @edit-slot="setRescheduleSlot"
            />
            <pending-slot class="bg-white shadow-md rounded flex-1 w-1/3 pb-5" />
          </div>

          <!-- Past slots are here -->
          <div class="past-container w-full mt-3 shadow-md mb-3 ">
            <past-slot class="bg-white pb-5 p-6 shadow rounded flex-1 h-fit" />
          </div>
        </div>
        <div
            v-if="edit"
            class="booking-container fixed top-0 left-0 w-full h-full bg-white bg-opacity-50 z-50 flex justify-center items-center"
          >
            <RescheduleForm
              class="border border-gray-600 rounded-xl border-2 fadein-animation"
              style="filter: drop-shadow(0px 4px 10px black)"
              :booking="rescheduleSlot"
              @closeRescheduleForm="edit = false"
              /> 
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useStore } from "vuex";
import store from "../store";
import axios from "axios";
import UpcomingSlot from "../components/Molecules/UpcomingSlot.vue";
import ApprovedSlot from "../components/Molecules/ApprovedSlot.vue";
import PendingSlot from "../components/Molecules/PendingSlot.vue";
import PastSlot from "../components/Molecules/PastSlot.vue";
import RescheduleForm from "../components/Molecules/RescheduleForm.vue";

const user = store.state.user.data;
const token = store.state.user.token;
const edit = ref(false);
const rescheduleSlot = ref({});
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

function setRescheduleSlot(slot) {
  console.log("Slot => ", slot);
  rescheduleSlot.value = slot;
  edit.value = true;
}

onMounted(() => {});
</script>

<style>

</style>
