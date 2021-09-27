import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import ForgotPassword from '../views/ForgotPassword.vue';
import Verify from '../views/Verify.vue';
import { routeAddress } from '@/ts/constants.ts';

import store from "@/store";
import i18n from '@/i18n';

Vue.use(VueRouter)

// eslint-disable-next-line
const auth = (to:any, from:any, next:any) => {
	
	if( localStorage.getItem('authToken') ){
		store.dispatch('getUserData');
	}

    if ( store.getters.isLoggedIn ) {
		// Verificar permissão, ainda não existe o sistema de permissão.
		// Se a permissão não passar, mandar para página de profile.
		// (setar uma variavel no store para exibir mensagem de não ter priveligos necessários)
		// até então so verifica se está logado com auth funcionando.
		next();
	} else {
		alert( i18n.t("error_messages.login_need") );
		//TODO change this to the future login route
		next("/");
	}
};

const routes: Array<RouteConfig> = [
	{
		path: routeAddress.login,
		name: 'Login',
		component: Login
	},
	{
		path: routeAddress.about,
		name: 'About',
		beforeEnter: auth,
		// route level code-splitting
		// this generates a separate chunk (about.[hash].js) for this route
		// which is lazy-loaded when the route is visited.
		component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
	},
	{
		path: routeAddress.register,
		name: 'Register',
		component: Register
	},
	{
		path: routeAddress.forgotPassword,
		name: 'ForgotPassword',
		component: ForgotPassword
	},
	{
		path: routeAddress.verify,
		name: 'Verify',
		component: Verify
	}
]

const router = new VueRouter({
	routes
})

export default router
