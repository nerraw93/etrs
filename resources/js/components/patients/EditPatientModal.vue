<template>

    <b-modal class="edit-service-modal"
             :active.sync="open"
             :can-cancel="false"
             has-modal-card>
        <div class="card">
            <div class="modal-card-body">
                <form @submit.prevent="submit">
                    <div class="column">
                        <h3>Patient Information</h3>
                        <hr>
                    </div>
                    <div class="column no-top-padding">
                        <div class="columns">
                            <div class="column">
                                <b-field label="First Name *"
                                         :type="{'is-danger': errors.has('first-name')}"
                                         :message="errors.first('first-name')"
                                         expanded>
                                    <b-input v-model="form.first_name"
                                             v-validate="rules.firstName"
                                             name="first-name"
                                             placeholder="First Name" />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Middle Name"
                                         :type="{'is-danger': errors.has('middle-name')}"
                                         :message="errors.first('middle-name')"
                                         expanded>
                                    <b-input v-model="form.middle_name"
                                             name="middle-name"
                                             placeholder="Middle Name" />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Last Name *"
                                         :type="{'is-danger': errors.has('last-name')}"
                                         :message="errors.first('last-name')"
                                         expanded>
                                    <b-input v-model="form.last_name"
                                             v-validate="rules.lastName"
                                             name="last-name"
                                             placeholder="Last Name" />
                                </b-field>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <b-field label="Mother's Maiden Name"
                                         :type="{'is-danger': errors.has('mother-name')}"
                                         :message="errors.first('mother-name')"
                                         expanded>
                                    <b-input v-model="form.mothers_maiden_name"
                                             name="mother-name"
                                             placeholder="Mother's Maiden Name"
                                             expanded />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Gender *"
                                         :type="{'is-danger': errors.has('gender')}"
                                         :message="errors.first('gender')"
                                         expanded>
                                    <b-select v-model="form.gender"
                                              v-validate="rules.gender"
                                              name="gender"
                                              placeholder="Select Gender"
                                              expanded>
                                        <option value="male">
                                            Male
                                        </option>
                                        <option value="female">
                                            Female
                                        </option>
                                    </b-select>
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Birth Date *"
                                         :type="{'is-danger': errors.has('dob')}"
                                         :message="errors.first('dob')"
                                         expanded>
                                    <b-datepicker v-model="dob"
                                                  v-validate="rules.birthDate"
                                                  name="dob"
                                                  placeholder="MM/DD/YYYY"
                                                  icon="calendar-today"
                                                  editable>
                                        dob
                                    </b-datepicker>
                                </b-field>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <b-field label="Citizen"
                                         :type="{'is-danger': errors.has('citizen')}"
                                         :message="errors.first('citizen')"
                                         expanded>
                                    <b-input v-model="form.citizen"
                                             name="citizen"
                                             placeholder="Citizen" />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="ID / Passport No."
                                         :type="{'is-danger': errors.has('passport-no')}"
                                         :message="errors.first('passport-no')"
                                         expanded>
                                    <b-input v-model="form.passport_number"
                                             name="passport-no"
                                             placeholder="Passport No."
                                             expanded />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Blood Group"
                                         :type="{'is-danger': errors.has('blood-group')}"
                                         :message="errors.first('blood-group')"
                                         expanded>
                                    <b-select v-model="form.blood_type"
                                              name="blood-group"
                                              placeholder="Select Blood Group"
                                              expanded>
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
                            <div class="column">
                                <b-field label="HPD Patient ID (your custom id)"
                                         :type="{'is-danger': errors.has('patient-id')}"
                                         :message="errors.first('patient-id')"
                                         expanded>
                                    <b-input v-model="form.client_custom_id"
                                             name="patient-id"
                                             placeholder="Patient ID" />
                                </b-field>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <h3>Contact Information</h3>
                        <hr />
                    </div>
                    <div class="column">
                        <div class="columns">
                            <div class="column">
                                <b-field label="Email *"
                                         :type="{'is-danger': errors.has('email')}"
                                         :message="errors.first('email')"
                                         expanded>
                                    <b-input v-model="form.email"
                                             v-validate="rules.email"
                                             name="email"
                                             placeholder="Email" />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Address"
                                         :type="{'is-danger': errors.has('address')}"
                                         :message="errors.first('address')"
                                         expanded>
                                    <b-input v-model="form.address"
                                             name="address"
                                             placeholder="Address" />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="City/Municipality"
                                         :type="{'is-danger': errors.has('city')}"
                                         :message="errors.first('city')"
                                         expanded>
                                    <b-input v-model="form.city"
                                             name="city"
                                             placeholder="City"
                                             expanded />
                                </b-field>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <b-field label="Mobile"
                                         :type="{'is-danger': errors.has('mobile')}"
                                         :message="errors.first('mobile')"
                                         expanded>
                                    <b-input v-model="form.mobile_number"
                                             name="mobile"
                                             placeholder="Mobile No." />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Telephone No."
                                         :type="{'is-danger': errors.has('telephone')}"
                                         :message="errors.first('telephone')"
                                         expanded>
                                    <b-input v-model="form.telephone_number"
                                             name="telephone"
                                             placeholder="Telephone No." />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Fax No."
                                         :type="{'is-danger': errors.has('fax')}"
                                         :message="errors.first('fax')"
                                         expanded>
                                    <b-input v-model="form.fax_number"
                                             name="fax"
                                             placeholder="Fax No." />
                                </b-field>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column">
                                <b-field label="HMO Provider"
                                         :type="{'is-danger': errors.has('hmo-provider')}"
                                         :message="errors.first('hmo-provider')"
                                         expanded>
                                    <b-input v-model="form.hmo_card"
                                             name="hmo-provider"
                                             placeholder="HMO Provider (e.g. Maxicare, Intellicare)" />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="HPD Patient ID"
                                         :type="{'is-danger': errors.has('patient-id')}"
                                         :message="errors.first('patient-id')"
                                         expanded>
                                    <b-input v-model="form.global_custom_id"
                                             name="patient-id"
                                             placeholder="OL00000001"
                                             disabled />
                                </b-field>
                            </div>
                            <div class="column">
                                <b-field label="Registration Date"
                                         :type="{'is-danger': errors.has('br')}"
                                         :message="errors.first('registration-date')"
                                         expanded>
                                    <b-input v-model="getCurrentDate"
                                             name="registration-date"
                                             placeholder="MM/DD/YYYY"
                                             disabled />
                                </b-field>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="modal-actions">
                            <hr>
                            <b-button class="float-right"
                                      type="is-danger"
                                      @click="$emit('close')">
                                Close
                            </b-button>
                            <b-button class="float-right mr-2"
                                      tag="input"
                                      type="app-primary"
                                      @click="submit"
                                      value="Update" />
                        </div>
                    </div>
                </form>
            </div>

            <b-loading :is-full-page="false"
                :active="isLoading"></b-loading>
        </div>
    </b-modal>

