<template>
	<div class="flex flex-col items-center justify-center border border-gray-400 p-4 w-full">
		<a :href="'/lecturer/' + lecturer.id"><img :src="lecturer.photo" alt="Descriptive Alt Text" class="max-h-40 object-contain"></a>
		<div class="flex flex-col items-center justify-center">
			<a :href="'/lecturer/' + lecturer.id"><h1 class="text-4xl font-bold my-1.5">{{lecturer.name}}</h1></a>
			<a :href="'mailto:'+ lecturer.email"><p class="text-lg my-1.5">{{lecturer.email}}</p></a>
			<p class="text-lg my-1.5">{{lecturer.id}}</p>
		</div>
        
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