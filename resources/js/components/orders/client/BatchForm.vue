<template>
  <div class="column portlet">
    <section class="add-staff">
      <div class="column">
        <div class="header-portlet">
          <h1 class="float-left">
            <b-icon icon="briefcase" />
            BATCH ORDER
          </h1>
          <b-icon
            icon="close"
            class="float-right app-text-primary pointer"
            size="is-small"
            @click.native="$emit('close')"
          />
        </div>
      </div>
      <form @submit.prevent="submit">
        <div class="column">
          <div class="columns">
            <div class="column">
              <h4>Batch Information</h4>
              <p class="is-danger">
                * Required fields (Tip: Use tab to navigate to all required fields only.)
              </p>
            </div>
          </div>
          <div class="columns">
            <div class="column is-half">
              <b-field
                label="Source *"
                :type="{'is-danger': errors.has('source')}"
                :message="errors.first('source')"
              >
                <b-select
                  v-model="batch.source_id"
                  v-validate="rules.source_id"
                  name="source"
                  expanded
                >
                  <option :value="null" disabled>Please select a source</option>
                  <option
                    v-for="option in sourceOptions"
                    :key="option.value"
                    :value="option.id"
                  >
                    {{ option.name }}
                  </option>
                </b-select>
              </b-field>
            </div>
            <div class="column is-half">
              <b-field
                label="Patient Type *"
                :type="{'is-danger': errors.has('patient type')}"
                :message="errors.first('patient type')"
              >
                <b-select
                  v-model="batch.patient_type_id"
                  v-validate="rules.patient_type_id"
                  name="patient type"
                  expanded
                >
                  <option :value="null" disabled>Please select patient type</option>
                  <option
                    v-for="option in patient_type"
                    :key="option.id"
                    :value="option.id"
                  >
                    {{ option.name }}
                  </option>
                </b-select>
              </b-field>
            </div>
          </div>
          <div class="columns">
            <!--<div class="column is-one-third">
              <b-field
                label="Clinician"
                :type="{'is-danger': errors.has('clinician')}"
                :message="errors.first('clinician')"
              >
                <b-select
                  v-model="batch.clinician_id"
                  v-validate="rules.clinician_id"
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
            </div>-->
            <div class="column is-half">
              <b-field
                label="Payment Mode"
                :type="{'is-danger': errors.has('last-name')}"
                :message="errors.first('last-name')"
              >
                <b-select
                  v-model="batch.payment_mode"
                  class="control"
                  placeholder="Select payment mode"
                  expanded
                >
                  <option
                    v-for="option in payment"
                    :value="option.value"
                    :key="option.value"
                  >
                    {{ option.label }}
                  </option>
                </b-select>
              </b-field>
            </div>
            <div class="column is-half">
              <b-field
                label="Tag Mode"
                :type="{'is-danger': errors.has('password')}"
                :message="errors.first('password')"
                expanded
              >
                <b-input
                  v-model="batch.tag_mode"
                  ref="tag"
                  name="tag"
                  placeholder="Enter tag"
                />
              </b-field>
            </div>
          </div>
          <div class="column mb-5">
            <div class="columns">
                <!-- @update="submitEdit"
                @search="search" -->
                <!-- Batch orders list -->
              <BatchOrderTests
                :orders="batch_orders"
                :batchId="batch_id"
                :current="batchOrderListPage"
                @fetch="getBatchOrders()"
                @editOrder="openBatchOrderEdit"
              />
            </div>
          </div>
          <div class="page-footer">
              <div class="columns">
                  <div class="column is-7">
                      <b-button
                        type="app-primary"
                        @click="openAddOrderModal"
                      >
                        Add new order
                      </b-button>
                  </div>
                  <div class="column is-5">
                      <div class="">
                        <div class="column is-full padless-right">
                          <b-field
                            horizontal
                            label="Slides"
                          >
                            <b-input
                              v-model="batch.slides"
                              type="number"
                              name="slides"
                              value="0"
                            />
                          </b-field>
                        </div>
                        <div class="column is-full padless-right">
                          <b-field
                            horizontal
                            label="Blood"
                          >
                            <b-input
                              v-model="batch.blood"
                              type="number"
                              name="blood"
                              value="0"
                            />
                          </b-field>
                        </div>
                        <div class="column is-full padless-right">
                          <b-field
                            horizontal
                            label="Forms"
                          >
                            <b-input
                              v-model="batch.forms"
                              type="number"
                              name="forms"
                              value="0"
                            />
                          </b-field>
                        </div>
                        <div class="column is-full padless-right">
                          <b-field
                            horizontal
                            label="Other Specimen"
                          >
                            <b-input
                              v-model="batch.specimen"
                              type="text"
                              name="password"
                              placeholder="Other Specimen"
                            />
                          </b-field>
                        </div>
                        <div class="column is-full padless-right">
                          <b-field
                            horizontal
                            label="Encoded By"
                          >
                            <b-input
                              v-model="batch.encoded_by"
                              type="text"
                              name="password"
                              placeholder="Encoded By"
                            />
                          </b-field>
                        </div>
                      </div>
                  </div>
              </div>
            <div class="clearfix" />
          </div>
          <hr>
            <div class="has-text-right">
                <b-button
                    type="is-success"
                    :disabled="batch_orders.length == 0"
                    @click="submitButton(1)"
                    >
                    SAVE AND CONFIRM
                </b-button>
                <b-button
                    type="is-warning"
                    @click="submitButton(0)"
                    >
                    SAVE AS DRAFT
                </b-button>
                <b-button
                    type="is-default"
                    @click="$emit('close')"
                    >
                    CANCEL
                </b-button>
          </div>
        </div>
        </form>
        <AddOrderModal v-if="isShowOrderModal"
            :open="isShowOrderModal"
            :batch_id="batch.id"
            :orderId="batchOrderEditId"
            :clinicians="clinicians"
            @submitTests="submitTests"
            @editTests="updateTests"
            @close="isShowOrderModal = false"
            />
    </section>
  </div>
