<template>
  <div class="client-sources-list">
    <b-table
      :data="sources"
      bordered
      striped
      hoverable
    >
      <template slot-scope="props">
        <b-table-column
          field="code"
          label="Code"
        >
          {{ props.row.source.code }}
        </b-table-column>
        <b-table-column
          field="name"
          label="Name"
          width="1200"
        >
          {{ props.row.source.name }}
        </b-table-column>
        <b-table-column
          field="actions"
          label="Actions"
        >
          <b-button type="is-warning" @click="$emit('view', props.row)">
            View
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

    <paginator
      :data="paginateItems"
      @previous="previous"
      @next="next"
    />

    <b-button
      class="mt-2"
      type="app-primary"
      icon-right="check"
      @click="openAssignModal = true"
    >
      Assign Source
    </b-button>

    <AssignSources
      :isOpen="openAssignModal"
      @add="openAddServiceModal"
      @close="openAssignModal = false"
    />

    <confirmationmodal
      :data="deleteModalData"
      :open="isShowDeleteModal"
      @submit="deleteClientService"
      @close="isShowDeleteModal = false"
    />
  </div>
</template>
<script>
import { mapActions } from 'vuex';
import AssignSources from './AssignSources';
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
      AssignSources,
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
        }
    },

    /**
     * Computed
     * @type {Object}
     */
    computed:{

        /**
         * List of sources
         *
         * @return {[type]}
         */
        sources()
        {
            return this.$store.getters['clientSources/sources'];
        },

        paginateItems()
        {
            return this.$store.getters['clientSources/items'];
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
            source: {},
            isShowDeleteModal:false,
            deleteModalData: {},
            isShowAddServiceModal: false,
            addServiceData: {},
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
            this.$store.dispatch('clientSources/archive', {source: this.source})
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
         * Archive client sources
         *
         * @param  {object} clientService
         * @return {void}
         */
        archive(clientSource)
        {
            this.isShowDeleteModal = true;
            this.source = clientSource;
            this.deleteModalData = {
                title: 'Archive',
                icon: 'archive',
                message: `Are you sure you want to archive this source to this client?`,
            };
        },

        /**
         * Fetch client sources
         * @param  {String} [path='']
         * @return {void}
         */
        fetch(path = '')
        {
            let url = window.location.pathname.split("/");
            let clientId = url[url.length - 1];

            if (path) {
                path = path.split(/(?=\/api)/)[1]; // temporary fix due to poor engineering of pagination!!
            }

            this.$store.dispatch('clientSources/fetch', {id: clientId, path})
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
        openAddServiceModal(service)
        {
            this.addServiceData = service;
            this.isShowAddServiceModal = true;
            this.openAssignModal = false;
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
@import "../../../sass/components/clients/sources.scss";
</style>
