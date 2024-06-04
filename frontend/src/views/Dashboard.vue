<template>
  <search-bar v-if="store.state.token" />

  <div class="flex justify-center">
    <div class="flex flex-col w-10/12">
      <div
        class="bg-white w-full py-5 rounded my-3"
        style="border: 1px solid green"
      >
        <h1 class="font-bold text-4xl pl-6 pb-6">
          Welcome to your Dashboard, {{ user.name + "!" }}
        </h1>
        <div class="flex-row flex ml-6">
          <div>
            <img class="rounded-full" :src="user.photo" alt="user photo" />
          </div>
          <div class="flex flex-col justify-center gap-1">
            <h2 class="font-bold text-2xl pl-3">E-mail: {{ user.email }}</h2>
            <h2 class="font-bold text-2xl pl-3">Faculty: {{ user.faculty }}</h2>
            <h2 v-if="store.state.role == 'lecturer'" class="font-bold text-2xl pl-3">Office: {{ user.office }}</h2>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="flex flex-row space-x-3">
          <upcoming-slot class="bg-white p-6 shadow rounded flex-1 h-fit" />
          <approved-slot class="bg-white p-6 shadow rounded flex-1 h-fit" />
          <div class="flex flex-col flex-1">
            <pending-slot class="bg-white p-6 shadow rounded flex-1 h-fit" />
          </div>
        </div>
        <div class="past-container w-full mt-3">
          <past-slot class="bg-white p-6 shadow rounded flex-1 h-fit" />
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
import UpcomingSlot from "../components/UpcomingSlot.vue";
import ApprovedSlot from "../components/ApprovedSlot.vue";
import PendingSlot from "../components/PendingSlot.vue";
import PastSlot from "../components/PastSlot.vue";

const user = store.state.user.data;
const token = store.state.user.token;
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

onMounted(() => {});
</script>

<style></style>
