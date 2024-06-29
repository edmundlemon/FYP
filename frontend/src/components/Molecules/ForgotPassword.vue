<template>
	<div>
		<form v-if="!requestSuccess" @submit.prevent="requestOTP">
			<label for="id">ID</label>
			<input type="text" id="id" name="id" v-model="id" required>
			<button type="submit">Submit</button>
		</form>
		<form v-if="requestSuccess" @submit.prevent="validateOTP">
			<label for="otp">OTP</label>
			<input type="text" id="otp" name="otp" v-model="otp" required>
			<label for="password">Password</label>
			<input type="password" id="password" name="password" v-model="password" required>
			<button type="submit">Submit</button>
		</form>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import axios from '../../axiosConfig/customAxios';
import routes from '../../router/routes';

const id = ref('');
const requestSuccess = ref(false);
const otp = ref('');
const password = ref('');

const requestOTP = () => {
	// API call to request OTP
	axios.post('/forgot-password', { id: id.value })
	.then((response) => {
		if (response.status === 200) {
			console.log(response.status);
			requestSuccess.value = true;
		}
	})
	.catch((error) => {
		console.log(error.response.data);
	})
}

const validateOTP = () => {
	// API call to validate OTP
	axios.post('/validate-otp', { id: id.value, otp: otp.value, password: password.value }).then((response) => {
		if (response.status === 200) {
			// Redirect to reset password page
			routes.push('/')
		}
	});
}

</script>

<style></style>