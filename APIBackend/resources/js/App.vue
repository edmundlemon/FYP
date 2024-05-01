<script setup>
import { defineProps } from 'vue'
import Header from './components/Header.vue'
import store from './store'
</script>

<template>
  <!-- <Header></Header> -->
  <div>
    <h1>Hello World</h1>
    <router-link to="/lecturers">View Lecturers</router-link>
    <router-link to="/register-lecturer">Register Lecturers</router-link>
    <router-view></router-view>
  </div>
</template>

<style scoped>
</style>
