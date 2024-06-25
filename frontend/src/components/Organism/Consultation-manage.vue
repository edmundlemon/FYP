<template>
  <div class="flex flex-row mt-5 ml-2">
    <LecturerConsultationSidebar class="" @ClickedOption="ClickedOption" :currentpage="page"  />
    <!-- Your HTML code here -->
    <div class="h-full w-full">
      <PendingList
        :page="page"
        v-if="switchpage"
        @review-slot="inputReceivedSlot"
      />

      <div
        v-if="reviewform"
        class="booking-container fixed top-0 left-0 w-full h-full bg-white bg-opacity-50 z-50 flex justify-center items-center"
      >
        <ReviewForm
          :slot="receivedslot"
          style="filter: drop-shadow(0px 4px 10px black)"
          @closeReviewForm="reviewform = !reviewform"
          @runtimeout="Set_Timeout()"
          class="rounded-xl border border-gray-600 border-2 fadein-animation"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import LecturerConsultationSidebar from "../Molecules/LecturerConsultationSidebar.vue";
import { ref } from "vue";
import PendingList from "../Atom/PendingList.vue";
import ReviewForm from "../Molecules/ReviewForm.vue";

let page = ref("Pending");
let switchpage = ref(true);
const receivedslot = ref({});
const reviewform = ref(false);
function ClickedOption(option) {
  Set_Timeout();
  page.value = option;
  
}

function Set_Timeout() {
  switchpage.value = false;
  setTimeout(() => {
    switchpage.value = true;
  }, 100);
}
function inputReceivedSlot(slot) {
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
