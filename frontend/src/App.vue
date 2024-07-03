<template>
  <div class="w-full h-full">
    <Header
      class="relative w-full"
      v-if="
        store.state.token &&
        (store.state.role == 'student' || store.state.role == 'lecturer')
      "
      style="z-index: 9999"
      @edit-profile="openEditProfile"
    />
    <UserDetailsEdit
      v-if="profileEdit"
      class="booking-container absolute z-50"
      style="filter: drop-shadow(0px 4px 10px black)"
      @close-edit="closeEditProfile"
    />

    <div v-if="store.state.token && store.state.role == 'admin'">
      <AdminHeader class="sticky w-full z-50" />
    </div>
    <router-view></router-view>
  </div>
</template>

<script setup>
import { defineProps, ref } from "vue";
import AdminHeader from "./components/Molecules/AdminHeader.vue";
import Header from "./components/Molecules/Header.vue";
import store from "./store";
import UserDetailsEdit from "./components/Organism/UserDetailsEdit.vue";

let user = store.state.user.data;
const profileEdit = ref(false);

function openEditProfile() {
  profileEdit.value = !profileEdit.value;
}

function closeEditProfile() {
  profileEdit.value = false;
  window.location.reload();
}
</script>
