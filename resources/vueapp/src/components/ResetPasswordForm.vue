<template>
	<div>
		<p style="color:red">{{$t(message)}}</p>
		<input @keyup.enter="reset" required type="email" :placeholder="$t('placeholders.email')" v-model="user.email" /> <br />
        <input @keyup.enter="reset" required type="password" :placeholder="$t('placeholders.password')" v-model="user.password" /> <br />
        <input @keyup.enter="reset" required type="password" :placeholder="$t('placeholders.password_confirmation')" v-model="user.passwordConfirmation" /> <br />

		<button  v-on:click="reset"> Reset Password </button>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import store from "@/store";

// Still needs some improvement

@Component({

})
export default class ResetPasswordForm extends Vue {
    private user: any = { 
        email: "", 
        password: "",
        passwordConfirmation:"" 
    };
	private message = "";
	
	/**
	 * @author Arthur F. Abeilice
	 * Forgot my Password calling the vuex in store folder auth functions.
	 *
	 */
	reset() {
        if( this.user.password == this.user.passwordConfirmation){
            store.dispatch('getResetTokenRequest',{
                email:this.user.email
            }).then(
                response => {
                    store.dispatch('resetPasswordRequest',{
                        email:this.user.username,
                        password:this.user.password,
                        /* eslint-disable @typescript-eslint/camelcase */
                        password_confirmation:this.user.passwordConfirmation,
                        /* eslint:enable */
                        token: response.data
                    });
                });

        }else{
            this.message = "error_messages.password_do_not_match";
        }
    }
    	
}
</script>

<style scoped>
</style>