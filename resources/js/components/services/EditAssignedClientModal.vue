<template>
  <b-modal
    class="assign-modal"
    :active.sync="open"
    :can-cancel="false"
    has-modal-card
  >
    <div class="card">
      <div class="modal-card-body">
        <form
          class="assign-form"
          @submit.prevent="submit"
        >
          <div class="column">
            <h3>Update price for {{ editables.client }}</h3>
            <hr>
          </div>
          <div class="column no-top-padding">
            <div class="columns">
              <div class="column">
                <b-field>
                  <b-input
                    v-model="price"
                    placeholder="Number"
                    type="number"
                  />
                </b-field>
              </div>
            </div>
          </div>
          <div class="column">
            <div class="modal-actions">
              <hr>
              <b-button
                class="float-right"
                type="is-danger"
                @click="$emit('close')"
              >
                Close
              </b-button>
              <b-button
                class="float-right mr-2"
                type="app-primary"
                tag="input"
                native-type="submit"
                value="Save"
              />
            </div>
          </div>
        </form>
      </div>
    </div>
  </b-modal>
</template>
<script>
import { mapActions } from 'vuex'
import debounce from 'lodash.debounce'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
  mixins: [
    ErrorBagMixin
  ],
  props: {
    open: {
      type: Boolean,
      required: true
    },
    serviceId: Number,
    editables: Object,
  },
  computed: {
    price: {
      get() 
      {
        return this.editables.price
      },
      set(value) 
      {
        this.form.price = value
      }
    }
  },
  data: function() {
    return {
      form: {
        client: null,
        price: 0,
      },
      options: [],
    }
  },
  methods: {
    ...mapActions('client', ['searchClients']),
    submit() {
      http.postJSON(`/api/admin/services/client/update/price`, {service_id: this.serviceId, user_id: this.editables.userId, price: this.form.price})
      .then(({data}) => {
        this.successToast(data.message)
        this.$emit('close')
        this.$emit('fetch')
      })
      .catch(error => {
        this.catchError(error)
      });
    },
    searchClient: debounce(async function(search, loading) {
      if (search) {
        loading(true)
        const payload = {
          key: search
        }
        const { clients } = await this.searchClients(payload)
        this.options = clients.data
        loading(false)
      }
    }, 500)
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/services/assignClientModal.scss";
</style>
