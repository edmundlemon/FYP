<template>
	<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">	
		<!-- <div class="bg-white p-4 shadow rounded"> -->
			<h3>{{ slot.date }}</h3>
			<div>{{ slot.start_time }}</div>
			<div>{{ slot.end_time }}</div>
			<h3 v-if="role === 'lecturer'">{{ slot.student.name }}</h3>
			<h3 v-else-if="role === 'student'">{{ slot.lecturer.name }}</h3>
		<!-- </div> -->
	</div>
</template>

<script setup>
import { defineProps, onMounted } from 'vue'
import store from '../store'

const role = store.state.role

const props = defineProps({
  slot:{
	type: Object,
	required: true
	},
});

onMounted(() => {
	console.log('Role => ', role);
	console.log('Slot => ', props.slot);
});
</script>

<style>

</style>