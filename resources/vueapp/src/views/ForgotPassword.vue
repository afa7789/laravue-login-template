<template>
	<div>
		<ForgotPasswordForm />
    </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import ForgotPasswordForm from '@/components/ForgotPasswordForm.vue'

@Component({
	components: {
		ForgotPasswordForm,
	}
})
export default class HelloWorld extends Vue {

}
</script>

<style>
</style>