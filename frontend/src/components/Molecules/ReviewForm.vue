<template>
	<div>
		<div class="flex-row">
			<!-- <div class="flex-col">
				<div>
					Name: {{ name }}
				</div>
			</div> -->
			<div class="flex-col">
				<label for="email">Rating</label>
				<div class="star-rating">
					<span v-for="star in 5" :key="star" @click="setRating(star)" @mouseover="hoverRating(star)"
						@mouseleave="resetHover">
						<i :class="['fa', star <= (hoveredRating || rating) ? 'fa-star' : 'fa-star-o']"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ref, watch } from 'vue';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';


// Define the props for the component
const props = defineProps({
	modelValue: {
		type: Number,
		default: 0
	}
});

// Local reactive state for rating and hovered rating
const rating = ref(props.modelValue);
const hoveredRating = ref(0);

// Emit the updated rating value
const emit = defineEmits(['update:modelValue']);

const setRating = (value) => {
	rating.value = value;
	console.log(value);
	// emit('update:modelValue', value);
};

const hoverRating = (value) => {
	hoveredRating.value = value;
};

const resetHover = () => {
	hoveredRating.value = 0;
};

// Watch for changes in the modelValue prop
watch(() => props.modelValue, (newValue) => {
	rating.value = newValue;
});
</script>

<style scope>
.star-rating {
	display: flex;
	cursor: pointer;
}

.star-rating .fa {
	font-size: 2em;
	margin: 0.1em;
	color: #ffd055;
}
</style>