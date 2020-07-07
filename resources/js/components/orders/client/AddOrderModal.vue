<template>
  <b-modal
    class="add-order-modal"
    :active.sync="open"
    :can-cancel="false"
    has-modal-card
  >
    <div class="card">
      <div class="modal-card-body">
        <div class="column">
          <h3>Batch Order</h3>
          <hr>
          <div class="autocomplete">
            <a href="javascript:;" @click="isShowModal = true" class="float-right">Click here to add new patient</a>
            <!--<router-link class="float-right" :to="{ name: 'patients', params: { fromPage: 'add-order-modal' } }">Click here to add new patient</router-link>-->
            <b-field class="w-100 search-field">
              <div v-show="selectedPatient.id" class="close-icon" @click="clearSearch">
                <b-icon icon="close" size="is-small" />
              </div>
              <b-input
                v-model="search"
                placeholder="Type to search for a patient"
                :disabled="selectedPatient.id"
                expanded
                @input="onSearchChange"
              />
            </b-field>
            <ul v-show="isSearchOpen" class="autocomplete-results">
              <li
                v-if="!patientResults.length"
                class="autocomplete-result"
              >
                No Patient Found.
              </li>
              <li
                v-else
                v-for="(item, i) in patientResults"
                :key="i"
                @click="setResult(item)"
                class="autocomplete-result is-capitalized"
              >
                {{ item.last_name }}, {{ item.first_name }} {{ item.middle_name }}
              </li>
            </ul>
          </div>

          <div v-show="selectedPatient.id" class="patient-order-form">
            <label class="mb-3">Patient Information</label>

            <div class="columns">
              <div class="column">
                <div>
                  <label>First Name</label>
                  <p>{{ selectedPatient.first_name }}</p>
                </div>
              </div>
              <div class="column">
                <div>
                  <label>Last Name</label>
                  <p>{{ selectedPatient.last_name }}</p>
                </div>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <div>
                  <label>Gender</label>
                  <p>{{ selectedPatient.gender }}</p>
                </div>
              </div>
              <div class="column">
                <div>
                  <label>Birthdate</label>
                  <p>{{ formatDate(selectedPatient.birth_date) }}</p>
                </div>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field
                  label="Clinical Info:"
                >
                  <b-input
                    v-model="form.clinical_information"
                    type="text"
                    name="clinical_information"
                    placeholder="Clinical Info"
                  />
                </b-field>
              </div>
              <div class="column">
                <b-field
                  label="Clinician"
                  :type="{'is-danger': errors.has('clinician')}"
                  :message="errors.first('clinician')"
                >
                  <b-select
                    v-model="form.clinician_id"
                    name="clinician"
                    @input="addNewClinician($event)"
                    expanded
                  >
                    <option :value="null" disabled>Please select clinician</option>
                    <option
                      v-for="option in clinicians"
                      :key="option.value"
                      :value="option.id"
                    >
                      {{ option.name }}
                    </option>
                    <option value="add">
                      <span>+ Add new clinician</span>
                    </option>
                  </b-select>
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <b-field
                  label="Special Instructions:"
                >
                  <b-input
                    v-model="form.special_instructions"
                    type="text"
                    name="special_instructions"
                    placeholder="Special Instructions"
                  />
                </b-field>
              </div>
              <div class="column">
                <b-field
                  label="OR/PR No:"
                >
                  <b-input
                    v-model="form.or_number"
                    type="text"
                    name="or_number"
                    placeholder="OR/PR No:"
                  />
                </b-field>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <i class="mt-3">Click a test to include</i>
              </div>
              
              <div class="column">
                <b-field
                  label="Mark as Urgent"
                >
                  <b-checkbox
                    v-model="form.is_urgent"
                    name="is_urgent"
                    value="1"
                    true-value="1"
                    false-value="0"
                    unchecked-value="0"
                  >
                  </b-checkbox>
                </b-field>
              </div>
            </div>
            <div class="columns mt-1">
                <!-- User services list -->
                <div class="column portlet available-tests">
                    <b-field label="Available Tests">
                        <b-input v-model="search_tests" type="text"
                        name="search_tests" placeholder="Search"
                        @input="filterTests(search_tests)" />
                    </b-field>
                    <b-button type="app-primary"
                        class="mr-1"
                        v-for="test in tests"
                        v-bind:key="test.id"
                        @click="selectService(test.id, test)"
                        >
                        {{ test.name }}
                    </b-button>
                </div>
                <!-- END -->
                <!-- Selected service box -->
                <div class="column portlet">
                    <b-field label="Selected Tests"
                        grouped
                        group-multiline>
                    </b-field>
                    <b-taglist>
                        <b-tag type="is-success"
                            class="mb-0 mr-1"
                            attached
                            aria-close-label="Close tag"
                            closable
                            v-for="(test, index) in form.services"
                            v-bind:key="test.id"
                            @close="removeService(index, test)"
                            expanded>
                            {{ test.name }}
                        </b-tag>
                  </b-taglist>
                </div>
                <!-- END -->
            </div>
          </div>
        </div>
        <div class="column">
          <div class="modal-actions">
            <hr>
            <b-button
              v-show="selectedPatient.id"
              class="float-right"
              type="app-primary"
              :disabled="form.services.length == 0"
              @click="isEdit ? $emit('editTests', form) : $emit('submitTests', form)"
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
        </div>
      </div>
    </div>

    <add-patient-modal
      :open="isShowModal"
      @new_patient="newlyAddedPatient"
      @close="isShowModal = false"
    />
  </b-modal>
