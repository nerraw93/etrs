<template>
    <b-modal
        class="assign-modal"
        :active="isOpen"
        @close="$emit('close')"
        has-modal-card>
        <div class="card">
            <header class="modal-card-head">
                <p class="modal-card-title">
                    Assign a Source
                </p>
            </header>
            <div class="modal-card-body">
                <div class="field">
                    <label class="label">Search</label>
                    <div class="control">
                        <input
                            class="input"
                            type="text"
                            v-model="search"
                            @input="searchInput(search)"
                            placeholder="Search source"
                        />
                    </div>
                </div>
                <b-table
                    :data="sources"
                    bordered
                    striped
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
                            <b-button type="app-primary" @click="add(props.row)">
                                Assign
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

                <paginator :data="sourcesItems"
                    :fetch-by-search="fetchBySearch"
                    @previous="previous"
                    @next="next"/>
            </div>
            <footer class="modal-card-foot">
                <div class="modal-actions">
                    <b-button
                    type="is-danger close-button"
                    @click="$emit('close')">
                        Close
                    </b-button>
                </div>
            </footer>
        </div>
    </b-modal>
</template>
<script>

import debounce from 'lodash.debounce'
import paginator from '@/components/global/Paginator'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
    mixins: [
        ErrorBagMixin
    ],
    /**
     * Components
     * @type {Object}
     */
    components: {
        paginator,
    },

    props: {
        isOpen: {
            type: Boolean,
            required: true
        }
    },

    watch: {
        isOpen: function(newVal, oldVal) { // watch it
            if (newVal) {
                this.fetchSources();
            }
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
            sourcesItems: {},
            sources: [],
            clientId: '',
            search: '',
            page: 1,
            fetchBySearch: false
        }
    },

    /**
     * Methods
     * @type {Object}
     */
    methods: {

        searchService()
        {
            http.getJSON(`/api/admin/system/source/search/${this.search}`)
                .then(({data}) => {
                    let {sources} = data;

                    this.sourcesItems = sources;
                    this.sources = sources.data;

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
            await this.fetchSources();
          }
        }, 500),

        /**
         * Fetch sources
         * @param  {Number} [page=1]
         * @return {void}
         */
        fetchSources(path = '')
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
                    path = `/api/admin/system/source/${this.clientId}/filter?page=${this.page}`;
                } else {
                    path = `/api/admin/system/source/${this.clientId}/filter`;
                }
            }

            http.getJSON(path)
                .then(({data}) => {
                    let {sources} = data;

                    this.sourcesItems = sources;
                    this.sources = sources.data;
                    // resolve(data);
                })
                .catch(error => {
                    // reject(error);
                });
        },

        /**
         * Next path
         * @param  {string}   path
         * @return {void}
         */
        next(path)
        {
            this.fetchSources(path + '&clientId=' + this.clientId);
        },

        /**
         * Previous path
         * @param  {string} path
         * @return {void}
         */
        previous(path)
        {
            this.fetchSources(path + '&clientId=' + this.clientId);
        },

        /**
         * Add service
         * @param {[type]} serviceId [description]
         */
        add(source)
        {
            this.$store.dispatch('clientSources/store', {
                source: source
            })
              .then((data) => {
                  this.successToast(data.message)
              })
              .catch((error) => {
                  this.catchError(error)
              });

              this.$emit('close');
        },
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
@import "../../../sass/components/clients/sources.scss";
</style>
