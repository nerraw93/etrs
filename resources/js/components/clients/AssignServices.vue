<template>
    <b-modal
        class="assign-modal"
        :active.sync="open"
        has-modal-card>
        <div class="card">
            <header class="modal-card-head">
                <p class="modal-card-title">
                    Assign a Service
                </p>
            </header>
            <div class="modal-card-body">
                <div class="field">
                    <b-upload
                        v-model="file"
                        :native="true"
                        @input="importFile"
                        >
                        <a class="button app-primary">
                            <b-icon icon="cloud-download" />
                            <span>Import</span>
                        </a>
                    </b-upload>
                </div>
                <div class="field">
                    <label class="label">Search</label>
                    <div class="control">
                        <input class="input" type="text" v-model="search"
                            @input="searchInput(search)"
                            placeholder="Search service">
                    </div>
                </div>
                <b-table
                    :data="services"
                    bordered
                    striped
                    narrowed
                    hoverable>
                    <template slot-scope="props">
                        <b-table-column
                            field="code"
                            label="Code">
                            {{ props.row.code }}
                        </b-table-column>
                        <b-table-column
                            field="name"
                            label="Name"
                            width="700">
                            {{ props.row.name }}
                        </b-table-column>
                        <b-table-column
                            field="status"
                            label="Status">
                            Unassigned
                        </b-table-column>
                        <b-table-column
                            field="actions"
                            label="Actions">
                            <b-button :type="{'is-primary': isChoosen(props.row.id), 'is-success': !isChoosen(props.row.id)}"
                                :disabled="isChoosen(props.row.id)" @click="add(props.row)">
                                Assign
                            </b-button>
                        </b-table-column>
                    </template>
                </b-table>

                <paginator :data="servicesItems"
                    :fetch-by-search="fetchBySearch"
                    @previous="previous"
                    @next="next"/>

                <!-- List of choosen services -->
                <section class="mt-4" v-if="choosenServicesActivated">
                    <h4 class="has-text-black has-text-weight-bold">List of selected services:</h4>
                    <b-tag size="is-medium" type="is-primary" class="mr-2 mt-2"
                        closable v-for="choosenService in choosenServices"
                        :key="choosenService.id"
                        @close="removeService(choosenService.id)">{{choosenService.name}}</b-tag>

                </section>

            </div>
            <footer class="modal-card-foot">
                <div class="modal-actions has-text-right">
                    <b-button type="is-primary mr-4"
                        @click="apply" v-if="choosenServicesActivated">
                        Add and Set price
                    </b-button>
                    <b-button type="is-danger close-button"
                        @click="$emit('close')">
                        Close
                    </b-button>
                </div>
            </footer>
        </div>
    </b-modal>
</template>
<script>

import debounce from 'lodash.debounce';
import paginator from '@/components/global/Paginator';
import {findIndex} from "lodash";
import axios from 'axios'

export default {

    /**
     * Components
     * @type {Object}
     */
    components: {
        paginator,
    },

    props: {
        open: {
            type: Boolean,
            required: true
        },
        sourceId: Number,
    },

    watch: {
        open: function(newVal, oldVal) { // watch it
            if (newVal) {
                this.fetchServices();
                this.search = '';
                this.choosenServices = [];
            }
        }
    },

    computed: {

        choosenServicesActivated()
        {
            return this.choosenServices.length > 0 ? true : false;
        }
    },

    /**
     * Data
     * @return {object}
     */
    data() {
        return {
            service: {

            },
            servicesItems: {},
            services: [],
            clientId: '',
            fetchBySearch: false,
            search: '',
            isShowApplyButton: false,
            choosenServices: [],
            file: null,
            page: 1
        }
    },

    /**
     * Methods
     * @type {Object}
     */
    methods: {

        isChoosen(id)
        {
            for (let choosen of this.choosenServices) {
                if (choosen.id == id)
                    return true;
            }

            return false;
        },

        searchService()
        {
            http.getJSON(`/api/admin/services/search/${this.search}`, {clientId: this.clientId})
                .then(({data}) => {
                    let {services} = data;

                    this.servicesItems = services;
                    this.services = services.data;
                })
                .catch(error => {

                });
        },
        searchInput: debounce(async function(value) {
            if (value) {
                this.fetchBySearch = true;
                await this.searchService();
            } else {
                this.fetchBySearch = false;
                await this.fetchServices();
            }
        }, 500),

        /**
         * Fetch services
         * @param  {Number} [page=1]
         * @return {void}
         */
        fetchServices(path = '')
        {
            let url = window.location.pathname.split("/");
            let clientId = url[url.length - 1];
            this.clientId = clientId;

            if (path) {
                let url = new URL(path);
                path = path.split(/(?=\/api)/)[1]; // temporary fix due to poor engineering of pagination!!

                this.page = url.searchParams.get('page');
            } else {
                if (this.page > 1) {
                    path = `/api/admin/services?page=${this.page}&clientId=${clientId}`;
                } else {
                    path = `/api/admin/services?clientId=${clientId}&source=${this.sourceId}`;
                }
            }

            http.getJSON(path)
                .then(({data}) => {
                    let {services} = data;

                    this.servicesItems = services;
                    this.services = services.data;

                })
                .catch(error => {

                });
        },

        /**
         * Next path
         * @param  {string}   path
         * @return {void}
         */
        next(path)
        {
            this.fetchServices(path + '&clientId=' + this.clientId);
        },

        /**
         * Previous path
         * @param  {string} path
         * @return {void}
         */
        previous(path)
        {
            this.fetchServices(path + '&clientId=' + this.clientId);
        },

        /**
         * Add service
         * @param {[type]} serviceId
         */
        add(service)
        {
            this.choosenServices.push(service);
        },

        apply()
        {
            this.$emit('add', this.choosenServices);
        },

        /**
         * Remove service from choosen
         * @param  {integer} id
         * @return {void}
         */
        removeService(id)
        {
            let index = findIndex(this.choosenServices, (s) => {return s.id == id});
            this.choosenServices.splice(index, 1);
        },

        async importFile() {
            let formData = new FormData();
            formData.append('file', this.file)
            try {
                await axios.post(`/api/admin/client/${this.clientId}/${this.sourceId}/services/import`, formData)
                this.$toast.open({
                    message: 'Import successful',
                    type: 'is-success'
                })
                await this.$emit('import')
                await this.$emit('close')
            } catch (e) {
                console.error(e)
            }
        }
    },

    /**
     * Mounted hook
     * @return {void}
     */
    mounted()
    {

    },
}
</script>
<style lang="scss" scoped>
@import "../../../sass/components/clients/services.scss";
</style>
