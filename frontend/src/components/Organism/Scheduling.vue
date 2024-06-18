<template>
  <SchedulingSlotView @edit-slot="setRescheduleSlot" />

  <div
    v-if="edit"
    class="booking-container fixed top-0 left-0 w-full h-full bg-white bg-opacity-50 z-50 flex justify-center items-center"
  >
    <RescheduleForm
      class="border border-gray-600 rounded-xl border-2 fadein-animation"
      style="filter: drop-shadow(0px 4px 10px black)"
      :booking="rescheduleSlot"
      @closeRescheduleForm="reloadpage"
    />
  </div>
</template>

<script setup>
import SchedulingSlotView from "../Molecules/SchedulingSlotView.vue";
import store from "../../store";
import axiosInstance from "../../axiosConfig/customAxios";
import RescheduleForm from "../Molecules/RescheduleForm.vue";
import { ref } from "vue";

let edit = ref(false);
let rescheduleSlot = ref();

function setRescheduleSlot(slot) {
  rescheduleSlot.value = slot;
  edit.value = true;
}

function reloadpage() {
  location.reload();
}

</script>
