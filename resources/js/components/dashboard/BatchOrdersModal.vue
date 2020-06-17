<template>
  <b-modal
    class="batch-modal"
    :active.sync="open"
    has-modal-card
  >
    <div class="card">
      <header class="modal-card-head">
        <p class="modal-card-title">
          <b-icon icon="format-list-bulleted" /> Batch Order Summary
        </p>
      </header>
      <div class="modal-card-body">
        <h3>Batch Order Information</h3>
        <b-table
          :data="details"
          bordered
          striped
          narrowed
          hoverable
        >
          <template slot-scope="props">
            <b-table-column
              field="id"
              label="Batch no."
              numeric
            >
              {{ props.row.id }}
            </b-table-column>
            <b-table-column
              field="services_count"
              label="No. of tests"
            >
              {{ props.row.services_count }}
            </b-table-column>
            <b-table-column
              field="orders_count"
              label="No. of patients"
            >
              {{ props.row.orders_count }}
            </b-table-column>
            <b-table-column
              field="totalCost"
              label="Total Cost"
            >
              P{{ props.row.totalCost }}
            </b-table-column>
            <b-table-column
              field="clinician"
              label="Clinician"
            >
              Test
            </b-table-column>
            <b-table-column
              field="patientType"
              label="Patient Type"
            >
              {{ props.row.patient_type.name }}
            </b-table-column>
            <b-table-column
              field="paymentMode"
              label="Payment Mode"
            >
              {{ props.row.payment_mode }}
            </b-table-column>
            <b-table-column
              field="tagMode"
              label="Tag Mode"
            />
            <b-table-column
              field="status"
              label="Status"
            >
              {{ props.row.status }}
            </b-table-column>
          </template>
        </b-table>
      </div>
      <footer class="modal-card-foot">
        <div class="modal-actions">
          <b-button
            type="is-danger close-button"
            @click="$emit('close')"
          >
            Close
          </b-button>
        </div>
      </footer>
    </div>
  </b-modal>
</template>
<script>
export default {
  props: {
    open: {
      type: Boolean,
      default: false
    },
    details: {
      type: Array,
      required: true
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/dashboard/batchOrdersModal.scss";
</style>
