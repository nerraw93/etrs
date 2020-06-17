<template>
  <div class="container">
    <div class="newpass-content">
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="card card-default">
            <div class="card-header">
              New Password
            </div>
            <div class="card-body">
              <form
                autocomplete="off"
                method="post"
                @submit.prevent="submitResetPassword"
              >
                <div class="form-group">
                  <label for="email">Password</label>
                  <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    placeholder
                    required
                  >
                </div>
                <div class="form-group">
                  <label for="email">Confirm Password</label>
                  <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control"
                    placeholder
                    required
                  >
                </div>
                <button
                  type="submit"
                  class="btn btn-primary is-pulled-right"
                >
                  Update
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ErrorBagMixin from "@/mixins/ErrorBagMixin";

export default {

    mixins: [ErrorBagMixin],

    data() {
        return {
            form: {
                password: '',
                password_confirmation: '',
                token: this.$route.params.token,
                inProgress: false,
            }
        }
    },

    methods: {

        submitResetPassword()
        {
            this.form.inProgress = true;
            let form = this.form;

            http.postJSON(`/api/auth/reset/password`, form)
                .then(({data}) => {
                    this.form.inProgress = false;

                    this.successToast(data.message + "\n" + ' Please wait redirecting to login page.');
                    // Redirect user to login page.
                    setTimeout(() => {
                        this.$router.push({ name: 'login' });
                    }, 1500);

                })
                .catch((error) => {
                    this.catchError(error);
                    this.form.inProgress = false;
                });
        },

    },
};
</script>
<style lang="scss" scoped>
    @import "../../../sass/pages/auth/login.scss";
    .newpass-content {
        margin-top: 10%;
    }
</style>
