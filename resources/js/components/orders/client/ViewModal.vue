<template>
  <b-modal
    class="edit-service-modal"
    :active.sync="open"
    :can-cancel="false"
    has-modal-card
  >
    <div class="card">
      <div class="modal-card-body">
        <div class="mb-3">
          <h3>Batch Order Information</h3>
        </div>
        <p v-if="typeof this.getBatch === 'undefined'" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
        <b-table
          v-else
          :data="getBatch"
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
            >
              {{ convertDate(props.row.created_at) }}
            </b-table-column>
          </template>
        </b-table>
        <div class="mb-3 mt-5">
            <h3>Orders List</h3>
        </div>
        <p v-if="order.orders.length === 0" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
        <b-table
          v-else
          :data="order.orders"
          bordered
          striped
          hoverable
        >
          <template slot-scope="props">
            <b-table-column
              field="id"
              label="ID"
            >
              {{ props.row.id_prefix }}
            </b-table-column>
            <b-table-column
              field="patient"
              label="Patient"
            >
              {{ props.row.patient.last_name + ', ' + props.row.patient.first_name + (props.row.patient.middle_name ? ' ' + props.row.patient.middle_name + '.' : '') }}
            </b-table-column>
            <b-table-column
              field="tests_ordered"
              label="Tests Ordered"
            >
              <ul>
                <li
                  v-for="value in props.row.services"
                  v-bind:key="value.id"
                >
                  {{ value.service.service.name }} <span class="has-text-info is-size-6">(P {{ value.service.price.toLocaleString() }})</span>
                </li>
              </ul>
            </b-table-column>
            <b-table-column
              field="total_price"
              label="Total Price"
            >
              {{ 'P ' + props.row.services.reduce((acc, item) => acc + item.service.price, 0).toLocaleString() }}
            </b-table-column>
            <b-table-column
              field="date_ordered"
              label="Time & Date ordered"
            >
              {{ convertDate(props.row.created_at) }}
            </b-table-column>
            <b-table-column
              field="status"
              label="Status"
            >
              {{ props.row.status === 0 ? 'Pending' : '' }}
            </b-table-column>
          </template>
        </b-table>
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
          </div>
        </div>
      </div>
    </div>
  </b-modal>
</template>
<script>
import { mapActions } from 'vuex'
import moment from 'moment'
import axios from 'axios'

export default {
  props: {
    open: {
      type: Boolean,
      default: false
    },
    order: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      batch_id: this.order.id,
      batch_orders: [],
    }
  },
  methods: {
    async submit() {
      this.form.id = this.staff.id
      this.$emit('update', this.form)
    },

    getBatchOrders() {
      axios.get(`/api/client/batch/order/${this.batch_id}`)
        .then(({ data }) => {
          this.batch_orders = data || [];
        })
        .catch((error) => {
        });
    },

    convertDate(dateVal) {
      return moment(dateVal).format('MMM DD, YYYY hh:mm a')
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
  },
  computed: {
    getCurrentDate() {
      return moment().format('MM/DD/YYYY')
    },
    getBatch() {
      return [ this.order ];
    }
  },
  mounted() {
    //do something after mounting vue instance
    this.getBatchOrders();
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../../sass/components/orders/clientViewModal.scss";
</style>
