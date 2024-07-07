<template>
  <!--
	  This example requires updating your template:
  
	  ```
	  <html class="h-full">
	  <body class="h-full">
	  ```
	-->
  <main
    class="grid min-h-full place-items-center px-6 pt-20 text-center"
  >
    <div class="flex flex-row items-center justify-center">
      <div>
        <div class="flex flex-col">
          <img
            src="/src/assets/shrek.png"
            alt="green_goblin"
            class="h-[40vh]"
			style="filter: drop-shadow(5px 5px 20px green)"
          />
        </div>
        <p class="text-base font-semibold text-indigo-600 mt-10">404</p>
        <h1
          class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl"
        >
          Page not found
        </h1>
        <p class="mt-6 text-base leading-7 text-gray-600">
          Sorry, we couldn’t find the page you’re looking for.
        </p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
          <a
            :href="store.state.user.role === 'student' || store.state.user.role === 'lecturer' ? '/dashboard' : '/adminDashboard'"
            class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >Go back home</a
          >
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: "NotFound",
};
</script>

<script setup>
import store from '../store';

store
</script>
