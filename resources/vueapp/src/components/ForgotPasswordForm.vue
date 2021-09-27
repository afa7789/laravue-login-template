<template>
	<div>
		<button v-on:click="()=>$router.push(routes.login)"> {{$t('buttons.login')}} </button>
		<p style="color:red">{{message}}</p>
		<input @keyup.enter="forgot" required type="email" :placeholder="$t('placeholders.email')" v-model="user.email" /> <br />
		<button  v-on:click="forgot"> {{$t('buttons.forgot_password') }} </button>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import store from "@/store";
import { routeAddress } from '@/ts/constants.ts';
// {{$t('clientForm.ios')}}

@Component({

})
export default class ForgotPasswordForm extends Vue {
	private user: any = { email: "" };
	// private loading = false;
	private message = "";
	private routes: any = {
		login : routeAddress.login,
    }

	/**
	 * @author Arthur F. Abeilice
	 * Forgot my Password calling the vuex in store folder auth functions.
	 */
	forgot() {
		console.log(this.user.username);
		store.dispatch('sendLoginRequest',{email:this.user.username,password:this.user.password})
			.then((response)=>{	
				//TODO check this messages.
				if (response['message'])
					response.message.forEach( (element: string) =>{
						this.message += element + "\n";
					});
			});
	}
	
}
</script>

<style scoped>
</style>