</template>
<script>
import { mapActions } from 'vuex'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import { Dialog } from 'buefy/dist/components/dialog'
import validationMixin from '@/mixins/validation'
import BatchOrderTests from '@/components/orders/client/BatchOrderTests'
import AddOrderModal from '@/components/orders/client/AddOrderModal'
import axios from 'axios'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"
import { isEmpty } from "lodash"

export default {
    components: {
        BatchOrderTests,
        AddOrderModal
    },
    computed: {

        clinicians()
        {
            return this.$store.getters['clinicians/all'];
        },

        isEdit()
        {
            return this.batch_id !== null;
        },

        isCreate()
        {
            return !this.isEdit;
        },
    },
    mixins: [
        validationMixin,
        ErrorBagMixin,
    ],
    props: {
        sources: {
            type: Array,
            required: true
        },
        batchEditData: {
            type: Object,
            required: false,
        },
    },

    data() {
        return {
            batch_id: null,
            rules: {
                source_id: {
                    required: true
                },
                patient_type_id: {
                    required: true
                },
            },
            batch: {
                id: null,
                code: '',
                source_id: 1,
                dispatcher_id: null,
                patient_type_id: null,
                payment_mode: 0,
                clinician_id: null,
                client_id: '',
                status: '',
                slides: 0,
                blood: 0,
                forms: 0,
                specimen: '',
                is_confirmed: '',
                tag_mode: '',
                encoded_by: '',
            },
            sourceOptions: this.sources,
            payment: [
                { "value": 0, "label": "Cash" },
                { "value": 1, "label": "Charge" },
            ],
            patient_type: [],

            //** Batch orders data
            batchOrderListPage: 1,
            batch_orders: [],
            batchOrderEditId: 0,

            // NEW DATA
            batchModelStart: '',
            isShowOrderModal: false,
        }
    },
    methods: {

        /**
         * Save this batch!
         * @param  {integer}  type - is_confirmed true or false
         * @return {Promise}
         */
        async submitButton(type) {
            this.submit(type)
        },

        /**
         * POST / PATCH request - save batch or update
         * @param  {[integer]}  type
         * @return {Promise}
         */
        async submit(type) {
            const result = await this.validateBeforeSubmit()
            this.batch.is_confirmed = type

            if (this.isCreate) {
                this.$store.dispatch('clientBatches/store', {data: this.batch})
                    .then((data) => {
                        let batchId = data.batch.id
                        this.successToast(data.message)
                        this.clearErrors()
                        this.$emit('success')
                        this.batch_id = batchId
                        this.batch.id = batchId
                    })
                    .catch((error) => {
                        this.catchError(error)
                    });
            } else {
                this.$store.dispatch('clientBatches/update', { data: this.batch })
                    .then((data) => {
                        this.successToast(data.message)
                        this.clearErrors()
                        this.$emit('success')
                    })
                    .catch((error) => {
                        this.catchError(error)
                    });
            }
        },

        /**
         * Save batch order
         * @param  {object} orders
         * @return {void}
         */
        submitTests(order)
        {
            if (this.isCreate) {
                // Fresh create new batch! first!
                this.batch.is_confirmed = 0
                this.batch.clinician_id = order.clinician_id
                this.$store.dispatch('clientBatches/store', { data: this.batch })
                    .then((data) => {
                        let batchId = data.batch.id
                        this.clearErrors()
                        this.batch_id = batchId
                        this.batch.id = batchId
                        this.saveBatchOrder(order)
                    })
                    .catch((error) => {
                        this.catchError(error)
                    });
            }

            if (this.isEdit) {
                this.saveBatchOrder(order)
            }
        },

        /**
         * Update batch order
         * @param  {[type]} order
         * @return {[type]}
         */
        updateTests(order)
        {
            this.saveBatchOrder(order, false)
        },

        /**
         * Save batch order/s
         * @param  {object} order
         * @return {[void]}
         */
        saveBatchOrder(order, isCreateOrder = true)
        {
            order.batch_id = this.batch_id
            // Convert is_urgent data from bool to int
            if (typeof order.is_urgent == 'boolean')
                order.is_urgent = order.is_urgent ? 1 : 0

            if (isCreateOrder) {
                // Save batch tests
                this.$store.dispatch('clientBatches/storeOrder', { data: order })
                    .then((data) => {
                        this.clearErrors()
                        this.getBatchOrders()
                        this.successToast(data.message)
                        this.isShowOrderModal = false
                    })
                    .catch((error) => {
                        this.catchError(error)
                    });
            } else {
                // Update batch tests
                this.$store.dispatch('clientBatches/updateOrder', { data: order })
                    .then((data) => {
                        this.clearErrors()
                        this.getBatchOrders()
                        this.successToast(data.message)
                        this.isShowOrderModal = false
                    })
                    .catch((error) => {
                        this.catchError(error)
                    });
            }

        },

        /**
         * Editing batch order
         * @param  {[type]} order
         * @return {[type]}
         */
        openBatchOrderEdit(orderId)
        {
            this.isShowOrderModal = true
            this.batchOrderEditId = orderId
        },

        addNewClinician(event) {
            if (event === "add") {
                this.$router.push({ path: '/settings' })
            }
        },

        /**
         * Creating new batch order
         * @return {Promise} [description]
         */
        async openAddOrderModal() {
            let result = await this.validateBeforeSubmit()
            if (result) {
                this.batchOrderEditId = 0
                this.isShowOrderModal = true
            }
        },

        fetchClinicians()
        {
            this.$store.dispatch('clinicians/fetchAll');
        },
        fetchPatientTypes()
        {
            axios.get(`/api/client/patient-types`)
            .then(({ data }) => {
                this.patient_type = data.patient_types;

                if (!this.isEdit) {
                    let default_patient_type = process.env.MIX_BATCH_PATIENT_TYPE_DEFAULT || 'SEND IN'

                    // New batch - set default patient type
                    for (let type of data.patient_types) {
                        if (type.name.toUpperCase() == default_patient_type.toUpperCase()) {
                            this.batch.patient_type = type.name
                            this.batch.patient_type_id = type.id
                        }
                    }
                }
            });
        },

        getBatchOrders() {
            if (this.isEdit) {

                axios.get(`/api/client/batch/order/${this.batch_id}`)
                    .then(({ data }) => {
                        this.batch_orders = data.orders;
                    })
                    .catch((error) => {
                        this.catchError(error)
                    });
            }
        },
    },
    mounted()
    {
        this.batchModelStart = process.env.MIX_BATCH_MODEL_START || '65800';

        // Check if this is editing mode - true - set data
        if (!isEmpty(this.batchEditData)) {
            // Edit mode
            this.batch = this.batchEditData
            this.batch_id = this.batchEditData.id
        } else {
            // Create
            let { payment_mode, full_name } = this.$store.getters['auth/me']
            this.batch.payment_mode = payment_mode;
            this.batch.encoded_by = full_name;
        }

        this.fetchClinicians();
        this.fetchPatientTypes();
        this.getBatchOrders();
    },
}
</script>
<style lang="scss" scoped>
  @import "../../../../sass/components/orders/addOrder.scss";
</style>
