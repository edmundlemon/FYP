<template>
  <div class="flex flex-row mt-5 ml-2">
    <LecturerConsultationSidebar class="" @ClickedOption="ClickedOption" />
    <!-- Your HTML code here -->
    <div class="h-full w-full">
      <PendingList :page="page" v-if="switchpage" @review-slot="inputReceivedSlot"/>
      <ReviewForm :slot="receivedslot" v-if="reviewform" @closeReviewForm="reviewform = !reviewform"/>
    </div>
  </div>
  
</template>

<script setup>
import LecturerConsultationSidebar from "../Molecules/LecturerConsultationSidebar.vue";
import { ref } from "vue";
import PendingList from "../Atom/PendingList.vue";
import ReviewForm from "../Molecules/ReviewForm.vue";

let page = ref("Completed");
let switchpage = ref(true);
const receivedslot = ref({});
const reviewform = ref(false);
function ClickedOption(option) {
  switchpage.value = false;
  page.value = option;
  setTimeout(() => {
    switchpage.value = true;
  }, 200);
}

function inputReceivedSlot(slot)
{
  receivedslot.value = slot;
  reviewform.value = true;
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
