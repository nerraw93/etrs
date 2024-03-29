<template>
  <div class="column portlet">
    <section class="add-staff">
      <div class="column">
        <div class="header-portlet">
          <h1 class="float-left">
            <b-icon icon="account-plus" />
            STAFF REGISTRATION
          </h1>
          <b-icon
            icon="close"
            class="float-right app-text-primary pointer"
            size="is-small"
            @click.native="$emit('hide')"
          />
        </div>
      </div>
      <form @submit.prevent="submit">
        <div class="column">
          <div class="columns">
            <div class="column">
              <b-field
                label="Email Address"
                :type="{'is-danger': errors.has('email')}"
                :message="errors.first('email')"
              >
                <b-input
                  v-model="form.email"
                  v-validate="rules.email"
                  name="email"
                  placeholder="Email"
                  icon="email"
                />
              </b-field>
            </div>
            <div class="column">
              <b-field
                label="Username"
                :type="{'is-danger': errors.has('username')}"
                :message="errors.first('username')"
              >
                <b-input
                  v-model="form.username"
                  v-validate="rules.username"
                  name="username"
                  placeholder="Username"
                  icon="account"
                />
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column is-half">
              <b-field
                label="First Name"
                :type="{'is-danger': errors.has('first-name')}"
                :message="errors.first('first-name')"
                expanded
              >
                <b-input
                  v-model="form.first_name"
                  v-validate="rules.firstName"
                  name="first-name"
                  placeholder="First Name"
                  icon="account-card-details"
                />
              </b-field>
            </div>
            <div class="column is-half">
              <b-field
                label="Last Name"
                :type="{'is-danger': errors.has('last-name')}"
                :message="errors.first('last-name')"
                expanded
              >
                <b-input
                  v-model="form.last_name"
                  v-validate="rules.lastName"
                  name="last-name"
                  placeholder="Last Name"
                  icon="account-card-details"
                />
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field
                label="Password"
                :type="{'is-danger': errors.has('password')}"
                :message="errors.first('password')"
                expanded
              >
                <b-input
                  ref="password"
                  v-model="form.password"
                  v-validate="rules.password"
                  name="password"
                  placeholder="Password"
                  type="password"
                  icon="lock"
                />
              </b-field>
            </div>
          </div>
          <div class="columns">
            <div class="column">
              <b-field
                label="Confirm Password"
                :type="{'is-danger': errors.has('confirm-password')}"
                :message="errors.first('confirm-password')"
                expanded
              >
                <b-input
                  v-model="form.password_confirmation"
                  v-validate="rules.confirmPassword"
                  name="confirm-password"
                  placeholder="Confirm Password"
                  type="password"
                  icon="lock"
                />
              </b-field>
            </div>
          </div>
          <hr>
          <b-button
            type="app-primary"
            @click="submit"
          >
            Save
          </b-button>
        </div>
      </form>
    </section>
  </div>
</template>
<script>
import { mapActions } from 'vuex'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import validationMixin from '@/mixins/validation'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
  mixins: [
    validationMixin,
    ErrorBagMixin
  ],
  data() {
    return {
      rules: {
        username: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        firstName: {
          required: true
        },
        lastName: {
          required: true
        },
        password: {
          required: true
        },
        confirmPassword: {
          required: true,
          confirmed: 'password'
        }
      },
      form: {
        username: '',
        email: '',
        first_name: '',
        last_name: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    async submit() {
      const result = await this.validateBeforeSubmit()

      this.$store.dispatch('staff/store', {data: this.form})
        .then((data) => {
            this.successToast(data.message)

            this.clearForm()
            this.clearErrors()
            this.$emit('success')
            this.$emit('hide')
        })
        .catch((error) => {
            this.catchError(error)
        });
    },
    clearForm() {
      this.form.username = ''
      this.form.email = ''
      this.form.first_name = ''
      this.form.last_name = ''
      this.form.password = ''
      this.form.password_confirmation = ''
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/staff/addStaff.scss";
</style>
