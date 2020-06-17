<template>
  <section class="details">
    <div class="column">
      <div class="columns">
        <div v-model="editData = details.user" class="column no-left-padding is-half">
          <h2>ACCOUNT DETAILS</h2>
          <br>
          <b-field
            label="First Name"
            :type="{'is-danger': errors.has('first-name')}"
            :message="errors.first('first-name')"
          >
            <b-input
              v-model="editData.first_name"
              name="first-name"
            />
          </b-field>
          <b-field
            label="Last Name"
            :type="{'is-danger': errors.has('last-name')}"
            :message="errors.first('last-name')"
          >
            <b-input
              v-model="editData.last_name"
              name="last-name"
            />
          </b-field>
          <b-field
            label="Business Name"
            :type="{'is-danger': errors.has('business-name')}"
            :message="errors.first('business-name')"
          >
            <b-input
              v-model="editData.business_name"
              name="business-name"
            />
          </b-field>
          <b-field
            label="Business Address"
            :type="{'is-danger': errors.has('business-address')}"
            :message="errors.first('business-address')"
          >
            <b-input
              v-model="editData.business_address"
              name="business-address"
            />
          </b-field>
          <b-field
            label="Contact Number"
            :type="{'is-danger': errors.has('contact-number')}"
            :message="errors.first('contact-number')"
          >
            <b-input
              v-model="editData.contact_number"
              name="contact-number"
            />
          </b-field>
          <b-button
            tag="input"
            type="app-primary"
            native-type="submit"
            value="Update"
            @click="submitEdit"
          >
            Update
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
import {isUndefined} from "lodash";

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
        * Update details
        *
        * @return {[type]} [description]
        */
        submitEdit()
        {
            this.$store.dispatch('details/update', {data: this.editData})
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
            this.$store.dispatch('details/fetch')
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
        // Fetch details
        this.fetch();
    },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/settings/details.scss";
</style>
