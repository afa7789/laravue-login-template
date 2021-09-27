// import axios from "axios";
import apiAxios from "@/ts/apiAxios.ts";
import * as URLs from "@/ts/constants";
import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators';
import router from "@/router";
import { routeAddress } from '@/ts/constants.ts';

const axios = apiAxios;
@Module
class Auth extends VuexModule {
	private userData: any = null;
	/*
		userData Example:
		"user": {
			"id": 2,
			"name": "Demo",
			"email": "demo@demo.com",
			"email_verified_at": null,
			"created_at": "2020-12-10T16:59:18.000000Z",
			"updated_at": "2020-12-10T16:59:18.000000Z"
		}
	*/

	/**
	 * @author Arthur F. Abeilice
	 * return entirely the userData
	 */
	get userDataGet(): any {
		return this.userData;
	}

	/**
	 * @author Arthur F. Abeilice
	 * return the user email
	 */
	get userEmail(): any {
		return this.userData.email;
	}

	/**
	 * @author Arthur F. Abeilice
	 * return the user name
	 */
	get userName(): any {
		return this.userData.email;
	}

	/**
	 * @author Arthur F. Abeilice
	 * return the state if there is a user logged in or not.
	 */
	get isLoggedIn(): boolean {
		return this.userData == null ? false : true;
	}

	/**
	 * Receive a Object Data Object from the backend and place it on the state
	 * @param user
	 */
	@Mutation
	setUserData(user: any) {
		this.userData = user;
	}

	/**
	 * @author Arthur F. Abeilice
	 * getUserData from the backend, this is needed in case of exiting without logout 
	 * so we fetch again user data based on it's token from the laravel backend.
	 */
	@Action
	getUserData(){

		const token = localStorage.getItem('authToken');
		return axios.get(URLs.API_USER_DATA).then((response) => {
			this.context.commit("setUserData", response.data);
			return response.data;
		}).catch(() => {
			localStorage.removeItem("authToken");
		});
	}
	
	/**
	 * @author Arthur F. Abeilice
	 * Send a login request to backend.
	 * @param data object {
	 * 	email: string,
	 * 	password: string
	 * }
	 */
	@Action
	sendLoginRequest(data: object) {
		return axios
				.post(URLs.API_LOGIN, data)
				.then(response => {
					console.log("response",response);
					if(response.data.status == true){
						this.context.commit("setUserData", response.data.user);
						localStorage.setItem("authToken", response.data.token);
						// router.push(routes.profile);
						router.push(routeAddress.about); // No need to return because it will change screen
						return response.data;
					}else{
						console.log("oi",response);
						return response.data;
					}
				}).catch(error =>{
					console.log("error",error);
					return error.response;
				});
	}

	/**
	 * @author Arthur F. Abeilice
	 * Send a register request to the backend.
	 * @param data object {
	 * 	email: string,
	 * 	name: string,
	 * 	password: string | same,
	 * 	password_confirmation: string | same,
	 * }
 	 */
	@Action
	sendRegisterRequest(data: object) {
		return axios
			.post(URLs.API_REGISTER, data)
			.then(response => {
				this.context.commit("setUserData", response.data.user);
				localStorage.setItem("authToken", response.data.token);
				router.push(routeAddress.about); // No need to return because it will change screen
				return response.data;
			});
	}

	/**
	 * @author Arthur F. Abeilice
	 * Logout request, remove the auth token, set user to null, 
	 * remove permissions and delete token on laravel backend
	 */
	@Action
	sendLogoutRequest() {
		this.context.commit("setUserData", null);
		localStorage.removeItem("authToken");
		axios.get(URLs.API_LOGOUT);

		//TODO change this to the future login route
		router.push(routeAddress.login);
	}

	/**
	 * @author Arthur F. Abeilice
	 * Token Password request, send it to the backend
	 * this will return the token to reset a password,
	 * need this token to use the resetPasswordRequest
	 * @param data: object{
	 * 	email : string
	 * }
	 */
	@Action
	getResetTokenRequest(data: object) {
		return axios.post(URLs.API_PASSWORD_TOKEN,data);
	}

	/**
	 * @author Arthur F. Abeilice
	 * Forgot Password request, send it to the backend
	 * this must send an email to the requirer to reset his password
	 * @param data: object{
	 * 	email : string
	 * }
	 */
	@Action
	forgotPasswordRequest(data: object) {
		return axios.post(URLs.API_PASSWORD_REQUEST,data);
	}

	/**
	 * @author Arthur F. Abeilice
	 * Forgot Password request, send it to the backend
	 * this must send an email to the requirer to reset his password
	 * @param data: object{
	 * 	email : string | email,
	 *  token : string,
	 *  password : string | same
	 *  password_confirmation : string | same
	 * }
	 */
	@Action
	resetPasswordRequest(data: object) {
		return axios.post(URLs.API_PASSWORD_RESET,data);
	}

	/**
	 * @author Arthur F. Abeilice
	 * TODO & test
	 */
	@Action
	sendVerifyResendRequest() {
		return axios.get(URLs.API_RESEND);
	}

	/**
	 * @author Arthur F. Abeilice
	 * @param hash 
	 * TODO & test
	 */
	@Action
	sendVerifyRequest(hash: string) {
		return axios
			.get(URLs.API_VERIFY + hash)
			.then(() => {
				this.context.dispatch("getUserData");
			});
	}
}

export default Auth;