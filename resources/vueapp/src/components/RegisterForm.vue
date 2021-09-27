<template>
	<div>
        <button v-on:click="()=>$router.push(routes.login)"> {{$t('buttons.login')}} </button>
        <br/>
        <br/>
        {{ $t(message) }}
        <input @keyup.enter="register" required type="text" :placeholder="$t('placeholders.name')" v-model="user.name" /> <br/>
		<input @keyup.enter="register" required type="email" :placeholder="$t('placeholders.email')" v-model="user.username" /> <br/>
		<input @keyup.enter="register" required type="password" :placeholder="$t('placeholders.password')" v-model="user.password" /> <br/>
        <input @keyup.enter="register" required type="password" :placeholder="$t('placeholders.password_confirmation')" v-model="user.passwordConfirmation" /> <br/>
        <br />
		<button v-on:click="register"> {{$t('buttons.register')}} </button>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import store from "@/store";
import { routeAddress } from '@/ts/constants.ts';

@Component
export default class RegisterForm extends Vue {
	private user: any = { name: "",username: "", password: "",passwordConfirmation:"" };
    private message = "";
    private routes: any = {
        login : routeAddress.login
    }

	/**
	 * @author Arthur F. Abeilice
	 * Make a Register calling the vuex in store folder dispatch auth functions to register.
	 */
	async register() {
        if( this.user.name == "" ||  this.user.username == "" ||  this.user.password == "" || this.user.passwordConfirmation == "" ){
            if( this.user.password == this.user.passwordConfirmation){
                const result = await store
                    .dispatch('sendRegisterRequest',{
                        email:this.user.username,
                        password:this.user.password,
                        /* eslint-disable @typescript-eslint/camelcase */
                        password_confirmation:this.user.passwordConfirmation,
                        /* eslint:enable */
                        name:this.user.name
                    });
            }else{
                this.message = "error_messages.password_do_not_match";
            }
        }else{
            this.message = "error_messages.empty_fields"
        }
    }

}
</script>

<style scoped>
</style>