</template>
<script>
import { mapActions } from 'vuex'
import moment from 'moment'
import axios from 'axios'
import debounce from 'lodash.debounce'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"
import { isEmpty, remove, filter, sortBy, omit, merge } from "lodash"
import AddPatientModal from '@/components/orders/client/AddPatientModal'

export default {
    mixins: [
        ErrorBagMixin,
    ],
    components: {
      AddPatientModal
    },
    props: {
        open: {
            type: Boolean,
            default: false
        },
        batch_id: {
            type: Number | String,
            required: true
        },
        orderId: {
            type: Number,
            required: false,
            default: 0
        },
        clinicians: {
          type: Array,
        }
    },
    data() {
        return {
            search: '',
            selectedPatient: {},
            isSearchOpen: false,
            patientResults: [],
            searchTimeout: null,
            form: {
                clinical_information: '',
                special_instructions: '',
                is_urgent: 0,
                or_no: null,
                services: [],
                patient_id: null,
                batch_id: this.batch_id,
                clinician_id: null,
            },

            search_tests: '',
            tests: [], // Services list to show
            testBtn: true,
            allServices: [],
            isShowModal: false,
        }
    },

    methods: {
        newlyAddedPatient(data) {
          this.search = `${data.last_name}, ${data.first_name}`
          this.selectedPatient = data
        },
        addNewClinician(event) {
            if (event === "add") {
                this.$emit('close')
                this.$router.push({ path: '/settings' })
            }
        },
        async submit() {
            this.form.id = this.staff.id
            this.$emit('update', this.form)
        },

        onSearchChange() {
            this.filterResults();
        },

        setResult(result) {
            const { first_name, last_name } = result;
            this.search = `${first_name} ${last_name}`;
            this.selectedPatient = result;
            this.form.patient_id = this.selectedPatient.id;
            this.isSearchOpen = false;
        },

        filterResults() {
            this.isSearchOpen = false;
            if (!this.search) return;
            if (this.searchTimeout) clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                axios.get(`/api/client/patient/search/${this.search}`)
                .then(({ data }) => {
                    this.isSearchOpen = true;
                    this.patientResults = data.patients.data || [];
                });
            }, 100);
        },

        fetchUserServices() {
            let route = `/api/client/services`;
            this.$store.dispatch('clientServicesList/fetch')
                .then((data) => {
                    let services = data.services
                    // Remove choosen services on list of services
                    this.tests = services

                    if (this.isEdit) {
                        this.setupServicesOnEditMode()
                    }
                });
        },

        /**
         * Setup services data on edit
         */
        setupServicesOnEditMode()
        {
            let userServices = this.form.services
            this.form.services = []

            for (let service of userServices) {
                this.selectService(service.service_id, {id: service.service.service.id, name: service.service.service.name})
            }

        },

        /**
         * Remove service from selected box
         * @param  {[type]} index
         * @param  {[type]} service
         * @return {[type]}
         */
        removeService(index, service)
        {
            this.form.services.splice(index, 1)
            // Add to service master list
            this.tests.push(service)
            this.tests = sortBy(this.tests, ['name']);
        },

        /**
         * Choose service - remove from list and add to choosen box
         * @param  {[type]} $id
         * @param  {[type]} $value
         * @return {[type]}
         */
        selectService($id, { id, name })
        {
            if (!this.checkIfExist(this.form.services, name)) {
                this.form.services.push({ id, name }) // add to selected services
                // After add remove from service master list
                let newTestList = remove(this.tests, (test) => {
                    return test.id != id;
                })
                this.tests = newTestList
            } else {
                this.$toast.open({
                    duration: 1000,
                    message: 'This test has been selected. Please choose another one.',
                    type: 'is-danger',
                    hasIcon: true
                })
            }
        },

        /**
         * Filter tests
         * @param  {[type]} key [description]
         * @return {[type]}     [description]
         */
        filterTests: debounce(function(key) {
            this.$store.dispatch('clientServicesList/fetch')
                .then((data) => {
                    let list = data.services

                    if (key == '') {
                        this.tests = list
                    } else {
                        this.tests = filter(list, (test) => {
                            let name = test.name.toLowerCase();
                            return name.includes(key);
                        });
                    }
                    this.removeTestsFromList()
                });

        }, 500),

        removeTestsFromList() {
            // Remove list box on selected box
            if (this.form.services.length > 0) {
                this.form.services.forEach((service) => {
                    this.tests = filter(this.tests, (test) => test.id != service.id)
                })
            }
        },

        /**
         * Check if service is on choosen box
         * @param  {[type]} services
         * @param  {[type]} value
         * @return {[type]}
         */
        checkIfExist(services, value)
        {
            const { length } = services;
            const id = length + 1;
            const found = services.some(el => el.value === value);
            return found;
        },

        clearSearch() {
            this.search = '';
            this.selectedPatient = {};
        },

        formatDate(date) {
            return moment(date).format('MMMM D, YYYY');
        },

        clearForm()
        {
            this.form.clinical_information = ''
            this.form.special_instructions = ''
            this.form.is_urgent = 0
            this.form.or_no = null
            this.form.services = []
            this.form.patient_id = null
            this.form.batch_id = this.batch_id
        },

        fetchOrderData()
        {
            http.getJSON(`/api/client/batch/order/${this.orderId}/details`)
                .then(({data}) => {
                let {order} = data
                    this.form = order
                    this.selectedPatient = order.patient

                    this.fetchUserServices()
                })
                .catch(error => {
                    this.catchError(error);
                });

        }
    },

    computed: {

        getCurrentDate()
        {
            return moment().format('MM/DD/YYYY')
        },

        getBatchOrders() {
            return [ this.order ];
        },

        isEdit()
        {
            return this.orderId != 0;
        },

        testsMasterList() {
            return this.$store.getters['clientServicesList/items'];
        }

    },

    mounted()
    {
        this.clearForm()
        if (this.isEdit)
            this.fetchOrderData()
        else
            this.fetchUserServices()
    }
}
</script>
<style lang="scss" scoped>
  @import "../../../../sass/components/orders/addOrderModal.scss";
</style>
