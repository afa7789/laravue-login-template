<template>
	<div>
		<h1>{{$t("login.title")}}</h1>
		<button v-on:click="()=>$router.push(routes.register)"> {{$t('buttons.register')}} </button>
		<p style="color:red;white-space:pre-wrap"> {{message}} </p>
		<input @keyup.enter="login" type="email" :placeholder="$t('placeholders.email')" v-model="user.username" /> <br/>
		<input @keyup.enter="login" type="password" :placeholder="$t('placeholders.password')" v-model="user.password" /> <br/><br/>
		<button v-on:click="login"> {{$t('buttons.login')}} </button><br />
		<button  v-on:click="()=>$router.push(routes.forgot)"> {{$t('buttons.forgot_password')}} </button><br />
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import store from "@/store";
import { routeAddress } from '@/ts/constants.ts';

@Component({

})
export default class LoginForm extends Vue {
	private user: any = { username: "", password: "" };
	// private loading = false;
	private message = "";
	private routes: any = {
		register : routeAddress.register,
		forgot: routeAddress.forgotPassword
    }

	
	/**
	 * @author Arthur F. Abeilice
	 * Login calling the vuex in store folder auth functions.
	 *
	 */
	login() {
		this.message ="";
		store.dispatch('sendLoginRequest',{email:this.user.username,password:this.user.password})
			.then((response)=>{	
				//TODO check this messages
				if (response['message'])
					response.message.forEach( this.errorMessageBuilder );
			}).catch(error => {
				console.log("error2",error);
				if (error['message'])
					error.message.forEach( this.errorMessageBuilder );
			});
	}

	errorMessageBuilder(element, index, array){
		this.message += element + " \n";
	}
	
}
</script>

<style scoped>
</style>