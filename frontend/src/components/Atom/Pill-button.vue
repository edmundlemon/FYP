<template>
        <button
          class="buttonstyle shadow-2xl w-fit-content rounded-full px-5 py-1.5 text-sm font-semibold leading-6 shadow-sm transition-all duration-300 ease-in-out min-w-max"
          type="button"
            :class="type == 1 ? 'hover:bg-white hover:text-black text-white bg-gray-900 hover:ring-1 hover:ring-gray-300' : type == 3  ? 'hover:bg-yellow-300 hover:ring-0 ring-1 ring-gray-300 hover:text-white text-black bg-gray-100' : 'hover:bg-green-400 hover:ring-0 ring-1 ring-gray-300 hover:text-white text-black bg-gray-100'"
        >
        
          {{ text }}
        </button>
</template>
<script setup>
import { onMounted, ref, defineProps } from 'vue';


onMounted(() => {
    console.log('Pill-button component is mounted');
});

const props = defineProps({
    text: String,
    type: Number,
    slotstatus: String,
});

</script>

<style scoped>
.buttonstyle:hover {
  filter: drop-shadow(5px 5px 4px black);
}
</style>