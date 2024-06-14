<template>
  <div class="flex p-2"
  >
    <div
      class="bg-gray-100 p-4 shadow rounded w-full mt-5 drop-shadow-xl"
    >
      <h3>Booked Date: {{ slot.date }}</h3>
      <div class="flex flex-row gap-10 justify-between">
        <div>Start Time: <span class="ml-1 font-bold text-green-400 ">{{ slot.start_time }}</span></div>
        <div>End Time: <span class="ml-1 font-bold text-red-400 ">{{ slot.end_time }}</span></div>
      </div>
      <h3 class="flex justify-end mt-7" v-if="role === 'lecturer'">
        Booked by <a :href="'/student/'+ slot.student.id"><span class="ml-1 font-bold hover:opacity-70 transition-text duration-300">{{ slot.student.name }}</span></a>
      </h3>
      <h3 class="flex justify-end mt-7" v-else-if="role === 'student'">
        Consultation by <a :href="'/lecturer/'+ slot.lecturer.id"><span class="ml-1 font-bold hover:opacity-70 transition-text duration-300">{{ slot.lecturer.name }}</span></a>
      </h3>
      <pill-button
          @click.prevent="emitEvent"
          class="mt-3 w-[8vw]"
          text="Reschedule"
          v-if="slotType === 'approved'"
        />
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted, defineEmits } from "vue";
import store from "../../store";
import PillButton from "./Pill-button.vue";

const role = store.state.role;
const emit = defineEmits(['edit-slot']);

const props = defineProps({
  slot: {
    type: Object,
    required: true,
  },
  slotType:{
    type: String,
    required: false,
  }
});

const emitEvent = () => {
  const data = {slot: props.slot};
  emit('edit-slot', data)
}

onMounted(() => {
  console.log("Role => ", role);
  console.log("Slot => ", props.slot);
});
</script>

<style></style>
