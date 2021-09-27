<template>
	<div class="about">
		<h1>This is an about page</h1>
		<button v-on:click="logout">logout</button>
		<TestAuthorization/>
	</div>
</template>
<script lang="ts">
import Vue from "vue";
import store from "@/store";
import router from "@/router";
import TestAuthorization from "@/components/TestAuthorization.vue";

export default Vue.extend({
	components: {
		TestAuthorization,
	},
	data() {
		return {
			token: localStorage.getItem("authToken"),
		};
	},
	methods: {
		/**
		 * @author Arthur
		 * just request a dispatch from the store to logout
		 */
		logout() {
			store.dispatch("sendLogoutRequest").then(function () {
				// console.log("função está logado",store.getters.isLoggedIn);
				// console.log("token",localStorage.getItem("token"));
				// console.log("data",store.getters.userDataGet);
				// router.push('/');
			});
		},
	},
});
</script>