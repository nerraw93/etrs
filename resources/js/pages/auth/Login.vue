<template>

    <div class="login">
        <div class="logo">
            <img class="company-logo"
                 src="/images/logo.png">
        </div>
        <div class="content card">
            <header class="card-header">
                <p class="card-hearder-title">
                    Please login with your username and password.
                </p>
            </header>
            <div class="card-content">
                <form @submit.prevent="submit">
                    <b-field :type="{'is-danger': errors.has('username')}"
                             :message="errors.first('username')">
                        <b-input v-model="form.username"
                                 v-validate="rules.username"
                                 name="username"
                                 placeholder="Username"
                                 icon="account" />
                    </b-field>
                    <b-field :type="{'is-danger': errors.has('password')}"
                             :message="errors.first('password')">
                        <b-input v-model="form.password"
                                 v-validate="rules.password"
                                 name="password"
                                 type="password"
                                 placeholder="Password"
                                 icon="lock" />
                    </b-field>
                    <div class="form-actions">
                        <button class="btn btn-custom btn-primary" :disabled="isBusy">
                            {{isBusy ? 'Logging in' : 'Log In'}}
                        </button>
                    </div>
                </form>
            </div>
            <footer class="card-footer">
                To have an account, please contact Hi-Precision main office.
            </footer>
        </div>
        <footer class="footer">
            <div class="has-text-centered email">
                <a href="mailto:help@hi-precision.com.ph"
                   target="_top">Email help@hi-precision.com.ph for help</a>
                <div class="copyright">
                    Copyright © 2016 Hi-Precision Diagnostics
                </div>
            </div>
        </footer>
    </div>

</template>
<script>

    import { mapActions } from 'vuex'
    import validationMixin from '@/mixins/validation'

    export default {
        mixins: [validationMixin],
        data() {
            return {
                form: {
                    username: null,
                    password: null
                },
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                isBusy: false,
            }
        },
        methods: {
            ...mapActions('auth', ['login']),
            async submit() {
                const result = await this.validateBeforeSubmit()
                if (result) {
                    const payload = {
                        username: this.form.username,
                        password: this.form.password
                    }
                    this.isBusy = true
                    try {
                        await this.login(payload)
                        await this.$router.push({ name: 'dashboard' })
                        this.isBusy = false
                    } catch (e) {
                        this.isBusy = false
                        if (e.errors) {
                            if (e.errors.username) {
                                e.errors.username.forEach(error => {
                                    this.$toast.open({
                                        message: error,
                                        type: 'is-danger'
                                    })
                                })
                            }
                        } else {
                            this.$toast.open({
                                message: e.message,
                                type: 'is-danger'
                            })
                        }
                    }
                }
            }
        }
    }

</script>
<style lang="scss" scoped>

    @import '../../../sass/pages/auth/login.scss';

</style>
