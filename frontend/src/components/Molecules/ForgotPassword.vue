<template>
  <div class="wrapper h-screen bg-gray-200 flex justify-center items-center load-in-animation">
    <div
      class="flex-container w-3/12 h-5/6 flex flex-col justify-center items-center bg-gray-100 p-2 rounded-xl bg-white"
      style="filter: drop-shadow(15px 10px 20px black)"
    >
      <div
        class="w-full h-4/6 text-center content-center flex flex-col items-center space-y-8 pt-8 border-x border-t rounded-t-lg bg-gray-100"
      >
        <div class="rounded-full shadow-lg p-5">
          <img
            :src="
              requestSuccess ? 'src/assets/otp.png' : 'src/assets/forgot.png'
            "
            :alt="requestSuccess ? 'OTP Request' : 'Forgot Password'"
            class="h-24 w-auto"
          />
        </div>
        <h1 class="text-5xl font-light">
          {{ requestSuccess ? "OTP Request" : "Forgot Password" }}
        </h1>
      </div>
      <div
        class="h-full w-full flex justify-center border-x border-b rounded-b-lg bg-gray-100"
      >
        <form
          v-if="!requestSuccess"
          @submit.prevent="requestOTP"
          class="flex flex-col w-full mx-8 fadein-animation"
        >
          <div class="h-20">
            <div class="flex flex-col">
              <label class="text-xl" for="id">ID</label>
              <input
                type="text"
                id="id"
                name="id"
                v-model="id"
                required
                class="border border-gray-300 rounded-mdtransition duration-300 ease-in-out block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6"
              />
            </div>
            <label
              v-if="errors.message"
              class="text-red-500 text-xs w-full text-center"
              >{{ errors.message }}
            </label>
          </div>
          <button
            type="submit"
            class="mt-5 flex items-center justify-center text-white bg-gray-900 font-bold py-2 px-4 rounded mt-2 shadow-sm transition-all duration-300 ease-in-out"
            :class="
              loader
                ? 'cursor-not-allowed'
                : 'buttonstyle cursor-pointer hover:bg-white hover:text-black hover:ring-1 hover:ring-gray-300'
            "
          >
            <div v-if="!loader">Submit</div>
            <div v-else class="loader2 h-full p-2 fade-in-animation"></div>
          </button>
          <button
            type="button"
            @click="
              () => {
                routes.push('/login');
              }
            "
            class="buttonstyle hover:bg-white hover:text-black text-white bg-gray-900 hover:ring-1 hover:ring-gray-300 font-bold py-2 px-4 rounded mt-2 shadow-sm transition-all duration-300 ease-in-out"
          >
            Cancel
          </button>
        </form>
        <form
          v-else
          @submit.prevent="validateOTP"
          class="flex flex-col w-full mx-8 space-y-5 fadein-animation"
        >
          <div class="flex flex-col w-full">
            <label for="otp">OTP</label>
            <input
              type="text"
              id="otp"
              name="otp"
              v-model="otp"
              required
              class="border border-gray-300 rounded-mdtransition duration-300 ease-in-out block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6"
            />
          </div>
          <div class="flex flex-col w-full h-20">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              v-model="password"
              required
              class="border border-gray-300 rounded-mdtransition duration-300 ease-in-out block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6"
            />
            <label
              v-if="errors.message"
              class="text-red-500 mt-3 text-xs text-center"
              >{{ errors.message }}</label
            >
          </div>

          <button
            type="submit"
            class="buttonstyle hover:bg-white hover:text-black text-white bg-gray-900 hover:ring-1 hover:ring-gray-300 font-bold py-2 px-4 rounded mt-2 shadow-sm transition-all duration-300 ease-in-out"
          >
            Submit
          </button>
          <button
            type="button"
            @click="
              () => {
                routes.push('/login');
              }
            "
            class="buttonstyle hover:bg-white hover:text-black text-white bg-gray-900 hover:ring-1 hover:ring-gray-300 font-bold py-2 px-4 rounded mt-2 shadow-sm transition-all duration-300 ease-in-out"
          >
            Cancel
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "../../axiosConfig/customAxios";
import routes from "../../router/routes";

const id = ref("");
const requestSuccess = ref(false);
const otp = ref("");
const password = ref("");
const errors = ref({});
const loader = ref(false);

const requestOTP = () => {
  // API call to request OTP
  loader.value = true;
  axios
    .post("/forgot-password", { id: id.value })
    .then((response) => {
      if (response.status === 200) {
        console.log(response.status);
        requestSuccess.value = true;
        loader.value = false;
        errors.value = {};
      }
    })
    .catch((error) => {
      console.log(error.response.data);
      errors.value = error.response.data;
      loader.value = false;
    });
};

const validateOTP = () => {
  // API call to validate OTP
  axios
    .post("/validate-otp", {
      id: id.value,
      otp: otp.value,
      password: password.value,
    })
    .then((response) => {
      if (response.data.code === 200) {
        // Redirect to reset password page
        alert("Password reset successfully");
        routes.push("/");
      } else {
        console.log(response.data);
        errors.value = response.data;
      }
    })
    .catch((error) => {
      console.log(error.response.data);
      errors.value = error.response.data;
    });
  // .then((response) => {
  //   if (response.status === 200) {
  //     // Redirect to reset password page
  //     routes.push("/");
  //   }
  // });
};
</script>

<style scoped>
.buttonstyle:hover {
  filter: drop-shadow(5px 5px 4px black);
}

/* HTML: <div class="loader"></div> */
.loader2 {
  width: 20px;
  aspect-ratio: 1;
  border-radius: 50%;
  border: 4px solid;
  border-color: #ffffff #ffffff00;
  animation: l1 1s infinite;
}
@keyframes l1 {
  to {
    transform: rotate(0.5turn);
  }
}
</style>
