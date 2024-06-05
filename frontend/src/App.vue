<script setup>
import { defineProps } from 'vue'
import Header from './components/Header.vue'
import store from './store'
</script>

<template>
  <div>
    <Header class=" " v-if="store.state.token"/>
    <router-view></router-view>
  </div>
</template>

<style scoped>
</style>
