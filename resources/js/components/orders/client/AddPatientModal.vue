<template>
  <b-modal
    class="add-order-modal"
    :active.sync="open"
    :can-cancel="false"
  >
          
    <form @submit.prevent="submit">
      <div class="column">
        <div class="columns">
          <div class="column">
            <h3>PATIENT REGISTRATION</h3>
            <hr>
            <p class="is-danger">
              * Required
            </p>
          </div>
        </div>
        <div class="columns">
          <div class="column is-one-third">
            <b-field
              label="First Name *"
              :type="{'is-danger': errors.has('first-name')}"
              :message="errors.first('first-name')"
              expanded
            >
              <b-input
                v-model="form.first_name"
                v-validate="rules.firstName"
                name="first-name"
                placeholder="First Name"
              />
            </b-field>
          </div>
          <div class="column is-one-third">
            <b-field
              label="Middle Name"
              :type="{'is-danger': errors.has('middle-name')}"
              :message="errors.first('middle-name')"
              expanded
            >
              <b-input
                v-model="form.middle_name"
                name="middle-name"
                placeholder="Middle Name"
              />
            </b-field>
          </div>
          <div class="column is-one-third">
            <b-field
              label="Last Name *"
              :type="{'is-danger': errors.has('last-name')}"
              :message="errors.first('last-name')"
              expanded
            >
              <b-input
                v-model="form.last_name"
                v-validate="rules.lastName"
                name="last-name"
                placeholder="Last Name"
              />
            </b-field>
          </div>
        </div>
        <div class="columns">
          <div class="column is-half">
            <b-field
              label="Gender *"
              :type="{'is-danger': errors.has('gender')}"
              :message="errors.first('gender')"
              expanded
            >
              <b-select
                v-model="form.gender"
                v-validate="rules.gender"
                name="gender"
                placeholder="Select Gender"
                expanded
              >
                <option value="male">
                  Male
                </option>
                <option value="female">
                  Female
                </option>
              </b-select>
            </b-field>
          </div>
          <div class="column is-half">
            <b-field
              label="Birth Date *"
              :type="{'is-danger': errors.has('dob')}"
              :message="errors.first('dob')"
              expanded
            >
              <b-datepicker
                v-model="form.birth_date"
                v-validate="rules.birthDate"
                name="dob"
                placeholder="MM/DD/YYYY"
                icon="calendar-today"
                editable
              >
                dob
              </b-datepicker>
            </b-field>
          </div>
        </div>
        <div class="columns">
          <div class="column is-half">
            <b-field
              label="HPD Patient ID (your custom id)"
              :type="{'is-danger': errors.has('patient-id')}"
              :message="errors.first('patient-id')"
              expanded
            >
              <b-input
                v-model="form.client_custom_id"
                name="patient-id"
                placeholder="Patient ID"
              />
            </b-field>
          </div>
          <div class="column is-half">
            <b-field
              label="ID / Passport No."
              :type="{'is-danger': errors.has('passport-no')}"
              :message="errors.first('passport-no')"
              expanded
            >
              <b-input
                v-model="form.passport_number"
                name="passport-no"
                placeholder="Passport No."
                expanded
              />
            </b-field>
          </div>
        </div>
        <div class="columns">
          <div class="column is-half">
            <b-field
              label="Blood Group"
              :type="{'is-danger': errors.has('blood-group')}"
              :message="errors.first('blood-group')"
              expanded
            >
              <b-select
                v-model="form.blood_type"
                name="blood-group"
                placeholder="Select Blood Group"
                expanded
              >
                <option value="O">
                  O
                </option>
                <option value="A">
                  A
                </option>
                <option value="B">
                  B
                </option>
                <option value="AB">
                  AB
                </option>
              </b-select>
            </b-field>
          </div>
          <div class="column is-half">
            <b-field
              label="Rh"
              :type="{'is-danger': errors.has('rh')}"
              :message="errors.first('rh')"
              expanded
            >
              <b-select
                v-model="form.rh"
                name="rh"
                placeholder="Select Rh"
                expanded
              >
                <option value="rh+">
                  Rh+
                </option>
                <option value="rh-">
                  Rh-
                </option>
              </b-select>
            </b-field>
          </div>
        </div>
        <div class="columns">
          <div class="column is-half">
            <b-field
              label="Citizen"
              :type="{'is-danger': errors.has('citizen')}"
              :message="errors.first('citizen')"
              expanded
            >
              <b-input
                v-model="form.citizen"
                name="citizen"
                placeholder="Citizen"
              />
            </b-field>
          </div>
          <div class="column is-half">
            <b-field
              label="Mother's Maiden Name"
              :type="{'is-danger': errors.has('mother-name')}"
              :message="errors.first('mother-name')"
              expanded
            >
              <b-input
                v-model="form.mothers_maiden_name"
                name="mother-name"
                placeholder="Mother's Maiden Name"
                expanded
              />
            </b-field>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <h2>
              CONTACT INFORMATION
            </h2>
          </div>
        </div>
        <div class="columns">
          <div class="column">
            <b-field
              label="Email *"
              :type="{'is-danger': errors.has('email')}"
              :message="errors.first('email')"
              expanded
            >
              <b-input
                v-model="form.email"
                v-validate="rules.email"
                name="email"
                placeholder="Email"
              />
            </b-field>
          </div>
        </div>
        <div class="columns">
          <div class="column is-one-third">
            <b-field
              label="Telephone No."
              :type="{'is-danger': errors.has('telephone')}"
              :message="errors.first('telephone')"
              expanded
            >
              <b-input
                v-model="form.telephone_number"
                name="telephone"
                placeholder="Telephone No."
              />
            </b-field>
          </div>
          <div class="column is-one-third">
            <b-field
              label="Fax No."
              :type="{'is-danger': errors.has('fax')}"
              :message="errors.first('fax')"
              expanded
            >
              <b-input
                v-model="form.fax_number"
                name="fax"
                placeholder="Fax No."
              />
            </b-field>
          </div>
          <div class="column is-one-third">
            <b-field
              label="Mobile"
              :type="{'is-danger': errors.has('mobile')}"
              :message="errors.first('mobile')"
              expanded
            >
              <b-input
                v-model="form.mobile_number"
                name="mobile"
                placeholder="Mobile No."
              />
            </b-field>
          </div>
        </div>
        <div class="columns">
          <div class="column is-half">
            <b-field
              label="Address"
              :type="{'is-danger': errors.has('address')}"
              :message="errors.first('address')"
              expanded
            >
              <b-input
                v-model="form.address"
                name="address"
                placeholder="Address"
              />
            </b-field>
          </div>
          <div class="column is-half">
            <b-field
              label="City/Municipality"
              :type="{'is-danger': errors.has('city')}"
              :message="errors.first('city')"
              expanded
            >
              <b-input
                v-model="form.city"
                name="city"
                placeholder="City"
                expanded
              />
            </b-field>
          </div>
        </div>
        <div class="columns">
          <div class="column is-one-third">
            <b-field
              label="HMO Provider"
              :type="{'is-danger': errors.has('hmo-provider')}"
              :message="errors.first('hmo-provider')"
              expanded
            >
              <b-input
                v-model="form.hmo_card"
                name="hmo-provider"
                placeholder="HMO Provider (e.g. Maxicare, Intellicare)"
              />
            </b-field>
          </div>
          <div class="column is-one-third">
            <b-field
              label="HPD Patient ID"
              :type="{'is-danger': errors.has('patient-id')}"
              :message="errors.first('patient-id')"
              expanded
            >
              <b-input
                v-model="form.global_custom_id"
                name="patient-id"
                placeholder="Auto generated"
                disabled
              />
            </b-field>
          </div>
          <div class="column is-one-third">
            <b-field
              label="Registration Date"
              :type="{'is-danger': errors.has('br')}"
              :message="errors.first('registration-date')"
              expanded
            >
              <b-input
                v-model="getCurrentDate"
                name="registration-date"
                placeholder="MM/DD/YYYY"
                disabled
              />
            </b-field>
          </div>
        </div>
        <hr>
        <b-button
          type="app-primary"
          class="float-right"
          @click="submit"
        >
          Save
        </b-button>
        <b-button
          class="float-right mr-1"
          type="is-danger"
          @click="$emit('close')"
        >
          Close
        </b-button>
      </div>
    </form>
  </b-modal>
