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
      <h2 class="text-3xl font-bold text-white mb-4">Edit User Details</h2>
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
              <button
                class="text-white absolute left-[50%] top-[50%] hidden group-hover:flex flex-col rounded-xl border-gray-400"
                style="transform: translate(-50%, -50%)"
                @click="form.photo = null"
              >
                <img
                  src="../../assets/close.png"
                  alt=""
                  class="icons h-8 w-8"
                />
              </button>
            </div>
          </div>
          <!-- If the photo is null -->
          <img
            v-else-if="form.photo == null"
            :src="namelink"
            alt="Profile Picture"
            class="w-24 rounded-full shadow-xl ring-2 ring-gray-300 mt-5"
          />
          <img
            v-else
            :src="imageUrl"
            alt="Profile Picture"
            class="w-24 rounded-full shadow-xl ring-2 ring-gray-300 mt-5"
          />
        </div>
        
        <div class="mb-4">
          <label for="photo" class="block text-sm font-bold text-white"
            >Photo</label
          >
          <div class="flex flex-row space-x-2">
            <input
              type="file"
              id="photo"
              class="mt-1 p-2 w-full border border-gray-300 rounded-md bg-white"
              @change="onFileChange"
              ref="profilepic"
            />
            <PillButton
              @click="resetphoto"
              text="Reset"
              type="1"
              class="ring-2 ring-white"
              >Reset</PillButton
            >
          </div>
        </div>

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
          <label v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</label>
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
const form = ref({});
const namelink = ref("");
const profilepic = ref(null);
const photo = store.state.user.data.photo;
const errors = ref({});
onMounted(() => {
  form.value = store.state.user.data;
  namelink.value =
    "https://ui-avatars.com/api/?name=" +
    store.state.user.data.name.replace(/\s/g, "+") +
    "&color=7F9CF5&background=EBF4FF";
});

// # HEHE it is done try to test it if possible
const submitForm = () =>{
  const formData = new FormData();
  if (imageUrl.value != null) {
    formData.append("photo", document.getElementById('photo').files[0]);
    form.value.photo = imageUrl;
  } else if (form.value.photo == null) {
    console.log(namelink.value);
    formData.append("photo", namelink.value);
  }
  formData.append("email", form.value.email);
  
  if (store.state.role === "lecturer") {
    formData.append("office", form.value.office);
  }
  if (store.state.role === 'student') {
    axiosInstance
      .post(`/student/edit-details/${store.state.user.data.id}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
      .then((response) => {
        console.log(response.data);
        store.commit('setPhoto', response.data.photo);
        closeEdit();
      })
      .catch((error) => {
        console.log(error);
        errors.value = error.response.data.errors;
      });
  }
  if (store.state.role === 'lecturer') {
    axiosInstance
      .post(`/lecturer/edit-details/${store.state.user.data.id}`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
      .then((response) => {
        console.log(response.data);
        store.commit('setPhoto', response.data.photo);
        closeEdit();
      })
      .catch((error) => {
        console.log(error);
        errors.value = error.response.data.errors;
      });
  }
 
};

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
  form.value.photo = photo;
  profilepic.value.value = null;
};

const closeEdit = () => {
  emit('close-edit')
}
</script>
