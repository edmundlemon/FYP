<template>
	<transition name="fade">
	  <div v-if="flashMessage" class="flash-message">
		{{ flashMessage }}
	  </div>
	</transition>
  </template>
  
  <script setup>
  import { computed, watch } from 'vue'
  import { useStore } from 'vuex'
  
  const store = useStore()
  const flashMessage = computed(() => store.getters.getFlashMessage)
  
  watch(flashMessage, (newVal) => {
	if (newVal) {
	  setTimeout(() => {
		store.dispatch('clearFlashMessage')
	  }, 3000)
	}
  })
  </script>
  
  <style scoped>
  .flash-message {
	position: fixed;
	top: 20px;
	right: 20px;
	padding: 10px 20px;
	background-color: #4CAF50;
	color: white;
	border-radius: 5px;
	z-index: 1000;
  }
  
  .fade-enter-active, .fade-leave-active {
	transition: opacity 0.5s;
  }
  .fade-enter-from, .fade-leave-to {
	opacity: 0;
  }
  </style>