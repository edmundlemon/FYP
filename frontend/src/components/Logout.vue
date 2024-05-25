<template>
  <div>
	<a @click="logout">Logout</a>
  </div>
</template>

<script>
export default {
	  name: "Logout",
//   mounted() {
// 	localStorage.removeItem("token");
// 	this.$router.push({ name: "Login" });
//   },
  methods:{
	async logout(){
		console.log('Logging out');
		this.$store.commit('logout');
 	}		
  }
};

</script>

<style>

</style>