<script setup>
import { defineProps } from 'vue'
import Header from './components/Molecules/Header.vue'
import store from './store'
</script>

<template>
  <div class="w-full h-full">
    <Header class="sticky w-full z-50" v-if="store.state.token && (store.state.role == 'student' || store.state.role == 'lecturer')"/>
    <div v-else-if="store.state.token && (store.state.role == 'admin')">
      <Logout />
      ADMIN HEADER HERE
    </div>
    <router-view></router-view>
  </div>
</template>

<style>
.load-in-animation {
  animation: fadeUp 1s cubic-bezier(0, 0, 0.1, 1) backwards;
}

.fade-down-animation {
  animation: fadeInDown 0.5s cubic-bezier(0, 0, 0.1, 1) backwards;
}

.fade-in-animation {
  animation: fadeIn 0.5s cubic-bezier(0, 0, 0.1, 1) backwards;
}

.turn90degs {
  animation: spin90degs 0.5s cubic-bezier(0, 0, 0.1, 1) backwards;
}

@keyframes fadeUp {
  0% {
    opacity: 0;
    transform: translateY(10px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
   0% {
      opacity: 0.2;
   }
   100% {
      opacity: 1;
   }
}

@keyframes fadeInDown {
   0% {
      opacity: 0;
      transform: translateY(-10px);
   }
   100% {
      opacity: 1;
      transform: translateY(0);
   }
}

@keyframes spin90degs {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(90deg);
  }
}
</style>
