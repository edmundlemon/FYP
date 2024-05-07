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
// import { useStore } from 'vuex'
import store from '../store'


// const store = useStore()
// const user = store.state.user.data
// const token = store.state.user.token
// axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

onMounted(() => {
	// const user = store.commit('getAll')
	console.log(store.state.user.data)
	console.log(store.state.token);
	// console.log(user)
})
</script>

<style>

</style>