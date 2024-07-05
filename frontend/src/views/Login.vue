<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
  <!--
	  This example requires updating your template:
  
	  ```
	  <html class="h-full bg-white">
	  <body class="h-full">
	  ```
	-->
  <div class="wrapper h-screen bg-gray-200 flex justify-center items-center load-in-animation">
    <div
      class="flex-container w-7/12 h-5/6 flex justify-center items-center bg-gray-100 p-2 rounded-xl bg-white"
      style="filter: drop-shadow(15px 10px 20px black)"
    >
      <!-- left side of the login page -->
      <div
        class="left-login flex justify-center items-center w-5/12 flex-col h-full mr-2 rounded-md text-center"
      >
        <img
          class="animate-bounce mx-auto h-40 w-auto rounded-full border-dashed border-2 p-2 shadow-2xl border-white border-2 bg-gray-800"
          style="filter: drop-shadow(5px 5px 4px black)"
          src="../assets/logo.png"
          alt="Your Company"
        />
        <h1
          class="text-white text-4xl font-bold mt-4 leading-9 tracking-tight"
          style="filter: drop-shadow(8px 5px 3px black)"
        >
          Our time is our money, grind till it's sunny.
        </h1>
        <p
          class="text-white text-justify mt-5 px-5 font-medium text-l"
          style="filter: drop-shadow(5px 3px 2px black)"
        >
          The greatest free appointment scheduling tool for college, according
          to instructors and students, is called 3LINGGUN. By simplifying
          scheduling and increasing students' access to services and resources,
          you can improve their performance.
        </p>
      </div>
      <!-- right side of the login page -->
      <div
        class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8 rounded-md bg-gray-200"
      >
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
          <img
            class="mx-auto h-36 w-auto"
            style="filter: drop-shadow(5px 5px 4px black)"
            src="../assets/user-logo.png"
            alt="Your Company"
          />

          <h2
            class="mt-10 text-center text-4xl font-bold leading-9 tracking-tight text-gray-900"
          >
            Login to your account
          </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
          <form class="space-y-6" @submit.prevent="login">
            <div>
              <label
                for="id"
                class="block text-sm font-medium leading-6 text-gray-900"
                >ID</label
              >
              <div class="mt-2">
                <input
                  id="id"
                  name="id"
                  type="text"
                  required=""
                  placeholder="ID"
                  v-model="id"
                  class="transition duration-300 ease-in-out block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6"
                />
                <div v-if="errors.id" class="text-red-500 text-xs mt-1">{{ errors.id[0] }}</div>
              </div>
            </div>

            <div>
              <div class="flex items-center justify-between">
                <label
                  for="password"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Password</label
                >
                <div class="text-sm">
                  <a
                    href="/forgot-password"
                    class="font-semibold text-indigo-600 hover:text-indigo-500"
                    >Forgot password?</a
                  >
                </div>
              </div>
              <div class="mt-2">
                <input
                  id="password"
                  name="password"
                  type="password"
                  autocomplete="current-password"
                  placeholder="Password"
                  required=""
                  v-model="password"
                  class="transition duration-300 ease-in-out block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6"
                />
                <div v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</div>
              </div>
              <div v-if="errors" class="text-red-500 text-xs mt-1">{{ errors.message }}</div>
            </div>

            <div>
              <button
                type="submit"
                class="buttonstyle shadow-xl transition duration-300 ease-in-out flex w-full justify-center rounded-md bg-gray-800 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-white hover:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
              >
                Login
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import store from "../store";
import { ref } from "vue";
import { useRouter } from "vue-router";
import axiosInstance from "../axiosConfig/customAxios";

const router = useRouter();
const id = ref("");
const password = ref("");
const errors = ref([]);

async function login() {
  // store.dispatch('login', {id: id.value, password: password.value});
  // await axios
  //   .post("http://localhost:8000/api/login", {
  //     id: id.value,
  //     password: password.value,
  //   })
  //   .then((response) => {
  //     console.log(response.data);
  //     store.dispatch("login", response.data);
  //     console.log(response.data.user);
  //     console.log(response.data.role);
  //     if (response.data.role == "student") {
  //       router.push("/students");
  //     } else if (response.data.role == "lecturer") {
  //       router.push("/lecturers");
  //     } else if (response.data.role == "admin") {
  //       router.push("/admin");
  //     }
  //   })
  //   .catch((error) => {
  //     console.log(error);
  //     return;
  //   });
  try {
    const response = await axiosInstance.post("/login", {
      id: id.value,
      password: password.value,
    });
    console.log(response.data);
    store.dispatch("login", response.data);
    console.log(response.data.user);
    console.log(response.data.role);
    if (response.data.role == "student") {
      router.push("/dashboard");
    } else if (response.data.role == "lecturer") {
      router.push("/dashboard");
    } else if (response.data.role == "admin") {
      router.push("/adminDashboard");
    }
  } catch (error) {
    console.log(error.response.data);
    errors.value = error.response.data;
    console.log("Error message: ", errors.value.message);
    return;
  }
}
</script>

<style scoped>
.left-login {
  --s: 100px; /* control the size */
  --c1: #f8b195;
  --c2: #355c7d;

  --_g: var(--c2) 6% 14%, var(--c1) 16% 24%, var(--c2) 26% 34%,
    var(--c1) 36% 44%, var(--c2) 46% 54%, var(--c1) 56% 64%, var(--c2) 66% 74%,
    var(--c1) 76% 84%, var(--c2) 86% 94%;
  background: radial-gradient(
      100% 100% at 100% 0,
      var(--c1) 4%,
      var(--_g),
      #0008 96%,
      #0000
    ),
    radial-gradient(
        100% 100% at 0 100%,
        #0000,
        #0008 4%,
        var(--_g),
        var(--c1) 96%
      )
      var(--c1);
  background-size: var(--s) var(--s);
}

.left-login {
  --s: 100px; /* control the size */
  --c1: #f8b195;
  --c2: #355c7d;

  --_g: var(--c2) 6% 14%, var(--c1) 16% 24%, var(--c2) 26% 34%,
    var(--c1) 36% 44%, var(--c2) 46% 54%, var(--c1) 56% 64%, var(--c2) 66% 74%,
    var(--c1) 76% 84%, var(--c2) 86% 94%;
  background: radial-gradient(
      100% 100% at 100% 0,
      var(--c1) 4%,
      var(--_g),
      #0008 96%,
      #0000
    ),
    radial-gradient(
        100% 100% at 0 100%,
        #0000,
        #0008 4%,
        var(--_g),
        var(--c1) 96%
      )
      var(--c1);
  background-size: var(--s) var(--s);
}

.buttonstyle:hover {
  filter: drop-shadow(5px 5px 4px black);
}
</style>
