<template>
  <div class="service-details">
    <Header />
    <section v-if="service">
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column is-full no-left-padding">
            <router-link to="/services">
              <b-button
                type="is-danger"
                icon-left="keyboard-backspace"
              >
                Back
              </b-button>
            </router-link>
          </div>
          <div class="column" />
          <div class="column portlet">
            <h1 class="float-left">
              {{ service.name }}
            </h1>
            <div class="clearfix" />
            <hr>
            <div class="column">
              <div class="columns is-mobile">
                <div class="column">
                  <p class="bd-notification is-info">
                    <strong>Code:</strong><br>{{ service.code }}
                  </p>
                </div>
                <div class="column">
                  <p class="bd-notification is-info">
                    <strong>Default cost:</strong><br>P {{ service.default_cost }}
                  </p>
                </div>
              </div>
            </div>
            <div class="column">
              <div class="columns is-mobile">
                <div class="column">
                  <p class="bd-notification is-info">
                    <strong>No. of clients:</strong><br>{{ service.clients.length }}
                  </p>
                </div>
                <div class="column">
                  <p class="bd-notification is-info">
                    <strong>No. of orders:</strong><br>{{ service.tests_count }}
                  </p>
                </div>
              </div>
            </div>
            <div class="column" />
            <h1 class="float-left">
              Clients
            </h1>
            <div class="clearfix" />
            <hr>
            <div class="column is-full no-left-padding">
              <b-button
                type="app-primary"
                icon-right="plus"
                @click="open = true"
              >
                Add Client
              </b-button>
            </div>
            <div class="column" />
            <div class="column portlet">
              <ClientList 
                :clients="clientsList"
                @edit="edit"
                @delete="archive"
              />
            </div>
          </div>
        </div>
      </div>
      
      <AssignClientModal
        :serviceId="service.id"
        :open="open"
        @close="open = false"
        @fetch="fetch"
      />

      <EditAssignedClientModal
        :serviceId="service.id"
        :open="openEdit"
        :editables="selectToEdit"
        @close="openEdit = false"
        @fetch="fetch"
      />
    </section>
  </div>
</template>
<script>
import { mapActions } from 'vuex'
import Header from '@/components/global/Header'
import ClientList from '@/components/services/ClientList'
import { Dialog } from 'buefy/dist/components/dialog'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
  mixins: [
    ErrorBagMixin
  ],
  components: {
    Header,
    ClientList,
    AssignClientModal: () => import('@/components/services/AssignClientModal'),
    EditAssignedClientModal: () => import('@/components/services/EditAssignedClientModal'),
  },
  data() {
    return {
      clientsList: [],
      service: null,
      open: false,
      openEdit: false,
      selectToEdit: {},
    }
  },
  async beforeMount() {
    this.fetch()
  },
  methods: {
    ...mapActions('service', ['fetchService']),
    async fetch()
    {
      this.clientsList = []

      const payload = {
        code: this.$route.params.code
      }

      this.service = await this.fetchService(payload)
      let clients = this.service.clients;
      clients.forEach((client) => {
        this.clientsList.push({ serviceId: this.service.id, userId: client.id, client: client.username, price: client.pivot.price });
      })
    },
    edit(client)
    {
      this.openEdit = true
      this.selectToEdit = client
    },
    archive(client)
    {
      Dialog.confirm({
        title: 'Archive',
        message: 'Are you sure you want to remove <strong>' + client.client + '</strong> from this service?',
        confirmText: 'Confirm',
        type: 'is-warning',
        hasIcon: true,
        onConfirm: () => this.confirmDelete(client.serviceId, client.userId)
      })
    },
    confirmDelete(serviceId, userId)
    {
      http.postJSON(`/api/admin/services/client/${serviceId}/archive/${userId}`)
      .then(({data}) => {
        this.successToast(data.message)
        this.fetch()
      })
      .catch(error => {
        this.catchError(error)
      });
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "@sass/pages/services/_details.scss";
</style>
