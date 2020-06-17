<template>
  <b-modal
    class="edit-service-modal"
    :active.sync="open"
    :can-cancel="false"
    has-modal-card
  >
    <div class="card">
      <div class="modal-card-body">
        <form @submit.prevent="submit">
          <div class="column">
            <h3>Personal Information</h3>
            <hr>
          </div>
          <div class="column no-top-padding">
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
          </div>
          <div class="column">
              <h3>Contact Information</h3>
              <hr>
            </div>
          <div class="column no-top-padding">
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
          </div>
          <div class="column">
            <div class="modal-actions">
              <hr>
              <b-button
                class="float-right"
                type="is-danger"
                @click="$emit('close')"
              >
                Close
              </b-button>
              <b-button
                class="float-right mr-2"
                tag="input"
                type="app-primary"
                native-type="submit"
                value="Update"
              />
            </div>
          </div>
        </form>
      </div>
    </div>
  </b-modal>
</template>
<script>
import { mapActions } from 'vuex'
import moment from 'moment'

export default {
  props: {
    open: {
      type: Boolean,
      default: false
    },
    staff: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      rules: {
        gender: {
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
        birthDate: {
          required: true
        }
      },
      form: this.staff.user ? this.staff.user : {
        first_name: this.staff.first_name,
        last_name: this.staff.last_name,
        email: this.staff.email,
        username: this.staff.username,
        search: true
      }
    }
  },
  methods: {
    async submit() {
      this.form.id = this.staff.id
      this.$emit('update', this.form)
    }
  },
  computed: {
    getCurrentDate() {
      return moment().format('MM/DD/YYYY')
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/staff/editStaffModal.scss";
</style>
