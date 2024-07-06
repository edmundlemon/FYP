<template>
  <div class="w-full h-full flex justify-center bg-gray-200 py-10 px-6">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-8">
      <h1 class="text-3xl font-bold mb-6 text-gray-900">
        Student Registration
      </h1>
      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-bold mb-2"
            >Student Name</label
          >
          <input
            type="text"
            v-model.number="form.name"
            id="name"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required
          />
          <div v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name[0] }}</div>
        </div>

        <div class="mb-4">
          <label for="id" class="block text-gray-700 font-bold mb-2"
            >Student ID</label
          >
          <input
            type="number"
            v-model.number="form.id"
            id="id"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            @input="handleInput"
            required
          />
          <div v-if="errors.id" class="text-red-500 text-xs mt-1">{{ errors.id[0] }}</div>
        </div>

        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-bold mb-2"
            >Email</label
          >
          <input
            type="email"
            v-model="form.email"
            id="email"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required
          />
          <div v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</div>
        </div>

        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-bold mb-2"
            >Password</label
          >
          <input
            type="password"
            v-model="form.password"
            id="password"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required
          />
          <div v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email[0] }}</div>
        </div>

        <div class="mb-4">
          <label for="password_confirmation" class="block text-gray-700 font-bold mb-2"
            >Password Confirmation</label
          >
          <input
            type="password"
            v-model="form.password_confirmation"
            id="password_confirmation"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required
          />
          <div v-if="errors.password" class="text-red-500 text-xs mt-1">{{ errors.password[0] }}</div>
        </div>

        <div class="flex space-x-4 mb-4">
          <div class="w-1/2">
            <label for="faculty" class="block text-gray-700 font-bold mb-2"
              >Faculty</label
            >
            <select
              v-model="form.faculty"
              id="faculty"
              class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            >
              <option value="" disabled selected>Select Faculty</option>
              <option value="FCI">FCI</option>
              <option value="FOE">FOE</option>
              <option value="FCM">FCM</option>
              <option value="FCA">FCA</option>
            </select>
            <div v-if="errors.password_confirmation" class="text-red-500 text-xs mt-1">{{ errors.password_confirmation[0] }}</div>
          </div>

          <div class="w-1/2">
            <label for="program" class="block text-gray-700 font-bold mb-2"
              >Program</label
            >
            <select
              v-model="form.program"
              id="program"
              class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            >
              <option value="" disabled selected>Select Program</option>
              <option value="Diploma">Diploma</option>
              <option value="Degree">Degree</option>
              <option value="Foundation">Foundation</option>
              <option value="Master">Master</option>
            </select>
            <div v-if="errors.program" class="text-red-500 text-xs mt-1">{{ errors.program[0] }}</div>
          </div>
        </div>

        <div class="mb-4">
          <label for="photo" class="block text-gray-700 font-bold mb-2"
            >Photo</label
          >
          <input
            type="file"
            @change="handleFileUpload"
            id="photo"
            ref="profilepic"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          />
        </div>

        <div class="flex justify-end items-center space-x-4">
          <button
            type="submit"
            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white rounded-full py-2 px-4 border border-blue-500 hover:border-transparent rounded"
          >
            Register
          </button>
          <button
            type="button"
            @click="resetForm"
            class="bg-transparent hover:bg-gray-500 text-gray-700 font-semibold hover:text-white rounded-full py-2 px-4 border border-gray-500 hover:border-transparent rounded"
          >
            Reset
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "../../axiosConfig/customAxios";

export default {
  name: "StudentRegistrationForm",
  data() {
    return {
      form: {
        name: "",
        id: "",
        email: "",
        password: "",
        password_confirmation: "",
        faculty: "",
        program: "",
        photo: null,
      },
      errors: {},
    };
  },
  methods: {
    async submitForm() {
      try {
        const formData = new FormData();
        formData.append("name", this.form.name);
        formData.append("id", this.form.id);
        formData.append("email", this.form.email);
        formData.append("password", this.form.password);
        formData.append("password_confirmation", this.form.password_confirmation);
        formData.append("faculty", this.form.faculty);
        formData.append("program", this.form.program);
        if (this.form.photo) {
          formData.append("photo", this.form.photo);
        }

        const response = await axios.post(
          "/register/student",
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );

        console.log("Form Submitted:", response.data);
        alert("Registration successful");
        this.resetForm();
      } catch (error) {
        this.errors = error.response.data.errors;
        console.error("Error submitting form:", error);
        alert("An error occurred during registration");
      }
    },
    resetForm() {
      this.form = {
        name: "",
        id: "",
        email: "",
        password: "",
        password_confirmation: "",
        faculty: "",
        program: "",
      };
      this.$refs.profilepic.value = null;
      this.errors = {};
    },
    handleFileUpload(event) {
      this.form.photo = event.target.files[0];
    },
  },
};
</script>

<style scoped>
/* Add any scoped styles here */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
