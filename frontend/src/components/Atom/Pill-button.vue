<template>
        <button
          class="buttonstyle shadow-2xl w-fit-content bg-gray-900 rounded-full px-5 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-white hover:text-black transition-all duration-300 ease-in-out min-w-max"
          type="button"
        >
        
          {{ text }}
        </button>
</template>

<script>
export default {
    props: {
        text: String,
    }
}
</script>

<style scoped>
.buttonstyle:hover {
  filter: drop-shadow(5px 5px 4px black);
}
</style>