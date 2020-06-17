<template>
    <div class="services">
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
                        Add a Service
                    </b-button>
                    <b-upload
                    v-model="file"
                    :native="true"
                    @input="importFile"
                    >
                    <a class="button app-primary">
                        <b-icon icon="cloud-download" />
                        <span>Import</span>
                    </a>
                </b-upload>
            </div>
            <AddService
            v-if="addMode"
            @hide="addMode = false"
            @success="callFetchServices"
            />
            <div class="column" />
            <div class="column" />
            <div class="column portlet">
                <List :services="getServices"
                    :current="getCurrentPage"
                    @archive="archive"
                    @next="next()"
                    @prev="prev()"
                    @search="search"
                    @filterService="filterService"
                    @update="update" />
            </div>
        </div>
    </div>
</section>
</div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import { debounce, merge } from 'lodash'
import Header from '@/components/global/Header'
import AddService from '@/components/services/AddService'
import List from '@/components/services/List'

export default {
    components: {
        Header,
        AddService,
        List
    },
    data() {
        return {
            addMode: false,
            page: 1,
            searchPage: 1,
            file: null,
            fetchBySearch: false,
            searchVal: '',
            filter: {
                client_id: ''
            }
        }
    },
    computed: {
        ...mapGetters('service', ['getServices']),
        getCurrentPage() {
            if (this.fetchBySearch && this.searchVal) {
                return this.searchPage;
            } else {
                return this.page;
            }
        }
    },
    async beforeMount() {
        this.callFetchServices()
    },
    methods: {
        ...mapActions('service', [
            'fetchServices',
            'searchServices',
            'archiveService',
            'importService',
            'updateService'
        ]),

        async callFetchServices() {
            let payload = {}

            if (this.filter.client_id != '')
                payload = merge(payload, {clientId: this.filter.client_id})

            if (this.fetchBySearch && this.searchVal) {
                payload.page = this.searchPage
                payload.key = this.searchVal
                await this.searchServices(payload)
            } else {
                payload.page = this.page
                await this.fetchServices(payload)
            }
        },

        async next() {
            if (this.fetchBySearch) {
                this.searchPage++
            } else {
                this.page++
            }

            await this.callFetchServices()
        },

        async prev() {
            if (this.fetchBySearch) {
                this.searchPage--
            } else {
                this.page--
            }

            await this.callFetchServices()
        },

        search: debounce(async function(value) {
            if (value) {
                this.fetchBySearch = true
                this.searchVal = value
                await this.callFetchServices()
            } else {
                this.fetchBySearch = false
                this.searchVal = ''
                this.searchPage = 1
                await this.callFetchServices()
            }
        }, 500),

        async importFile() {
            let formData = new FormData();
            formData.append('file', this.file)
            try {
                await this.importService(formData)
                this.$toast.open({
                    message: 'Import successful',
                    type: 'is-success'
                })
                await this.callFetchServices()
            } catch (e) {
                console.error(e)
            }
        },
        async archive(value) {
            const payload = {
                id: value
            }

            try {
                await this.archiveService(payload)
                this.$toast.open({
                    message: 'Service was successfully archived',
                    type: 'is-success'
                })
                await this.callFetchServices()
            } catch (e) {
                this.$toast.open({
                    message: e.message,
                    type: 'is-success'
                })
            }
        },
        async update(payload) {
            try {
                const message = await this.updateService(payload)
                this.$toast.open({
                    message: message,
                    type: 'is-success'
                })

                await this.callFetchServices()
            } catch (e) {
                this.$toast.open({
                    message: `Error on updating service ${e.message}`,
                    type: 'is-danger'
                })
            }
        },

        filterService(user_id)
        {
            this.filter.client_id = user_id
            if (user_id == '')
                this.fetchServices();
            else
                this.fetchServices({'clientId': user_id});
        }
    },
}
</script>
<style lang="scss" scoped>
@import "@sass/pages/services/_index.scss";
</style>
