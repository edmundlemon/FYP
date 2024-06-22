<template>
<ReviewCards :reviewslots="slots" :setrole="store.state.role"/>
</template>

<script setup>
import { defineProps, onMounted, ref } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import ReviewCards from "../Molecules/ReviewCards.vue";
const slots = ref({});

onMounted(() => {
  if (store.state.role === "lecturer") {
    axiosInstance
      .get(`/rating/${store.state.user.data.id}`)
      .then((response) => {
        slots.value = response.data.reviews;
      })
      .catch((error) => {
        console.log(error);
      });
  } else {
    axiosInstance
      .get(`/student/reviews/${store.state.user.data.id}`)
      .then((response) => {
        slots.value = response.data.reviews;
        console.log(response.data.reviews);
      })
      .catch((error) => {
        console.log(error);
      });
  }
});


</script>