<template>
  <section class="client-orders">
    <div class="header-portlet">
      <h1 class="float-left">
        <b-icon icon="stethoscope" />
        BATCH ORDERSsss
      </h1>
      <div class="tabs float-right">
        <div class="column pt-0">
          <b-field
            class="show-field"
            horizontal
            label="Show:"
          >
            <b-select
              v-model="selectedPageCount"
              class="control"
              placeholder="Select results"
              @input="$emit('filterPageCount', selectedPageCount)"
            >
              <option
                v-for="option in pageCount"
                :value="option.value"
                :key="option.value"
              >
                {{ option.label }}
              </option>
            </b-select>
          </b-field>
        </div>
        <div class="column pt-0">
          <b-field
            horizontal
            label="Filter:"
          >
            <b-select
              v-model="selectedStatus"
              placeholder="Select a filter"
              @input="$emit('filterStatus', selectedStatus)"
            >
              <option
                v-for="option in statuses"
                :value="option.value"
                :key="option.value"
              >
                {{ option.label }}
              </option>
            </b-select>
          </b-field>
        </div>
      </div>
      <div class="clearfix" />
    </div>
    <b-field class="w-100">
      <p class="control">
        <span class="button is-static" v-text="batchModelStart">
        </span>
      </p>
      <b-input
        v-model="form.search"
        placeholder="Search Batch by Number (You may enter the last four numbers only"
        expanded
        @input="$emit('search', form.search)"
      />
    </b-field>

    <p v-if="this.orders.data.length === 0"
        class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
    <b-table v-else :data="this.orders.data"
      bordered
      striped
      hoverable
    >
      <template slot-scope="props">
        <b-table-column
          field="batch_no"
          label="Batch No."
        >
          {{ props.row.id }}
        </b-table-column>
        <b-table-column
          field="test_count"
          label="No. of tests"
        >
          {{ getNumberOfTests(props.row.orders) }}
        </b-table-column>
        <b-table-column
          field="patient_count"
          label="No. of patients"
        >
          {{ removeDuplicates(props.row.orders, 'patient_id').length }}
        </b-table-column>
        <b-table-column
          field="total_cost"
          label="Total Cost"
        >
          {{ 'P ' + getTotalCost(props.row.orders) }}
        </b-table-column>
        <b-table-column
          field="status"
          label="Status"
        >
          {{ props.row.status === 0 ? 'Draft' : props.row.status === 1 ? 'Confirmed' : props.row.status === 2 ? 'Accomplished' : '' }}
        </b-table-column>
        <b-table-column
          field="created_at"
          label="Date Created"
          width=""
        >
          {{ convertDate(props.row.created_at) }}
          <small>({{ props.row.created_at | relativeTime }})</small>
        </b-table-column>
        <b-table-column
          v-if="props.row.status === 0"
          field="actions"
          label="Actions"
          width="400"
        >
          <b-button
            type="is-success"
            @click="openViewModal(props.row)"
          >
            View
          </b-button>
          <b-button
            type="is-warning"
            @click="$emit('edit', props.row)"
          >
            Edit
          </b-button>
          <!--<b-button
            type="app-primary"
            @click="confirmed(props.row.id)"
          >
            Confirm
          </b-button>
          <b-button
            type="is-danger"
            @click="archive(props.row.id)"
          >
            Delete
          </b-button>-->
        </b-table-column>
        <b-table-column
          v-if="props.row.status === 1"
          field="actions"
          label="Actions"
          width="400"
        >
          <b-button
            type="app-primary"
            @click="done(props.row.id)"
          >
            Done
          </b-button>
          <b-button type="is-success" @click="viewPdf(props.row.id)">
            View PDF
          </b-button>
        </b-table-column>
        <b-table-column
          v-if="props.row.status === 2"
          field="actions"
          label="Actions"
          width="400"
        >
          <b-button type="is-success" @click="viewPdf(props.row.id)">
            View PDF
          </b-button>
        </b-table-column>
      </template>
    </b-table>
    <div class="pagination-controls mt-2">
      <b-button
        type="is-danger"
        :disabled="current === 1"
        @click="$emit('prev')"
      >
        Previous
      </b-button>
      <b-button
        type="is-danger"
        :disabled="current === orders.last_page"
        @click="$emit('next')"
      >
        Next
      </b-button>
    </div>
    <viewmodal
      v-if="openView"
      :order="orderToView"
      :open="openView"
      @close="openView = false"
    />

    <ViewPdfModal :source="viewPdfSrc" :open="openViewPdfModal"
        @close="closePdfModal" />
  </section>
