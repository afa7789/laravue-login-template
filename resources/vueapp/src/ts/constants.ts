const BASE_URL= process.env.VUE_APP_BACKEND_URL
const API = BASE_URL + "api/";

export const API_USER_DATA = API + "user";
export const API_LOGIN = API + "login";
export const API_REGISTER = API + "register";
export const API_LOGOUT = API + "logout";
export const API_RESEND = API + "resend";
export const API_VERIFY = API + "verify";
export const API_PASSWORD_REQUEST = API + "password/request";
export const API_PASSWORD_RESET = API + "password/reset";
export const API_PASSWORD_TOKEN = API + "password/token";
export const URL = BASE_URL;

export const routeAddress = {
    register : "/register", 
    login : "/",
    about : "/about",
    forgotPassword: "/forgot_password",
    verify: "verify"
};
