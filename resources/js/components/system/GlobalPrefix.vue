<template>
  <section class="global-prefix">
    <div class="column">
      <div class="columns">
        <div v-model="editData = global_prefix" class="">
          <b-field
            label="Prefix"
          >
            <b-input
              v-model="editData.global_prefix"
              name="prefix"
            />
          </b-field>
          <b-button
            tag="button"
            type="app-primary"
            class="btn-save"
            @click="submitEdit"
          >
            Save
          </b-button>
        </div>
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

      global_prefix()
      {
          return this.$store.getters['globalPrefix/items'];
      },
  },

  data() {
      return {
          editData: {},
      }
  },
  methods: {
      /**
       * Update global_prefix
       *
       * @return {[type]} [description]
       */
      submitEdit() {
          this.$store.dispatch('globalPrefix/update', {data: this.editData})
              .then((data) => {
                  this.successToast(data.message)
                  
                  this.fetch();
              })
              .catch((error) => {
                  this.catchError(error)
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
          this.$store.dispatch('globalPrefix/fetch')
              .then(({data}) => {
              })
              .catch((err) => {

              });
      },
  },

  /**
   * Mounted hook
   * @return {[void]}
   */
  mounted()
  {
      // Fetch global_prefix
      this.fetch();
  },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/system/globalPrefix.scss";
</style>