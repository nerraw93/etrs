<template>
    <section class="batch-order-summary">
        <div class="columns">
            <div class="column is-half">
                <span class="number-of-orders">{{ total }}</span>
                <span class="order-type">{{ type }} Batch Orders</span>
            </div>
            <div class="column is-half" v-show="total">
                <b-pagination
                    :total="total"
                    :order="'is-right'"
                    :current="currentPage"
                    @change="paginationChange"
                    size="is-small"
                    per-page="10"
                    simple />
            </div>
        </div>
        <b-table :data="orders"
            v-show="total"
            bordered striped
            narrowed hoverable>
            <template slot-scope="props">
                <b-table-column
                    field="id"
                    label="Batch no."
                    numeric>
                    {{ props.row.id }}
                </b-table-column>
                <b-table-column field="services_count"
                    label="No. of tests">
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
                    label="Total Cost">
                    P{{ props.row.totalCost }}
                </b-table-column>
                <b-table-column
                    field="status"
                    label="Status">
                    {{ props.row.status }}
                </b-table-column>
                <b-table-column
                    field="actions"
                    label="Actions">
                    <b-button v-if="isConfirmed" type="is-success"
                        @click="viewPdf(props.row.id)">
                        View PDF
                    </b-button>
                    <span v-else>
                        <b-button type="is-success" @click="openBatchModal(props.row)">
                            View
                        </b-button>
                        <router-link class="button is-warning" to="/client-orders">
                            Edit
                        </router-link>
                    </span>
                </b-table-column>
            </template>
        </b-table>

        <BatchOrdersModal :open="isModalActive" :details="currentOrder"
            @close="isModalActive = false" />

        <ViewPdfModal :source="viewPdfSrc" :open="openViewPdfModal"
            @close="closePdfModal" />
    </section>
</template>
<script>
import ViewPdfMixin from "@/mixins/ViewPdfMixin";
import ErrorBagMixin from "@/mixins/ErrorBagMixin";

export default {

    mixins: [
        ViewPdfMixin,
        ErrorBagMixin
    ],

    components: {
        BatchOrdersModal: () => import('@/components/dashboard/BatchOrdersModal')
    },

    computed: {
        isConfirmed()
        {
            return this.type == 'Confirmed';
        }
    },

    props: {
        orders: {
            type: Array,
            required: true
        },
        type: {
            type: String,
            required: true
        },
        total: {
            type: Number,
            required: true
        },
        currentPage: {
            type: Number,
            required: false,
            default: 1
        }
    },

    data()
    {
        return {
            isModalActive: false,
            currentOrder: []
        }
    },

    methods: {

        openBatchModal(batch) {
            this.currentOrder = [batch]
            this.isModalActive = true
        },

        paginationChange(page){
            this.$emit('paginationEvent', { page, type: this.type })
        }

    }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/dashboard/batchOrders.scss";
</style>
