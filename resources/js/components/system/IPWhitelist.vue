<template>
  <section class="ip-whitelist">
    <div class="column portlet">
      <div class="header-portlet">
        <h2 class="float-left">
          IP WHITELIST
        </h2>
        <div class="mini-form float-right">
          <form @submit.prevent="add">
            <b-field grouped>
              <b-input
                v-model="storeData.address"
                placeholder="Enter IP"
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
      <p v-if="ip_whitelist.length === 0" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
      <div v-else class="columns is-multiline">
        <template v-for="ip in ip_whitelist.white_listed_ips">
          <div class="column is-one-fifth">
            <div class="card">
              <div class="card-image">
                <figure class="ip-container">
                  <p class="text-center">
                    <span v-if="!isEdit || editData.id != ip.id">{{ ip.address }}</span>
                    <b-field v-else>
                      <b-input
                        v-model="editData.address"
                        placeholder="Name"
                        size="is-small"
                      />
                    </b-field>
                  </p>
                </figure>
              </div>
              <div class="card-content">
                <div class="content text-center">
                  <form v-if="!isEdit || editData.id != ip.id">
                    <b-button
                      type="app-primary"
                      @click="editing(ip)"
                    >
                      Edit
                    </b-button>
                    <b-button
                      type="is-danger"
                      @click="archive(ip.id)"
                    >
                      Delete
                    </b-button>
                  </form>
                  <form v-else>
                    <b-button
                      type="is-success"
                      class="mr-1"
                      @click="submitEdit">
                      Save
                    </b-button>
                    <b-button
                      type="is-danger"
                      value="Cancel"
                      @click="resetEditState">
                      Cancel
                    </b-button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </template>
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

      ip_whitelist()
      {
          return this.$store.getters['ipWhitelist/items'];
      },
  },

  data() {
      return {
          isEdit: false,
          ip_whitelistId: '',
          code: '',
          name: '',
          editData: {},
          storeData: {},
          caption: false,
      }
  },
  methods: {

      /**
       * Create new ip_whitelist
       */
      add() {
          this.$store.dispatch('ipWhitelist/store', {data: this.storeData})
              .then((data) => {
                  this.successToast(data.message)

                  this.fetch();
              })
              .catch((error) => {
                  this.catchError(error)
              });
      },

      /**
       * Update ip_whitelist
       *
       * @return {[type]} [description]
       */
      submitEdit() {
          this.$store.dispatch('ipWhitelist/update', {data: this.editData})
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

      archive(ip) {
          Dialog.confirm({
              title: 'Deleting IP address',
              message: 'Are you sure you want to <b>delete</b>? This action cannot be undone.',
              confirmText: 'Confirm',
              type: 'is-danger',
              hasIcon: true,
              onConfirm: () => this.delete(ip)
          })
      },

      delete(ip)
      {
          this.$store.dispatch('ipWhitelist/delete', {data: ip})
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
          this.$store.dispatch('ipWhitelist/fetch')
              .then(({data}) => {
              })
              .catch((err) => {

              });
      },

      /**
       * Editing state
       *
       * @param  {object} ip_whitelist
       * @return {[type]}
       */
      editing(ip)
      {
          this.isEdit = true;
          this.editData = ip;
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
      // Fetch ip_whitelist
      this.fetch();
  },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/system/ipWhitelist.scss";
</style>
