<script setup>
import { defineProps } from 'vue'
import Header from './components/Header.vue'
</script>

<template>
  <div>
    <Header></Header>
    <router-view></router-view>
  </div>
</template>

<style scoped>
</style>
