<template>
    <b-button type="is-success"
        :loading="isSendResetPasswordInProgress"
        @click="sendResetPassword(user.email)">
      Send Reset Password
    </b-button>
</template>
<script>
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
    /**
     * Mixins
     * @type {Array}
     */
    mixins: [
        ErrorBagMixin,
    ],

    components: {

    },

    props: {
        user: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            isSendResetPasswordInProgress: false,
        }
    },

    methods: {
        sendResetPassword(email)
        {
            this.isSendResetPasswordInProgress = true;

            http.postJSON(`/api/auth/reset/password/send`, {email})
                .then(({data}) => {
                    this.isSendResetPasswordInProgress = false;
                    this.successToast(data.message)
                })
                .catch(error => {
                    this.isSendResetPasswordInProgress = false;
                    this.catchError(error)
                });

        },
    }
}
</script>
