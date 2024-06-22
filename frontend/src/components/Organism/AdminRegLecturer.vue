<template>
  <div class="w-full h-full flex justify-center bg-gray-200 py-10 px-6">
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-8">
      <h1 class="text-3xl font-bold mb-6 text-gray-900">
        Lecturer Registration
      </h1>
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-bold mb-2"
            >Lecturer Name</label
          >
          <input
            type="text"
            v-model.number="form.name"
            id="name"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required
          />
        </div>

        <div class="mb-4">
          <label for="id" class="block text-gray-700 font-bold mb-2"
            >Lecturer ID</label
          >
          <input
            type="number"
            v-model.number="form.id"
            id="id"
            class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            @input="handleInput"
            required
          />
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
          </div>

          <div class="w-1/2">
            <label for="office" class="block text-gray-700 font-bold mb-2"
              >Office</label
            >
            <input
              type="text"
              v-model="form.office"
              id="office"
              class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
              required
            />
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
export default {
  name: "LecturerRegistrationForm",
  data() {
    return {
      form: {
        name: "",
        id: "MU",
        email: "",
        faculty: "",
        program: "",
        photo: null,
      },
    };
  },
  methods: {
    async submitForm() {
      try {
        const formData = new FormData();
        formData.append("name", this.form.name);
        formData.append("id", this.form.id);
        formData.append("email", this.form.email);
        formData.append("faculty", this.form.faculty);
        formData.append("office", this.form.office);
        if (this.form.photo) {
          formData.append("photo", this.form.photo);
        }

        const response = await axios.post(
          "https://your-api-endpoint.com/register",
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
        console.error("Error submitting form:", error);
        alert("An error occurred during registration");
      }
    },
    resetForm() {
      this.form = {
        name: "",
        id: "",
        email: "",
        faculty: "",
        program: "",
        photo: null,
      };
    },
    handleFileUpload(event) {
      this.form.photo = event.target.files[0];
    },
    handleInput(event) {
      const inputValue = event.target.value;
      if (inputValue.startsWith("MU")) {
        this.form.id = inputValue.slice(2);
      } else {
        this.form.id = inputValue;
      }
    },
  },
};
</script>

<style scoped>
/* Add any scoped styles here */


</style>