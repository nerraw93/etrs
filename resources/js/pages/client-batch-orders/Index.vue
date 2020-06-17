<template>
  <div class="orders">
    <Header />
    <section>
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column is-full no-left-padding">
            <b-button
              v-show="!isShowBatchForm"
              type="app-primary"
              icon-right="plus"
              @click="openBatchForm"
            >
              Add
            </b-button>
          </div>
            <BatchForm
                :sources="sources"
                :isEdit="isEdit"
                :batchEditData="editBatch"
                @success="closeBatchForm"
                @close="isShowBatchForm = false"
                v-if="isShowBatchForm"
                />
            <div v-if="!isShowBatchForm"
                class="column portlet"
                :class="!isEdit ? 'mt-4' : null" >
                <BatchList
                    :orders="batches"
                    :current="getCurrentPage"
                    @archive="archive"
                    @next="next()"
                    @prev="prev()"
                    @edit="edit"
                    @search="search"
                    @fetch="fetch"
                    @filterPageCount="filterPageCount"
                    @filterStatus="filterStatus" />
            </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import { Dialog } from 'buefy/dist/components/dialog'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import debounce from 'lodash.debounce'
import Header from '@/components/global/Header'
import BatchList from '@/components/orders/client/BatchList'
import BatchForm from '@/components/orders/client/BatchForm'
import axios from 'axios'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
    mixins: [
        ErrorBagMixin
    ],
    props: {
        fromPage: {
            required: false,
            default: null,
            type: String
        }
    },
    components: {
        Header,
        BatchList,
        BatchForm,
    },
    data() {
        return {
            searchVal: '',
            page: 1,
            searchPage: 1,
            fetchBySearch: false,
            selectedStatus: '0',
            selectedPageCount: 10,
            sources: [],

            // New data
            isShowBatchForm: false,
            isEdit: false,
            editBatch: {},
        }
    },
    computed: {
        batches() {
            return this.$store.getters['clientBatches/paginate'];
        },
        getCurrentPage() {
            if (this.fetchBySearch) {
                return this.searchPage
            } else {
                return this.page
            }
        }
    },

    methods: {

        archive(id) {
            Dialog.confirm({
                title: 'Deleting clientOrders',
                message: 'Are you sure you want to <b>delete</b>? This action cannot be undone.',
                confirmText: 'Confirm',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.delete(id)
            })
        },

        delete(id)
        {
            this.$store.dispatch('clientOrders/delete', {data: id})
            .then((data) => {
                this.successToast(data.message)

                this.fetch()
            })
            .catch((error) => {
                this.catchError(error)
            })
        },

        /**
         * Get all user batches
         * @return {Promise}
         */
        fetch()
        {
            const payload = {
                page: this.fetchBySearch ? this.searchPage : this.page,
                count: this.selectedPageCount,
                status: this.selectedStatus,
                search: this.searchVal,
            }

            this.$store.dispatch('clientBatches/fetch', { payload });
        },

        closeBatchForm()
        {
            this.fetch()
            this.isShowBatchForm = false
        },

        filterStatus: debounce(async function(value) {
            this.page = 1
            this.selectedStatus = value
            this.fetch()
        }, 500),
        filterPageCount: debounce(async function(value) {
            this.page = 1
            this.selectedPageCount = value
            this.fetch()
        }, 500),
        search: debounce(async function(value) {
            if (value) {
                this.fetchBySearch = true
                this.searchVal = value
            } else {
                this.searchVal = ''
                this.fetchBySearch = false
                this.searchPage = 1
            }
            
            this.fetch()
        }, 500),

        async fetchSources()
        {
            http.getJSON('/api/client/sources')
            .then(({data}) => {
                this.sources = data.sources;
                if (this.fromPage === 'add-patient') {
                    this.isShowBatchForm = true;
                }
            })
            .catch(error => {
            });
        },

        async next() {
            if (this.fetchBySearch) {
                this.searchPage++
            } else {
                this.page++
            }

            this.fetch()
        },
        async prev() {
            if (this.fetchBySearch) {
                this.searchPage--
            } else {
                this.page--
            }

            this.fetch()
        },

        /**
        * Editing batch
        *
        * @param  {object} patient
        * @return {[type]}
        */
        edit(batch)
        {
            this.resetEditState()
            this.isEdit = true
            this.isShowBatchForm = true
            this.editBatch = batch
        },

        /**
        * Cancel editing state
        *
        * @return {[void]}
        */
        resetEditState()
        {
            this.isEdit = false;
            this.editBatch = {};
        },

        openBatchForm()
        {
            this.resetEditState()
            this.isShowBatchForm = true
            this.isEdit = false
        },
    },

    /**
     * Mounted hook
     * @return {[void]}
     */
    mounted()
    {
        // Fetch patients
        this.fetch();
        this.fetchSources();
        this.$store.dispatch('auth/me');
    },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/pages/orders.scss";
</style>
