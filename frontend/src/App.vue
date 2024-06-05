<script setup>
import { defineProps } from 'vue'
import Header from './components/Header.vue'
import store from './store'
</script>

<template>
  <div class="w-full h-full">
    <Header class="sticky w-full z-50" v-if="store.state.token"/>
    <router-view></router-view>
  </div>
</template>

<style>
.load-in-animation {
  animation: fadeUp 1s cubic-bezier(0, 0, 0.1, 1) backwards;
}

@keyframes fadeUp {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