</template>
<script>

    import { mapActions } from 'vuex'
    import moment from 'moment'
    import { isEmpty } from 'lodash'
    import ErrorBagMixin from '@/mixins/ErrorBagMixin'

    export default {

        mixins: [ErrorBagMixin],

        props: {
            open: {
                type: Boolean,
                default: false
            },
            patient: {
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
                form: {
                    first_name: '',
                    last_name: '',
                },
                dob: new Date(this.patient.birth_date),
                isLoading: true,
            }
        },

        mounted() {

            if (!isEmpty(this.patient)) {
                this.fetchPatientData(this.patient)
            }
        },

        methods: {

            submit() {
                this.form.birth_date = moment(this.dob).format('MM/DD/YYYY')
                this.isLoading = true
                this.$store.dispatch('patients/update', { data: this.form })
                    .then(data => {
                        this.isLoading = false
                        this.successToast(data.message)

                        this.$emit('update', true)

                    }).catch(error => {
                        this.isLoading = false
                        this.catchError(error)
                    })


            },

            fetchPatientData({ id }) {
                http.getJSON(`api/client/patient/${id}/details`)
                    .then(({ data: { patient } }) => {
                        this.form = patient
                        this.isLoading = false
                    })
                    .catch(error => {
                        this.catchError(error)
                    });
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

    @import '../../../sass/components/patients/editPatientModal.scss';

</style>
