<template>
  <section class="patient-type">
    <div class="column portlet">
      <div class="header-portlet">
        <h2 class="float-left">
          PATIENT TYPES
        </h2>
        <div class="mini-form float-right">
          <form @submit.prevent="add">
            <b-field grouped>
              <b-input
                v-model="storeData.code"
                placeholder="Code"
                size="is-small"
              />
              <b-input
                v-model="storeData.name"
                placeholder="Name"
                size="is-small"
              />
              <b-button
                size="is-small"
                tag="input"
                type="app-primary"
                native-type="submit"
                value="Add"
              />
            </b-field>
          </form>
        </div>
      </div>
      <p v-if="patient_types.length === 0" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
      <b-table v-else :data="patient_types" bordered striped hoverable>
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
        :disabled="page === patientTypesObj.last_page"
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

      patient_types()
      {
          return this.$store.getters['patientType/items'];
      },
      patientTypesObj()
      {
          return this.$store.getters['patientType/data'];
      },
  },

  data() {
      return {
          isEdit: false,
          patient_typeId: '',
          code: '',
          name: '',
          editData: {},
          storeData: {},
          caption: false,
          page: 1,
      }
  },
  methods: {

      /**
       * Create new patient_type
       */
      add() {
          this.$store.dispatch('patientType/store', {data: this.storeData})
              .then((data) => {
                  this.successToast(data.message)
                  
                  this.fetch();
              })
              .catch((error) => {
                  this.catchError(error)
              });
      },

      /**
       * Update patient_type
       *
       * @return {[type]} [description]
       */
      submitEdit() {
          this.$store.dispatch('patientType/update', {data: this.editData})
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

      archive(patient_type) {
          Dialog.confirm({
              title: 'Deleting patient type',
              message: 'Are you sure you want to <b>delete</b>? This action cannot be undone.',
              confirmText: 'Confirm',
              type: 'is-danger',
              hasIcon: true,
              onConfirm: () => this.delete(patient_type)
          })
      },

      delete(patient_type)
      {
          this.$store.dispatch('patientType/delete', {data: patient_type})
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
        }

          this.$store.dispatch('patientType/fetch', {payload: payload})
              .then(({data}) => {
              })
              .catch((err) => {

              });
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
       * @param  {object} patient_type
       * @return {[type]}
       */
      editing(patient_type)
      {
          this.isEdit = true;
          this.editData = patient_type;
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
      // Fetch patient_types
      this.fetch();
  },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/system/patientTypes.scss";
</style>
