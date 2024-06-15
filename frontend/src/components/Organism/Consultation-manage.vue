<template>
  <div class="flex flex-row mt-5 ml-5">
    <LecturerConsultationSidebar class="" @ClickedOption="ClickedOption" />
    <!-- Your HTML code here -->
    <div class="h-full w-full">
      <PendingList :page="page" v-if="switchpage" />
    </div>
  </div>
</template>SELECT * FROM consultation_slots WHERE date < CURDATE() OR status IN ('Approved', 'Lecturer Reschedule Approved', 'Rejected');


<script setup>
import axiosInstance from "../../axiosConfig/customAxios";
import LecturerConsultationSidebar from "../Molecules/LecturerConsultationSidebar.vue";
import { ref } from "vue";
import PendingList from "../Atom/PendingList.vue";

let page = ref("Pending");
let switchpage = ref(true);

function ClickedOption(option) {
  switchpage.value = false;
  page.value = option;
  setTimeout(() => {
    switchpage.value = true;
  }, 200);
}
</script>

<style scoped>
/* Your component-specific styles here */
</style>
