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


const store = useStore()
const user = store.state.user.data

onMounted(() => {
	// const user = store.commit('getAll')
	console.log(store.state.user.data)
	// console.log(user)
})
</script>

<style>

</style>