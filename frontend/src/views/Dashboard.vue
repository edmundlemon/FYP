<template>
	<div>
		<h1>Dashboard</h1>
		<table>
			<tr>
				<td>Username</td>
				<td>{{ user.name }}</td>
			</tr>
			<tr>
				<td>Email</td>
				<td>{{ user.email }}</td>
			</tr>
		</table>
	</div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useStore } from 'vuex'
import store from '../store'
import axios from 'axios'


const user = store.state.user.data
const token = store.state.user.token
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

onMounted(() => {

})
</script>

<style>

</style>