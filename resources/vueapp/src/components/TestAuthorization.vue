<template>
	<div>
        <p> {{ token }} </p>
        <button v-on:click="getUserData"> test authorization </button> <br/>
        <p> {{user}} </p>
	</div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
import store from "@/store";

@Component
export default class TestAuthorization extends Vue {
	token = localStorage.getItem('authToken');
    public user = "";

    /**
     * On Create
     */
    onCreate(){
		this.token = localStorage.getItem('authToken');
    }
    
    /**
     * @author Arthur
     * request a dispatch from the store to get User Data
     * and put on the screen
     */
    getUserData (){
        store.dispatch('getUserData',{}).then( (response)=>{
            // console.log("aqui",response;
            this.user = response;
        });  
        this.token = localStorage.getItem('authToken');
    }
}
</script>

<style scoped>
</style>