</template>
<script>
import { mapGetters } from 'vuex'
import { relativeTime } from '@/filters/date'
import moment from 'moment'
import debounce from 'lodash.debounce'
import { Dialog } from 'buefy/dist/components/dialog'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"
import ViewPdfMixin from "@/mixins/ViewPdfMixin";

/**
 * Client batch list
 * @type {Object}
 */
export default {
    mixins: [
      ErrorBagMixin,
      ViewPdfMixin,
    ],

    components: {
        viewmodal: () => import('@/components/orders/client/ViewModal')
    },

    filters: {
        relativeTime
    },
    props: {
        orders: {
            type: Object,
            required: false,
            default: () => {
                return {data: []};
            }
        },
        current: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            form: {
                search: ''
            },
            openView: false,
            userToArchive: '',
            modalUsername: '',
            pageCount: [
                { "value": 10, "label": "10 results" },
                { "value": 30, "label": "30 results" },
                { "value": 50, "label": "50 results" },
                { "value": 100, "label": "100 results" },
                { "value": "", "label": "All results" },
            ],
            statuses: [
                { "value": 3, "label": "All" },
                { "value": '0', "label": "Draft" },
                { "value": 1, "label": "Confirmed" },
                { "value": 2, "label": "Accomplished" },
            ],
            selectedStatus: '0',
            selectedPageCount: 10,
            batchModelStart: '',
        }
    },

    mounted()
    {
        this.batchModelStart = process.env.MIX_BATCH_MODEL_START || '65800';
    },

    computed: {

    },
    methods: {
        confirmed(id) {
            Dialog.confirm({
                title: 'Update status of batch order ' + id,
                message: 'Are you sure you want to set this to <b>CONFIRMED</b>? This action cannot be undone.',
                confirmText: 'Confirm',
                type: 'is-warning',
                hasIcon: true,
                onConfirm: () => this.confirmConfirmed(id)
            })
        },

        removeDuplicates(myArr, prop) {
            return myArr.filter((obj, pos, arr) => {
                return arr.map(mapObj => mapObj[prop]).indexOf(obj[prop]) === pos;
            });
        },

        getTotalCost(orders) {
            let total_cost = 0;
            for (let order of orders) {
                let services = order.services;
                for (let service of services) {
                    total_cost += service.service.price;
                }
            }

            return total_cost.toLocaleString();
        },

        getNumberOfTests(orders)
        {
            let tests = 0;
            for (let order of orders) {
                let services = order.services;
                tests += services.length;
            }
            return tests;
        },

        confirmConfirmed(id)
        {
            this.$store.dispatch('clientOrders/setToConfirmed', {data: id})
            .then((data) => {
                this.successToast(data.message)

                this.$emit('fetch');
            })
            .catch((error) => {
                this.catchError(error)
            })
        },
        done(id) {
            Dialog.confirm({
                title: 'Update status of batch order ' + id,
                message: 'Are you sure you want to set this to <b>DONE</b>? This action cannot be undone.',
                confirmText: 'Confirm',
                type: 'is-warning',
                hasIcon: true,
                onConfirm: () => this.confirmDone(id)
            })
        },

        confirmDone(id)
        {
            this.$store.dispatch('clientOrders/setToDone', {data: id})
            .then((data) => {
                this.successToast(data.message)

                this.$emit('fetch');
            })
            .catch((error) => {
                this.catchError(error)
            })
        },
        openViewModal(order) {
            this.openView = true
            this.orderToView = order
        },
        archive(id) {
            this.$emit('archive', id)
            this.openDelete = false
        },
        update(payload) {
            this.openEdit = false
            this.$emit('update', payload)
        },
        convertDate(dateVal) {
            return moment(dateVal).format('MMM DD, YYYY hh:mm a')
        }
    },
}
</script>
<style lang="scss" scoped>
  @import "../../../../sass/components/orders/clientBatchOrders.scss";
</style>
