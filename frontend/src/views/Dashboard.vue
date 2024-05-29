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
		<div class="container mx-auto p-4">
			<div class="flex flex-row space-x-3">
				<approved-slot class="bg-white p-4 shadow rounded flex-1"/>
				<UpcomingSlot class="bg-white p-4 shadow rounded flex-1"/>
				<pending-slot class="bg-white p-4 shadow rounded flex-1"/>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useStore } from 'vuex'
import store from '../store'
import axios from 'axios'
import UpcomingSlot from '../components/UpcomingSlot.vue'
import approvedSlot from '../components/ApprovedSlot.vue'
import pendingSlot from '../components/PendingSlot.vue'


const user = store.state.user.data
const token = store.state.user.token
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

onMounted(() => {

})
</script>

<style>

</style>