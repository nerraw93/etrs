<template>
  <div class="clients">
    <Header />
    <section>
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column is-full no-left-padding">
            <b-button
              v-if="!addMode"
              type="app-primary"
              icon-right="plus"
              @click="addMode = true"
            >
              Add Client
            </b-button>
          </div>
          <AddClient
            v-if="addMode"
            :sources="sources.data"
            @hide="addMode = false"
            @success="callFetchClients"
          />
          <div
            class="column portlet"
            :class="addMode ? 'mt-4' : null"
          >
            <List
              :clients="getClients"
              :current="getCurrentPage"
              @archive="archive"
              @next="next()"
              @prev="prev()"
              @search="search"
              @editMode="edit"
            />
          </div>
          <EditClient
            v-if="editMode"
            :client="editables"
            @hide="editMode = false"
            @success="callFetchClients"
          />
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import debounce from 'lodash.debounce'
import Header from '@/components/global/Header'
import List from '@/components/clients/List'
import AddClient from '@/components/clients/AddClient'
import EditClient from '@/components/clients/EditClient'

export default {
  components: {
    Header,
    List,
    AddClient,
    EditClient,
  },
  data() {
    return {
      addMode: false,
      editMode: false,
      page: 1,
      searchPage: 1,
      fetchBySearch: false,
      searchVal: '',
      editables: [],
    }
  },
  computed: {
    ...mapGetters('client', ['getClients']),
    getCurrentPage() {
      if (this.fetchBySearch && this.searchVal) {
        return this.searchPage;
      } else {
        return this.page;
      }
    },
    sources()
    {
      return this.$store.getters['sources/data'];
    },
  },
  async beforeMount() {
    this.callFetchClients()
  },
  methods: {
    ...mapActions('client', ['fetchClients', 'searchClients', 'archiveClient']),
    async callFetchClients() {
      let payload = {}

      if (this.fetchBySearch && this.searchVal) {
        payload.page = this.searchPage
        payload.key = this.searchVal
        await this.searchClients(payload)
      } else {
        payload.page = this.page
        await this.fetchClients(payload)
      }
    },
    async next() {
      if (this.fetchBySearch) {
        this.searchPage++
      } else {
        this.page++
      }

      await this.callFetchClients()
    },
    async prev() {
      if (this.fetchBySearch) {
        this.searchPage--
      } else {
        this.page--
      }

      await this.callFetchClients()
    },
    search: debounce(async function(value) {
      if (value) {
        this.fetchBySearch = true
        this.searchVal = value
      } else {
        this.fetchBySearch = false
        this.searchVal = ''
        this.searchPage = 1
      }

      await this.callFetchClients()
    }, 500),
    async archive(value) {
      const payload = {
        id: value
      }

      try {
        await this.archiveClient(payload)
        this.$toast.open({
          message: 'Client was successfully archived',
          type: 'is-success'
        })
        await this.callFetchClients()
      } catch (e) {
        this.$toast.open({
          message: e.message,
          type: 'is-success'
        })
      }
    },
    async fetchSources()
    {
      const payload = {
          page: '',
        }

        this.$store.dispatch('sources/fetch', {payload: payload})
          .then(({data}) => {
          })
          .catch((err) => {

          });
    },
    edit(values)
    {
      this.editMode = true
      this.editables = values
      window.scrollTo(0, 5000)
    }
  },
  mounted() {
    this.fetchSources()
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/pages/clients/index.scss";
</style>
