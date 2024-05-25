<template>
	<div class="flex items-center justify-center border border-gray-400 p-4">
		<div class="flex flex-col items-center justify-center">
			<h1 class="text-4xl font-bold my-1.5">{{lecturer.name}}</h1>
			<p class="text-lg my-1.5">{{lecturer.email}}</p>
			<p class="text-lg my-1.5">{{lecturer.id}}</p>
		</div>
        <img :src="lecturer.photo" alt="Descriptive Alt Text" class="max-h-40 object-contain">
    </div>
</template>

<script setup>
import { defineProps, onMounted } from 'vue';

const props = defineProps({
  lecturer:{
	type: Object,
	required: true
	},
});

</script>

<style>

</style>