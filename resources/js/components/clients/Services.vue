<template>
    <div class="client-services-list">
        <b-table :data="services"
            bordered
            striped
            hoverable>
            <template slot-scope="props">
                <b-table-column
                    field="code"
                    label="Code">
                        {{ props.row.service.code }}
                    </b-table-column>
                    <b-table-column field="name"
                        label="Name"
                        width="700">
                        {{ props.row.service.name }}
                    </b-table-column>
                <b-table-column
                    field="price"
                    label="Price"
                    width="200">
                    {{ props.row.price }}
                </b-table-column>
                <b-table-column
                    field="actions"
                    width="300"
                    label="Actions">
                    <b-button type="is-success" @click="editPrice(props.row)">
                        Edit Price
                    </b-button>
                    <b-button type="is-danger" @click="archive(props.row)">
                        Archive
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

        <paginator :data="paginateItems"
            @previous="previous"
            @next="next"/>

        <b-button
            class="mt-2"
            type="app-primary"
            icon-right="check"
            @click="openAssignModal = true">
            Assign Service
        </b-button>

        <AssignServices :open="openAssignModal"
            :sourceId="source"
            @add="openAddServiceModal"
            @import="fetch"
            @close="openAssignModal = false"/>

        <updatepricemodal :open="showUpdatePriceModal"
            :service="service"
            @close="closeModal"/>

        <confirmationmodal :data="deleteModalData"
            :open="isShowDeleteModal"
            @submit="deleteClientService"
            @close="isShowDeleteModal = false" />

        <addservicemodal :open="isShowAddServiceModal"
            @close="closeAddServiceModal"
            :sourceId="source"
            :client="clientId"
            :services="choosenServicesData" />
    </div>
</template>
<script>
import { mapActions } from 'vuex';
import AssignServices from './AssignServices';
import updatepricemodal from './modal/UpdatePriceModal';
import addservicemodal from './modal/AddServiceModal';
import paginator from '@/components/global/Paginator';
import confirmationmodal from '@/components/global/ConfirmationModal';
import ErrorBagMixin from "@/mixins/ErrorBagMixin";

export default {

    mixins: [ErrorBagMixin],

    /**
     * Components
     * @type {Object}
     */
    components: {
        confirmationmodal,
        AssignServices,
        updatepricemodal,
        addservicemodal,
        paginator,
    },

    /**
     * Prop[erties]
     * @type {Object}
     */
    props: {
        current: {
            type: Number,
            required: true
        },
        code: {
            type: String,
            required: true
        },
        source: {
            type: Number,
            required: true
        }
    },

    /**
     * Computed
     * @type {Object}
     */
    computed:{

        /**
         * List of services
         *
         * @return {[type]}
         */
        services()
        {
            return this.$store.getters['clientServices/services'];
        },

        paginateItems()
        {
            return this.$store.getters['clientServices/items'];
        }
    },

    /**
     * Data
     * @return {object}
     */
    data() {
        return {
            openAssignModal: false,
            showUpdatePriceModal: false,
            service: {},
            isShowDeleteModal:false,
            deleteModalData: {},
            isShowAddServiceModal: false,
            choosenServicesData: [],
            clientId: '',
        }
    },

    methods: {

        /**
         * Delete modal
         * @return {[type]} [description]
         */
        deleteClientService()
        {
            this.isShowDeleteModal = false;
            this.$store.dispatch('clientServices/archive', {service: this.service})
              .then((data) => {
                 this.sucessToast(data.message);
              })
              .catch((error) => {
                  this.catchError(error);
              });
        },

        /**
         * Edit client service prices
         *
         * @param  {object} clientService \
         * @return {void}               \
         */
        editPrice(clientService)
        {
            this.service = clientService;
            this.showUpdatePriceModal = true;
        },

        /**
         * Close modal
         * @return {void}
         */
        closeModal()
        {
            this.showUpdatePriceModal = false;
        },

        /**
         * Archive client services
         *
         * @param  {object} clientService
         * @return {void}
         */
        archive(clientService)
        {
            this.isShowDeleteModal = true;
            this.service = clientService;
            this.deleteModalData = {
                title: 'Archive',
                icon: 'archive',
                message: `Are you sure you want to archive this service to this client?`,
            };
        },

        /**
         * Fetch client services
         * @param  {String} [path='']
         * @return {void}
         */
        fetch(path = '')
        {
            let url = window.location.pathname.split("/");
            let clientId = url[url.length - 1];
            this.clientId = clientId
            if (path) {
                path = path.split(/(?=\/api)/)[1]; // temporary fix due to poor engineering of pagination!!
            }

            this.$store.dispatch('clientServices/fetch', {id: clientId, sourceId: this.source, path})
              .then((data) => {
              })
              .catch((error) => {
                  this.catchError(error);
              });
        },

        /**
         * Next path
         * @param  {string}   path
         * @return {void}
         */
        next(path)
        {
            this.fetch(path);
        },

        /**
         * Previous path
         * @param  {string} path
         * @return {void}
         */
        previous(path)
        {
            this.fetch(path);
        },

        /**
         * Open service update price modal
         *
         * @param  {Object} service
         * @return {void}
         */
        openAddServiceModal(services)
        {
            this.choosenServicesData = services;
            this.isShowAddServiceModal = true;
            this.openAssignModal = false;
        },

        /**
         * Close add service modal
         * @param  {Boolean} [refresh=false]
         * @return {void}
         */
        closeAddServiceModal(refresh = false)
        {
            this.isShowAddServiceModal = false;

            if (refresh) {
                this.fetch();
            }
        },
    },

    /**
     * Mounted Hook
     * @return {void}
     */
    mounted()
    {
        this.fetch();
    },
}
</script>
<style lang="scss" scoped>
@import "../../../sass/components/clients/services.scss";
</style>
