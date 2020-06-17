<template>
  <section class="clinicians">
    <div class="column">
      <div class="columns">
        <div class="column no-left-padding is-half">
          <h2>MY CLINICIANS</h2>
          <br>
          <div>
            <form @submit.prevent="add">
              <b-field grouped>
                <b-input
                  v-model="storeData.name"
                  placeholder="Clinician Name"
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
      <div class="columns">
        <div class="column no-left-padding is-full">
          <p v-if="clinicians.length === 0" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
          <b-table v-else :data="clinicians" bordered striped hoverable>
            <template slot-scope="props">
              <b-table-column field="code"
                label="ID"
                width="300">
                {{ props.row.id }}
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
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import { Dialog } from 'buefy/dist/components/dialog';
import ErrorBagMixin from "@/mixins/ErrorBagMixin";

export default {

    mixins: [
        ErrorBagMixin
    ],

    /**
    * Computed
    *
    * @type {Object}
    * @author {goper}
    */
    computed: {

        clinicians()
        {
            return this.$store.getters['clinicians/list'];
        },
    },

    data() {
        return {
            isEdit: false,
            clincianId: '',
            code: '',
            name: '',
            editData: {},
            storeData: {},
            caption: false,
        }
    },
    methods: {

        /**
        * Create new clincian
        */
        add()
        {
            this.$store.dispatch('clinicians/store', {data: this.storeData})
            .then((data) => {
                this.successToast(data.message);
                this.fetch();
            })
            .catch((error) => {
                this.catchError(error);
            });
        },

        /**
        * Update clincian
        *
        * @return {[type]} [description]
        */
        submitEdit()
        {
            this.$store.dispatch('clinicians/update', {data: this.editData})
            .then((data) => {
                this.successToast(data.message);

                this.resetEditState();
                this.fetch();
            })
            .catch((error) => {
                this.catchError(error);
                this.resetEditState();
            });
        },

        archive(clincian)
        {
            Dialog.confirm({
                title: 'Deleting clinician',
                message: 'Are you sure you want to <b>delete</b>? This action cannot be undone.',
                confirmText: 'Confirm',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.delete(clincian)
            })
        },

        delete(clincian)
        {
            this.$store.dispatch('clinicians/delete', {data: clincian})
                .then((data) => {
                    this.successToast(data.message);
                    this.fetch();
                })
                .catch((error) => {
                    this.catchError(error);
                });
        },

        /**
        * Fetch items
        *
        * @author goper
        * @return {void}
        */
        fetch()
        {
            this.$store.dispatch('clinicians/fetch')
            .then(({data}) => {
            })
            .catch((err) => {

            });
        },

        /**
        * Editing state
        *
        * @param  {object} clincian
        * @return {[type]}
        */
        editing(clincian)
        {
            this.isEdit = true;
            this.editData = clincian;
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
        // Fetch clinicians
        this.fetch();
    },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/settings/clinicians.scss";
</style>
