import Vue from "vue";
import Vuex from "vuex";
import Auth from "./auth";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    errors: []
  },

  getters: {
    errors: state => state.errors
  },

  mutations: {
    setErrors(state, errors) {
      state.errors = errors;
    }
  },

  modules: {
    Auth
  }
});