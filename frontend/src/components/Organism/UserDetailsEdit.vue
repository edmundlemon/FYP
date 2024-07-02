<template>
  <div class="flex justify-center items-center">
    <div
      class="booking-form w-4/12 border border-black h-fit bg-gray-900 rounded-lg p-5 relative"
    >
      <button class="absolute w-3 h-3 top-3 right-3" @click="$emit('close-edit')">
        <img src="../../assets/close.png" alt="" class="icons">
      </button>
      <h2 class="text-3xl font-bold text-white mb-4">Edit User Details</h2>
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label for="email" class="block text-sm font-bold text-white"
            >Email</label
          >
          <input
            type="email"
            id="email"
            v-model="form.email"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>
        <div class="mb-4" v-if="store.state.role === 'lecturer'">
          <label for="office" class="block text-sm font-bold text-white"
            >Office</label
          >
          <input
            type="text"
            id="office"
            v-model="form.office"
            class="mt-1 p-2 w-full border border-gray-300 rounded-md"
            required
          />
        </div>

        <!-- Profile Photo -->
        <div class="flex items-center justify-center mb-4">
          <img
            v-if="form.photo != null && imageUrl == null"
            :src="form.photo"
            alt="Profile Picture"
            class="w-24 rounded-full shadow-xl ring-2 ring-gray-300 mt-5"
          />

          <!-- If the photo is null -->
          <img
            v-else-if="form.photo == null && imageUrl == null"
            :src="
              'https://ui-avatars.com/api/?name=' +
              namelink +
              '&color=7F9CF5&background=EBF4FF'
            "
            alt="Profile Picture"
            class="w-24"
          />
          <img v-else :src="imageUrl" alt="Profile Picture" class="w-24" />
        </div>
        <div class="mb-4">
          <label for="photo" class="block text-sm font-bold text-white"
            >Photo</label
          >
          <div class="flex flex-row space-x-1">
            <input
              type="file"
              id="photo"
              class="mt-1 p-2 w-full border border-gray-300 rounded-md bg-white"
              required
              @change="onFileChange"
              ref="profilepic"
            />
            <PillButton
              @click="resetphoto"
              text="Reset"
              type="1"
              >Reset</PillButton
            >
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axiosInstance from "../../axiosConfig/customAxios";
import store from "../../store";
import PillButton from "../Atom/Pill-button.vue";

const imageUrl = ref(null);
const form = ref({});
const namelink = ref("");
const profilepic = ref(null);
onMounted(() => {
  form.value = store.state.user.data;
  namelink.value = store.state.user.data.name.replace(/\s/g, "+");
});

const onFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      imageUrl.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const resetphoto = () => {
  imageUrl.value = null;
  form.value = store.state.user.data;
  profilepic.value.value = null;
};
</script>
