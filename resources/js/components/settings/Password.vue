<template>
  <section class="password">
    <div class="column">
      <div class="columns">
        <div class="column no-left-padding is-half">
          <h2>CHANGE PASSWORD</h2>
          <br>
          <b-input
            v-model="editData.id = details.user.id"
            type="hidden"
          />
          <b-field
            label="Old Password"
            :type="{'is-danger': errors.has('old-password')}"
            :message="errors.first('old-password')"
          >
            <b-input
              v-model="editData.old_password"
              name="old-password"
              type="password"
            />
          </b-field>
          <b-field
            label="New Password"
            :type="{'is-danger': errors.has('new-password')}"
            :message="errors.first('new-password')"
          >
            <b-input
              v-model="editData.password"
              name="new-password"
              type="password"
            />
          </b-field>
          <b-field
            label="Retype New Password"
            :type="{'is-danger': errors.has('retype-password')}"
            :message="errors.first('retype-password')"
          >
            <b-input
              v-model="editData.password_confirmation"
              name="retype-password"
              type="password"
            />
          </b-field>
          <b-button
            tag="input"
            type="app-primary"
            native-type="submit"
            value="Save"
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

      details()
      {
          return this.$store.getters['details/items'];
      },
  },

  data() {
      return {
          editData: {},
      }
  },
  methods: {
      /**
       * Update password
       *
       * @return {[type]} [description]
       */
      submitEdit() {
          this.$store.dispatch('password/update', {data: this.editData})
              .then((data) => {
                  this.successToast(data.message)
                  
                  this.fetch();
              })
              .catch((error) => {
                  this.catchError(error)
              });
      },
  },

  /**
   * Mounted hook
   * @return {[void]}
   */
  mounted()
  {

  },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/settings/password.scss";
</style>
