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
		<search-bar v-if="store.state.token"/>
		<div class="container mx-auto p-4">
			<div class="flex flex-row space-x-3">
				<upcoming-slot class="bg-white p-4 shadow rounded flex-1"/>
				<approved-slot class="bg-white p-4 shadow rounded flex-1"/>
				<div class="flex flex-col flex-1">
					<pending-slot class="bg-white p-4 shadow rounded flex-1"/>
					<past-slot class="bg-white p-4 shadow rounded flex-1"/>
				</div>
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
import ApprovedSlot from '../components/ApprovedSlot.vue'
import PendingSlot from '../components/PendingSlot.vue'
import PastSlot from '../components/PastSlot.vue'
import SearchBar from '../components/SearchBar.vue'


const user = store.state.user.data
const token = store.state.user.token
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

onMounted(() => {

})
</script>

<style>

</style>