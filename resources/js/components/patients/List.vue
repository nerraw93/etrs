<template>

    <section class="patients-list">
        <div class="header-portlet">
            <h1>
                <b-icon icon="account-group" /> PATIENTS LIST</h1>
        </div>
        <b-field>
            <b-input v-model="form.search"
                     placeholder="Search Patient"
                     expanded
                     @input="$emit('search', form.search)" />
        </b-field>
        <p v-if="!patients.data || !patients.data.length" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
        <b-table v-else
                 :data="patients.data"
                 bordered
                 striped
                 hoverable>
            <template slot-scope="props">
            <b-table-column
              field="patient-id"
              label="ID #"
            >
              {{ props.row.global_custom_id }}
            </b-table-column>
            <b-table-column
              field="custom-id"
              label="My Patient ID"
              width="200"
            >
              {{ props.row.client_custom_id }}
            </b-table-column>
            <b-table-column
              field="name"
              label="Name"
              width="500"
            >
              <router-link
                :to="{ name: 'patient_details', params: { code: props.row.id } }"
                class="patient-link"
              >
                {{ props.row.first_name }} {{ props.row.last_name }}
              </router-link>
            </b-table-column>
            <b-table-column
              field="created_at"
              label="Date Added"
            >
              {{ props.row.created_at | relativeTime }}
            </b-table-column>
            <b-table-column
              field="actions"
              label="Actions"
            >
              <b-button
                type="is-success"
                @click="openEditModal(props.row)"
              >
                Edit
              </b-button>
              <b-button
                type="is-danger"
                @click="archive(props.row.id)"
              >
                Archive
              </b-button>
            </b-table-column>
          </template>
        </b-table>
        <div class="pagination-controls mt-2 text-right">
            <b-button type="is-danger"
                      :disabled="current === 1"
                      @click="$emit('prev')">
                Previous
            </b-button>
            <b-button type="is-danger"
                      :disabled="current === patients.last_page"
                      @click="$emit('next')">
                Next
            </b-button>
        </div>
        <EditPatientModal v-if="openEdit"
                          :patient="patientToEdit"
                          :open="openEdit"
                          @close="closeEditModal"
                          @update="update" />
        <DeletePatientModal :open="openDelete"
                            :modal-username="modalUsername"
                            @archive="archive"
                            @close="open = false" />
    </section>

</template>
<script>

    import { relativeTime } from '@/filters/date'
    import ErrorBagMixin from '@/mixins/ErrorBagMixin'

    export default {

        mixins: [ErrorBagMixin],

        components: {
            EditPatientModal: () => import('@/components/patients/EditPatientModal'),
            DeletePatientModal: () => import('@/components/patients/DeletePatientModal')
        },

        filters: {
            relativeTime
        },

        props: {
            patients: {
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
                    search: ''
                },
                openEdit: false,
                openDelete: false,
                userToArchive: '',
                patientToEdit: {},
                modalUsername: ''
            }
        },
        methods: {

            openEditModal(patient) {
                this.patientToEdit = patient
                this.openEdit = true
            },

            closeEditModal() {
                this.openEdit = false
                // this.$emit('reseteditstate')
            },

            openDeleteModal(id, username) {
                this.userToArchive = id
                this.modalUsername = username
                this.openDelete = true
            },
            archive(id) {
                this.$emit('archive', id)
                this.openDelete = false
            },

            /**
             * Update patient
             * @param  {[type]} payload [description]
             * @return {[type]}         [description]
             */
            update(isSuccess) {
                this.openEdit = false
                this.$emit('fetch')
            }
        }
    }

</script>
<style lang="scss" scoped>

    @import '../../../sass/components/patients/list.scss';

</style>
