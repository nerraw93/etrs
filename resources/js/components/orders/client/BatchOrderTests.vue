<template>
  <section class="column portlet">
    <h4 class="mb-3">Orders</h4>
    <p v-if="orders.length === 0" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
    <b-table
      v-else
      :data="orders"
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
          class="text-capitalize"
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
              {{ value.service.service.name }}
            </li>
          </ul>
        </b-table-column>
        <b-table-column
          field="total_price"
          label="Total Price"
        >
          {{ 'P' + props.row.services.reduce((acc, item) => acc + item.service.price, 0) }}
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
          {{ getOrderStatus(props.row.status) }}
        </b-table-column>
        <b-table-column
          field="actions"
          label="Actions"
        >
          <b-button
            type="app-primary"
            @click="edit(props.row)"
            :disabled="isPostedOrCancelled(props.row.status)"
          >
            Edit
          </b-button>
          <b-button
            type="is-danger"
            @click="archive(props.row.id)"
            :disabled="isPostedOrCancelled(props.row.status)"
          >
            Delete
          </b-button>
          <b-button
            type="is-warning"
            @click="confirmUpdateStatus({id: props.row.id, status: 1})"
            :disabled="isPostedOrCancelled(props.row.status)"
          >
            Cancel
          </b-button>
          <b-button
            type="is-success"
            @click="confirmUpdateStatus({id: props.row.id, status: 3})"
            :disabled="isPostedOrCancelled(props.row.status)"
          >
            Post
          </b-button>
        </b-table-column>
      </template>
    </b-table>
  </section>
</template>
<script>
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import { Dialog } from 'buefy/dist/components/dialog'
import { mapGetters } from 'vuex'
import { relativeTime } from '@/filters/date'
import moment from 'moment'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
    mixins: [
        ErrorBagMixin,
    ],
    components: {
        AddOrderModal: () => import('@/components/orders/client/AddOrderModal')
    },
    filters: {
        relativeTime
    },
    props: {
        orders: {
            type: Array
        },
        current: {
            type: Number,
            required: true
        },
        batchId: {
            type: Number | String,
            required: true,
        }
    },

    data() {
        return {
            form: {
                search: ''
            },
            openDelete: false,
            userToArchive: '',
            modalUsername: '',
        }
    },
    computed: {

    },
    methods: {

        /**
         * Edit order
         * @param  {[type]} order [description]
         * @return {[type]}       [description]
         */
        edit(order)
        {
            this.$emit('editOrder', order.id)
        },

        archive(id) {
            Dialog.confirm({
                title: 'Deleting order',
                message: 'Are you sure you want to <b class="text-uppercase">delete</b>? This action cannot be undone.',
                confirmText: 'Confirm',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.delete(id)
            })
        },

        delete(id)
        {
            this.$store.dispatch('clientOrders/deleteOrder', {data: id})
            .then((data) => {
                this.successToast(data.message)

                this.$emit('fetch')
            })
            .catch((error) => {
                this.catchError(error)
            })
        },

        confirmUpdateStatus(payload) {
            if (payload.status === 1) {
                Dialog.confirm({
                    title: 'Cancelling order',
                    message: 'Are you sure you want to <b class="text-uppercase">cancel</b>? This action cannot be undone.',
                    confirmText: 'Confirm',
                    type: 'is-warning',
                    hasIcon: true,
                    onConfirm: () => this.updateStatus(payload)
                })
            } else if (payload.status === 3) {
                Dialog.confirm({
                    title: 'Posting order',
                    message: 'Are you sure you want to <b class="text-uppercase">post</b> this? This action cannot be undone.',
                    confirmText: 'Confirm',
                    type: 'is-success',
                    hasIcon: true,
                    onConfirm: () => this.updateStatus(payload)
                })
            }
        },

        updateStatus(payload) {
            this.$store.dispatch('clientOrders/updateOrderStatus', {data: payload})
            .then((data) => {
                this.successToast(data.message)

                this.$emit('fetch')
            })
            .catch((error) => {
                this.catchError(error)
            });
        },

        convertDate(dateVal) {
            return moment(dateVal).format('MMM DD, YYYY hh:mm a')
        },

        updateTests(form) {
            this.$emit('updateTests', form)
        },

        /**
         * Check if this order is posted or cancelled...
         * This item cannot be edited/updated in any terms
         * @param  {[type]}  order
         * @return {Boolean}
         */
        isPostedOrCancelled(status)
        {
            return status != 0;
        },

        getOrderStatus(status)
        {
            let statusText = 'Pending'
            switch(status) {
                case 0:
                    statusText = 'Pending'
                break;
                case 1:
                    statusText = 'Cancelled'
                break;
                case 3:
                    statusText = 'Posted'
                break;
            }
            return statusText;
        },
    }
}
</script>
<style lang="scss" scoped>
  @import "../../../../sass/components/orders/clientBatchOrders.scss";
</style>
