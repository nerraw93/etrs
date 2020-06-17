<template>
    <section class="services-list">
        <div class="header-portlet">
            <h1> <b-icon icon="hospital" /> SERVICES LIST</h1>
        </div>
        <b-field grouped>
            <b-select v-model="form.filter" placeholder="No service"
                @input="filterByClient">
                <option value="" class="app-primary">
                    -- Show All --
                </option>
                <option v-for="option in options"
                    :key="option.id":value="option.code">
                    {{ option.full_name }}
                </option>
            </b-select>

            <b-input v-model="form.search" placeholder="Search Services"
                @input="$emit('search', form.search)" />

        </b-field>
        <b-table :data="servicesData" bordered striped hoverable>
            <template slot-scope="props">
                <b-table-column field="code" label="Code">
                    <router-link
                        :to="{ name: 'service_details', params: { code: props.row.code } }"
                        class="service-link">
                        {{ props.row.code }}
                    </router-link>
                </b-table-column>
                <b-table-column field="name" label="Name" width="">
                    {{ props.row.name }}
                </b-table-column>
                <b-table-column field="default_cost" label="Default cost" width="150">
                    {{ props.row.default_cost }}
                </b-table-column>
                <b-table-column field="no_clients" label="No. of clients" width="100">
                    {{ getClientsCount(props.row.no_clients) }}
                </b-table-column>
                <b-table-column field="no_orders" label="No. of orders" width="100">
                    {{ props.row.tests_count }}
                </b-table-column>
                <b-table-column field="actions" label="Actions" width="200">
                    <b-button type="app-primary" @click="openEditModal(props.row.code)">
                        Edit
                    </b-button>
                    <b-button type="is-danger" @click="openDeleteModal(props.row.id, props.row.name)">
                        Archive
                    </b-button>
                </b-table-column>
            </template>
            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon
                                icon="emoticon-sad"
                                size="is-large">
                            </b-icon>
                        </p>
                        <p>Nothing here.</p>
                    </div>
                </section>
            </template>
        </b-table>

        <div class="pagination-controls mt-2">
            <b-button type="is-danger" :disabled="current === 1" @click="$emit('prev')">
                Previous
            </b-button>
            <b-button type="is-danger" :disabled="current === getLastPage" @click="$emit('next')">
                Next
            </b-button>
        </div>

        <EditServiceModal v-if="open" :code="serviceToEdit" :open="open"
        @close="open = false" @update="update" />

        <DeleteServiceModal :open="openDelete" :modal-service-name="modalServiceName"
            @archive="archive" @close="openDelete = false" />
    </section>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
    components: {
        EditServiceModal: () => import('@/components/services/EditServiceModal'),
        DeleteServiceModal: () => import('@/components/services/DeleteServiceModal')
    },
    props: {
        services: {
            type: Array,
            required: true
        },
        current: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            form: {
                search: '',
                filter: ''
            },
            options: [],
            open: false,
            serviceToEdit: '',
            serviceToArchive: '',
            modalServiceName: '',
            openDelete: false,
            servicesData: [],
        }
    },
    computed: {
        ...mapGetters('service', ['getLastPage'])
    },
    methods: {

        filterByClient() {
            this.form.search = ''
            this.$emit('filterService', this.form.filter)
        },

        getClientsCount(clientsCount) {
            if (clientsCount > 0) {
                // @TODO fill this up later - get services total clients
            } else {
                return 0
            }
        },
        openEditModal(code) {
            this.open = true
            this.serviceToEdit = code
        },
        openDeleteModal(id, serviceName) {
            this.serviceToArchive = id
            this.modalServiceName = serviceName
            this.openDelete = true
        },
        archive() {
            this.$emit('archive', this.serviceToArchive)
            this.openDelete = false
        },
        update(payload) {
            this.open = false
            this.$emit('update', payload)
        },
    },

    watch: {
      	services: function(newServices) {
            this.servicesData = newServices;
        }
    },

    mounted()
    {
        http.getJSON(`/api/admin/client`, {page: 'all'})
            .then(({data}) => {
              let {clients} = data;
              this.options = clients;

            })
            .catch(error => {

                reject(error);
            });
    }
}
</script>
<style lang="scss" scoped>
@import "../../../sass/components/services/list.scss";
</style>
