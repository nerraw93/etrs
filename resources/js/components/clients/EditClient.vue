<template>
  <div class="column portlet">
    <section class="add-client">
      <div class="column">
        <div class="header-portlet">
          <h1 class="float-left">
            CLIENT REGISTRATION
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
            <div class="column is-half">
              <b-field
                label="Username"
                :type="{'is-danger': errors.has('username')}"
                :message="errors.first('username')"
                expanded
              >
                <b-input
                  v-model="form.username"
                  v-validate="rules.username"
                  name="username"
                  placeholder="Username"
                  icon="account"
                  disabled
                />
              </b-field>
            </div>
            <div class="column is-half">
              <b-field
                label="Email Address"
                :type="{'is-danger': errors.has('email')}"
                :message="errors.first('email')"
                expanded
              >
                <b-input
                  v-model="form.email"
                  v-validate="rules.email"
                  name="email"
                  placeholder="Email"
                  icon="email"
                  expanded
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
          <hr>
          <b-button
            tag="input"
            type="app-primary"
            native-type="submit"
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
import validationMixin from '@/mixins/validation'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import _ from 'lodash'

export default {
  mixins: [
    validationMixin,
    ErrorBagMixin
  ],
  components: {
    VueBootstrapTypeahead
  },
  props: {
    client: Object,
  },
  data: function() {
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
        id: this.client.id,
        username: this.client.username,
        email: this.client.email,
        first_name: this.client.first_name,
        last_name: this.client.last_name,
        password: '',
        password_confirmation: '',
        source: '',
      },
      query: '',
      selectedSources: [],
    }
  },
  methods: {
    ...mapActions('client', ['updateClient']),
    async submit() {
      const result = await this.validateBeforeSubmit()

      try {
        const data = await this.updateClient(this.form)
        if (data.success) {
          this.successToast(data.message)
          this.clearForm()
          this.clearErrors()
          this.$emit('success')
          this.$emit('hide')
        }
      } catch (e) {
        this.$toast.open({
          message: e.message,
          type: 'is-danger'
        })
      }
    },
    clearForm() {
      this.form.username = ''
      this.form.email = ''
      this.form.first_name = ''
      this.form.last_name = ''
      this.form.password = ''
      this.form.password_confirmation = ''
    },
    removeSelectedSource(index) {
      this.selectedSources.splice(index, 1)
    },
    addSelectedSource(value) {
      const exist = _.find(this.selectedSources, {'id': value.id})

      if (exist) {
        this.errorToast('Selected source already exists!')
      }
      else {
        this.selectedSources.push(value)
      }
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/clients/addClient.scss";
</style>
