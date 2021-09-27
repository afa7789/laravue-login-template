<template>
  <div class="verify">
    <div class="alert alert-danger" role="alert" v-if="error">
      {{ error }}
    </div>
    <h1 v-show="!error">Please wait..</h1>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import store from "@/store";

export default {
  props: ["hash"],

  data() {
    return {
      error: null
    };
  },

  mounted() {
    this.store.sendVerifyRequest(this.hash)
      .then(() => {
        this.$router.push("/");
      })
      .catch(error => {
        console.log(error.response);
        this.error = "Error verifying email";
      });
  },

};
</script>
