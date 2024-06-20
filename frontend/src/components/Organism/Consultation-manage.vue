<template>
  <div class="flex flex-row mt-5 ml-2">
    <LecturerConsultationSidebar class="" @ClickedOption="ClickedOption" />
    <!-- Your HTML code here -->
    <div class="h-full w-full">
      <PendingList :page="page" v-if="switchpage" />
    </div>
  </div>

</template>

<script setup>
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

// onMounted(() => {
//   setTimeout(() => {
//     switchpage.value = true;
//   }, 100);
// });
</script>

<style scoped>
/* Your component-specific styles here */
</style>
