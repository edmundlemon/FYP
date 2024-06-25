<template>
  <div>
    <div
      :id="slot.id"
      class="card border p-10 m-2 min-h-[20vw] w-[15vw] mt-5 relative rounded-lg shadow-md bg-[#fffffc]"
    >
      <div
        v-if="store.state.role === 'admin'"
        class="absolute w-4 h-4 top-2 right-2"
      >
        <img
          @click.prevent="deleteReview"
          src="../../assets/delete.png"
          alt="delete"
        />
      </div>
      <div class="card-body">
        <a
          :href="
            props.role === 'student'
              ? '/lecturer/' + lecturer.id
              : '/student/' + student.id
          "
          ><img
            :src="props.role === 'student' ? lecturer.photo : student.photo"
            class="rounded-full w-20 h-20 mb-4 shadow-xl"
            alt=""
        /></a>
        {{ rating }}
        <a
          :href="
            props.role === 'student'
              ? '/lecturer/' + lecturer.id
              : '/student/' + student.id
          "
          ><h1 class="p-1.5">
            {{ props.role === "student" ? lecturer.name : student.name }}
          </h1></a
        >
        <StarRating :rating="slot.rating" class="" />

        <h5 class="card-title w-full p-2 mt-2">{{ slot.comment }}</h5>

        <p class="card-text">{{ slot.review }}</p>

        <div
          class="card-subtitle mb-2 text-light text-xs absolute bottom-0 right-3"
        >
          <div>Review made on,</div>
          <h6>
            {{ formatDate(slot.created_at) }}
          </h6>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted, ref, defineEmits } from "vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import StarRating from "./StarRating.vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

const emit = defineEmits(["refresh"]);
const lecturer = ref({});
const student = ref({});
function formatDate(date) {
  return dayjs(date).format("dddd, MMMM D, YYYY");
}
const props = defineProps({
  slot: {
    type: Object,
    required: true,
  },
  role: "student",
});

onMounted(() => {
  axiosInstance
    .get(`/view/lecturer/${props.slot.lecturer_id}`)
    .then((response) => {
      lecturer.value = response.data.lecturer;
      console.log(response.data);
    })
    .catch((error) => {
      console.log(error);
    });

  axiosInstance
    .get(`/view/student/${props.slot.student_id}`)
    .then((response) => {
      student.value = response.data.student;
      console.log(response.data.student);
    })
    .catch((error) => {
      console.log(error);
    });
});

function deleteReview() {
  if (confirm("Are you sure you want to delete this review?")) {
    axiosInstance
      .delete(`/delete/review/${props.slot.id}`)
      .then((response) => {
        console.log(response.data);
        document.getElementById(props.slot.id).remove();
      })
      .catch((error) => {
        console.log(error);
      });
  }
}
</script>