</template>
<script>
import { mapActions } from 'vuex'
import moment from 'moment'
import axios from 'axios'
import debounce from 'lodash.debounce'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"
import validationMixin from '@/mixins/validation'
import VueCookies from 'vue-cookies'

export default {
    mixins: [
      validationMixin,
      ErrorBagMixin,
    ],
    props: {
        open: {
            type: Boolean,
            default: false
        },
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
          form: {
            gender: '',
            birth_date: new Date(),
            first_name: '',
            last_name: '',
            middle_name: '',
            client_custom_id: '',
            passport_number: '',
            blood_type: '',
            rh: '',
            citizen: '',
            mothers_maiden_name: '',
            email: '',
            telephone_number: '',
            fax_number: '',
            mobile_number: '',
            address: '',
            city: '',
            hmo_card: '',
            global_custom_id: '',
            registration_date: '',
          }
        }
    },
    methods: {
      async submit() {
        const result = await this.validateBeforeSubmit()
        this.form.client_id = VueCookies.get('user_id')
        this.form.birth_date = moment(this.form.birth_date).format('MM/DD/YYYY')
        this.$store.dispatch('patients/store', {data: this.form})
        .then((data) => {
            this.successToast(data.message)

            this.clearForm()
            this.clearErrors()
            this.$emit('close')
        })
        .catch((error) => {
            this.catchError(error)
        });
      },
      clearForm() {
          this.form.gender = ''
          this.form.birth_date = new Date()
          this.form.first_name = ''
          this.form.last_name = ''
          this.form.middle_name = ''
          this.form.client_custom_id = ''
          this.form.passport_number = ''
          this.form.blood_type = ''
          this.form.rh = ''
          this.form.citizen = ''
          this.form.mothers_maiden_name = ''
          this.form.email = ''
          this.form.telephone_number = ''
          this.form.fax_number = ''
          this.form.mobile_number = ''
          this.form.address = ''
          this.form.city = ''
          this.form.hmo_card = ''
          this.form.global_custom_id = ''
          this.form.registration_date = ''
      }
    },
    computed: {
      getCurrentDate() {
        return moment().format('MM/DD/YYYY')
      }
    },
    mounted()
    {
    }
}
</script>
<style lang="scss" scoped>
  @import "../../../../sass/components/orders/addOrderModal.scss";
</style>
