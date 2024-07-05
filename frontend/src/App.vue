<template>
  <div class="w-full h-full">
    <Header
      class="relative w-full"
      v-if="
        store.state.token &&
        (store.state.role == 'student' || store.state.role == 'lecturer')
      "
      style="z-index: 99"
      @edit-profile="openEditProfile"
      @change-password="changePassword"
    />
    <UserDetailsEdit
      v-if="profileEdit"
      class="booking-container absolute z-50"
      style="filter: drop-shadow(0px 4px 10px black)"
      @close-edit="closeEditProfile"
    />
    <ChangePassword
      v-if="passwordChange"
      class="booking-container absolute z-50"
      style="filter: drop-shadow(0px 4px 10px black)"
      @close-edit="closeChangePassword"
    />
    <FlashCard style="z-index: 999;"/>

    <div v-if="store.state.token && store.state.role == 'admin'">
      <AdminHeader class="sticky w-full z-50" 
        @change-password="changePassword"/>
      <ChangePassword
      v-if="passwordChange"
      class="booking-container absolute z-50"
      style="filter: drop-shadow(0px 4px 10px black)"
      @close-edit="closeChangePassword"
    />
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
import ChangePassword from "./components/Organism/ChangePassword.vue";
import FlashCard from "./components/Atom/FlashMessage.vue";

let user = store.state.user.data;
const profileEdit = ref(false);
const passwordChange = ref(false);

function openEditProfile() {
  profileEdit.value = !profileEdit.value;
}

function changePassword() {
  passwordChange.value = !passwordChange.value;
}

function closeEditProfile() {
  profileEdit.value = false;
  window.location.reload();
}

function closeChangePassword(message) {
  passwordChange.value = false;
  store.dispatch('setFlashMessage', message)
  setTimeout(() => {
    store.dispatch('clearFlashMessage', message)
		}, 3000)
}
</script>
