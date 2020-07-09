<template>
  <section class="source">
    <div class="column portlet">
      <div class="header-portlet columns is-multiline is-mobile">
        <h2 class="column is-full">
          SOURCES
        </h2>
        <div class="column is-full">
          <div class="float-left">
            <form @submit.prevent="search">
              <b-field grouped>
                <b-input
                  v-model="searchQuery"
                  placeholder="Search Sources..."
                />
                <b-button
                  tag="input"
                  type="app-primary"
                  native-type="submit"
                  value="Search"
                />
              </b-field>
            </form>
          </div>
          <div class="float-right">
            <form @submit.prevent="add">
                <b-field grouped>
                  <b-input
                    v-model="storeData.code"
                    placeholder="Code"
                  />
                  <b-input
                    v-model="storeData.name"
                    placeholder="Name"
                  />
                  <b-button
                    tag="input"
                    type="app-primary"
                    native-type="submit"
                    value="Add"
                  />
                </b-field>
            </form>
          </div>
        </div>
      </div>
      <p v-if="sources.length === 0" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
      <b-table v-else :data="sources" bordered striped hoverable>
        <template slot-scope="props">
          <b-table-column field="code"
            label="Code"
            width="300">
            {{ props.row.code }}
          </b-table-column>
          <b-table-column field="name"
            label="Name"
            width="300">
            <span v-if="!isEdit || editData.id != props.row.id">{{ props.row.name }}</span>

            <form v-else>
              <b-field>
                <b-input
                  v-model="editData.name"
                  placeholder="Name"
                  size="is-small" 
                />
              </b-field>
              <b-field grouped>
                <b-button
                    size="is-small"
                    type="is-success"
                    class="mr-1"
                    @click="submitEdit">
                    Save
                </b-button>
                <b-button
                    size="is-small"
                    type="is-danger"
                    value="Cancel"
                    @click="resetEditState">
                    Cancel
                </b-button>
              </b-field>
            </form>
          </b-table-column>
          <b-table-column field="actions"
            label="Actions"
            width="300">
            <b-button type="app-primary"
              value="Edit"
              @click="editing(props.row)">
              Edit
            </b-button>
            <b-button tag="input"
              type="is-danger"
              value="Archive"
              @click="archive(props.row.id, $event)"
            />
          </b-table-column>
        </template>
    </b-table>
    <div class="pagination-controls mt-2">
      <b-button
        type="is-danger"
        :disabled="page === 1"
        @click="prev()"
      >
        Previous
      </b-button>
      <b-button
        type="is-danger"
        :disabled="page === sourceObj.last_page"
        @click="next()"
      >
        Next
      </b-button>
    </div>
    </div>
  </section>
</template>
<script>
import { Dialog } from 'buefy/dist/components/dialog'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
  mixins: [
    ErrorBagMixin
  ],

  /**
   * Components
   *
   * @type {Object}
   * @author {goper}
   */
  components: {

  },

  /**
   * Computed
   *
   * @type {Object}
   * @author {goper}
   */
  computed: {

      sources()
      {
          return this.$store.getters['sources/items'];
      },
      sourceObj()
      {
          return this.$store.getters['sources/data'];
      },
  },

  data() {
      return {
          isEdit: false,
          sourceId: '',
          searchQuery: '',
          code: '',
          name: '',
          editData: {},
          storeData: {},
          page: 1,
      }
  },
  methods: {

      /**
       * Create new source
       */
      add() {
          this.$store.dispatch('sources/store', {data: this.storeData})
              .then((data) => {
                  this.successToast(data.message)
                  
                  this.fetch();
              })
              .catch((error) => {
                  this.catchError(error)
              });
      },

      /**
       * Update source
       *
       * @return {[type]} [description]
       */
      submitEdit() {
          this.$store.dispatch('sources/update', {data: this.editData})
              .then((data) => {
                  this.successToast(data.message)

                  this.resetEditState();
                  this.fetch();
              })
              .catch((error) => {
                  this.catchError(error)

                  this.resetEditState();
              });
      },

      archive(source) {
          Dialog.confirm({
              title: 'Deleting source',
              message: 'Are you sure you want to <b>delete</b>? This action cannot be undone.',
              confirmText: 'Confirm',
              type: 'is-danger',
              hasIcon: true,
              onConfirm: () => this.delete(source)
          })
      },

      delete(source)
      {
          this.$store.dispatch('sources/delete', {data: source})
              .then((data) => {
                  this.successToast(data.message)

                  this.fetch();
              })
              .catch((error) => {
                  this.catchError(error)
              })
      },

      /**
       * Fetch items
       *
       * @author goper
       * @return {void}
       */
      fetch()
      {
        const payload = {
          page: this.page,
        };

        this.$store.dispatch('sources/fetch', {payload: payload})
          .then(({data}) => {
          })
          .catch((err) => {

          });
      },
      search() {
        const payload = {
          page: this.page,
          query: this.searchQuery,
        };

        this.$store.dispatch('sources/search', payload)
          .then(({data}) => {})
          .catch((err) => {});
      },
      async next() {
        this.page++
        await this.fetch()
      },
      async prev() {
        this.page--
        await this.fetch()
      },
      /**
       * Editing state
       *
       * @param  {object} source
       * @return {[type]}
       */
      editing(source)
      {
          this.isEdit = true;
          this.editData = source;
      },

      /**
       * Cancel editing state
       *
       * @return {[void]}
       */
      resetEditState()
      {
          this.isEdit = false;
          this.editData = {};
      },
  },

  /**
   * Mounted hook
   * @return {[void]}
   */
  mounted()
  {
      // Fetch sources
      this.fetch();
  },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/system/sources.scss";
</style>
