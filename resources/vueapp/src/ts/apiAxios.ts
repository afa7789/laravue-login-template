import axios from 'axios';

import { URL } from '@/ts/constants.ts';
// import { navigate } from '../Routes/RootNavigation';
// theFileYouDeclaredTheCustomConfigIn.ts

declare module 'axios' {
    export interface AxiosRequestConfig {
        handlerEnabled?: boolean;
    }
}

const apiAxios = axios.create({
    baseURL: URL,
    handlerEnabled: true,
});

apiAxios.interceptors.request.use(
    // console.log(`REQ: ${req.method} ${req.url}`);
    config => {
        const token = localStorage.getItem('authToken');
        if (token) {
            config.headers['Authorization'] = 'Bearer ' + token;
        }
        // config.headers['Content-Type'] = 'application/json';
        return config;
    }
);

apiAxios.interceptors.response.use(
    function (response) {
        return response;
    },
    function (error) {
        // Any status codes that falls outside the range of 2xx cause this function to trigger
        // Do something with response error
        console.log('Error', error.response.data);
        const { status } = error.response;
        console.log('Resposta Interceptor Error Status', status);
        if (status === 500 || status === 504) {
            alert("status 500")
        }
        return error;
    },
);

export default apiAxios;
