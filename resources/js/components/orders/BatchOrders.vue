<template>
    <section class="batch-orders">
        <div class="column">
            <div class="header-portlet">
                <div>
                    <form @submit.prevent="submit">
                        <b-field>
                            <p class="control">
                                <span class="button is-static" v-text="batchModelStart"></span>
                            </p>
                            <b-input
                            v-model="search"
                            @input="$emit('search', search)"
                            expanded
                            placeholder="Search Batch by Number (You may enter the last four numbers only"
                            />
                        </b-field>
                    </form>
                </div>
            </div>
            <b-table :data="orders.data"
                bordered striped hoverable>
                <template slot-scope="props">
                    <b-table-column field="batchNo"
                        label="Batch no."
                        width="" >
                        {{ props.row.id }}
                    </b-table-column>
                    <b-table-column field="tests"
                        label="No. of tests"
                        width="">
                        {{ props.row.services_count }}
                    </b-table-column>
                    <b-table-column field="patients"
                        label="No. of patients" width="">
                        {{ props.row.orders_count }}
                    </b-table-column>
                    <b-table-column field="totalCost"
                        label="Total Cost"
                        width="">
                        {{ getTotalCost(props.row.orders) }}
                    </b-table-column>
                    <b-table-column field="status"
                        label="Status"
                        width="">
                        {{ props.row.status === 1 ? 'Confirmed' : 'Accomplished' }}
                    </b-table-column>
                    <b-table-column field="dateCreated"
                    label="Date Created"
                    width="">
                        {{ props.row.created_at }}
                    </b-table-column>
                    <b-table-column v-if="props.row.status === 1"
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
                    <b-table-column v-else
                        field="actions"
                        label="Actions"
                        width="400"
                        >
                        <b-button type="is-success" @click="viewPdf(props.row.id)">
                            View PDF
                        </b-button>
                    </b-table-column>
                </template>
                <template slot="empty">
                    <section class="section">
                        <div class="content has-text-grey has-text-centered">
                            <p>
                                <b-icon
                                    icon="emoticon-sad"
                                    size="is-large">
                                </b-icon>
                            </p>
                            <p>Nothing here.</p>
                        </div>
                    </section>
                </template>
            </b-table>
            <Paginator :data="orders" :fetch-by-search="fetchBySearch" :page="page" returnpageonly="true"
                @previous="paginateChange"
                @next="paginateChange" />
        </div>
        <ViewPdfModal :source="viewPdfSrc" :open="openViewPdfModal"
            @close="closePdfModal" />
    </section>
</template>
<script>
import debounce from 'lodash.debounce';
import { Dialog } from 'buefy/dist/components/dialog';
import ErrorBagMixin from "@/mixins/ErrorBagMixin";
import ViewPdfMixin from "@/mixins/ViewPdfMixin";
import Paginator from "@components/global/Paginator";


/**
 * Admin Batch list
 * @type {Object}
 */
export default {

    components: {
        Paginator
    },

    props: {
        orders: {
            type: Object,
            required: true
        },
        fetchBySearch: {
            type: Boolean,
            required: true,
            default: false
        },
        page: {
            type: Number,
            required: true
        }
    },

    mixins: [
        ErrorBagMixin,
        ViewPdfMixin,
    ],

    data() {
        return {
            editMode: false,
            search: '',
            orderItems: {},
            batchModelStart: '',
        }
    },

    mounted()
    {
        this.batchModelStart = process.env.MIX_BATCH_MODEL_START || '65800';
    },

    methods: {

        paginateChange(page) {
            this.$emit('paginateChange', page)
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
            this.$store.dispatch('adminBatchOrders/setToDone', {data: id})
            .then((data) => {
                this.sucessToast(data.message);

                this.$emit('fetch');
            })
            .catch((error) => {
                this.catchError(error);
            })
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

    }
}
</script>
<style lang="scss" scoped>
    @import "../../../sass/components/orders/batchOrders.scss";
</style>
