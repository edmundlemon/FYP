<template>
	<div class="flex justify-center items-center">
	  <div
		class="booking-form w-4/12 border border-black h-fit bg-gray-900 rounded-lg p-5 relative load-in-animation"
	  >
		<button
		  class="absolute w-3 h-3 top-3 right-3"
		  @click="$emit('close-edit')"
		>
		  <img src="../../assets/close.png" alt="" class="icons" />
		</button>
		<h2 class="text-3xl font-bold text-white mb-4">Edit My Password</h2>
		<form @submit.prevent="submitForm">
		  <!-- Profile Photo -->
		  <div class="flex items-center justify-center mb-4 mt-8">
			<div
			  v-if="form.photo != null && imageUrl == null"
			  class="relative group"
			>
			  <img
				:src="form.photo"
				alt="Profile Picture"
				class="w-24 rounded-full shadow-xl ring-2 ring-gray-300 cursor-pointer"
			  />
			  <div
				class="border absolute w-full h-full top-0 bg-white opacity-50 hidden group-hover:flex flex-col border-gray-400 rounded-full"
				title="Remove Photo"
			  >
			  </div>
			</div>
		  </div>
		  
		  <div class="mb-4">
			<label for="photo" class="block text-sm font-bold text-white"
			  >Password</label
			>
			<div class="flex flex-col space-x-2">
			  <input
				type="password"
				id="oldPassword"
				class="mt-1 p-2 w-full border border-gray-300 rounded-md bg-white"
				v-model="form.oldPassword"
			  />
			  <div v-if="errors.oldPassword" class="text-red-500 text-xs mt-1">{{ errors.oldPassword[0] }}</div>
			</div>
		  </div>
  
		  <div class="mb-4">
			<label for="password" class="block text-sm font-bold text-white"
			  >New Password</label
			>
			<input
			  type="password"
			  id="password"
			  v-model="form.password"
			  class="mt-1 p-2 w-full border border-gray-300 rounded-md"
			  required
			/>
			<div v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</div>
		  </div>
		  <div class="mb-4">
			<label for="password_confirmation" class="block text-sm font-bold text-white"
			  >New Password Confirmation</label
			>
			<input
			  type="password"
			  id="password_confirmation"
			  v-model="form.password_confirmation"
			  class="mt-1 p-2 w-full border border-gray-300 rounded-md"
			  required
			/>
		  </div>
  
		  <button
			type="submit"
			class="my-2 mt-5 text-white bg-blue-500 p-2 rounded-md w-full hover:bg-blue-400 transition-all duration-300 ease-in-out"
		  >
			Save
		  </button>
		</form>
	  </div>
	</div>
  </template>
  
  <script setup>
  import { ref, onMounted, defineEmits } from "vue";
  import axiosInstance from "../../axiosConfig/customAxios";
  import store from "../../store";
  import PillButton from "../Atom/Pill-button.vue";
  
  const emit = defineEmits(['close-edit'])
  const imageUrl = ref(null);
  const form = ref({
	oldPassword: "",
	password: "",
	password_confirmation: "",
  });
  const namelink = ref("");
  const profilepic = ref(null);
  const photo = store.state.user.data.photo;
  const errors = ref([]);
  onMounted(() => {
	form.value = store.state.user.data;
	namelink.value =
	  "https://ui-avatars.com/api/?name=" +
	  store.state.user.data.name.replace(/\s/g, "+") +
	  "&color=7F9CF5&background=EBF4FF";
  });
  
  const submitForm = () =>{
	axiosInstance
	  .post("/auth/change-password", form.value)
	  .then((res) => {
		console.log(res.data.message);
		emit('close-edit', res.data.message)
	  })
	  .catch((err) => {
		console.log(err.response.data.errors);
		errors.value = err.response.data.errors;
	  });
  };
</script>