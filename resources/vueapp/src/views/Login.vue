<template>
	<div>
		<LoginForm />
		<button v-on:click=click >teste</button>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";

import LoginForm from '@/components/LoginForm.vue'

// interface States {
// 	[index: string]: boolean;
// }

@Component({
	components: {
		LoginForm,
	}
})
export default class HelloWorld extends Vue {
	click(){
		console.log("teste1",process.env.VUE_APP_PORT);
		console.log("teste2",process.env.VUE_APP_BACKEND_URL);

	}
}
</script>

<style>
</style>