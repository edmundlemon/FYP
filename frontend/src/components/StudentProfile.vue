<template>
  <div>
    <h1>Student Profile</h1>
    <!-- Add your content here -->
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "../axiosConfig/customAxios";
import { onMounted } from "vue";
import store from "../store";
const lecturerData = ref([]);
const token = store.state.token;
axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
</script>

<script>
export default {
  name: "StudentProfile",
  props: ["user"],
  created() {
    let userId = this.$route.params.user;
    // Fetch the user data based on userId
  },

  methods: {
    async fetchLecturerData(userId) {
      const response = await axios
        .get(`/lecturers/${userId}`)
        .then((response) => {
          lecturerData.value = response.data;
          console.log(lecturerData.value);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  async mounted() {
    await fetchLecturerData(userId);
  },
};

// axios
//     .get("/lecturer/"+ userId, )
</script>

<style scoped>
/* Add your component styles here */
</style>
