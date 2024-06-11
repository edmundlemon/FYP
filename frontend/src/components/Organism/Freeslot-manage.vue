<template>
  <div class="flex justify-center">
    <div class="w-10/12 bg-gray-200">asdasd
        {{ store.state.user }}
      <!-- Your component content goes here --><EditFreeSlot :text="'Current Free Slots'" :lecturerId="store.state.user.data.id" />
       <FreeSlotForm></FreeSlotForm>
    </div>
  </div>
</template>

<script setup>
import EditFreeSlot from '../Molecules/Edit-FreeSlot.vue';
import FreeSlotForm from '../Molecules/FreeSlotForm.vue';
import store from '../../store';
import { onMounted } from 'vue';
import axiosInstance from '../../axiosConfig/customAxios';

console.log(store.state.user.data.id);

</script>

<style scoped>
/* Your component styles go here */
</style>
