<template>

    <div class="patients">
        <Header />
        <section>
            <div class="container-fluid main-container">
                <div class="column is-full page-content">
                    <div class="column is-full no-left-padding">
                        <b-button v-if="!addMode"
                                  type="app-primary"
                                  icon-right="plus"
                                  @click="addMode = true">
                            Add New Patient
                        </b-button>
                    </div>
                    <AddPatient v-if="addMode || fromPage === 'add-order-modal'"
                                @hide="addMode = false"
                                @success="addPatientSuccess" />
                    <div class="column portlet"
                         :class="tableClass">
                        <List :patients="patients"
                              :current="getCurrentPage"
                              @archive="archive"
                              @next="next()"
                              @prev="prev()"
                              @reseteditstate="resetEditState"
                              @fetch="fetch"
                              @search="search" />
                    </div>
                </div>
            </div>
        </section>
    </div>

</template>
<script>

    import { Dialog } from 'buefy/dist/components/dialog'
    import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
    import debounce from 'lodash.debounce'
    import Header from '@/components/global/Header'
    import List from '@/components/patients/List'
    import AddPatient from '@/components/patients/AddPatient'
    import ErrorBagMixin from '@/mixins/ErrorBagMixin'

    export default {
        mixins: [ErrorBagMixin],
        props: {
            fromPage: {
                required: false,
                default: null,
                type: String
            }
        },
        /**
         * Components
         *
         * @type {Object}
         * @author {goper}
         */
        components: {
            Header,
            AddPatient,
            List
        },

        /**
         * Computed
         *
         * @type {Object}
         * @author {goper}
         */
        computed: {
            patients() {
                return this.$store.getters['patients/items']
            },

            getCurrentPage() {
                if (this.fetchBySearch && this.searchVal) {
                    return this.searchPage;
                } else {
                    return this.page;
                }
            },

            tableClass() {
                // addMode ? 'mt-4' : null
                if (this.addMode || this.fromPage === 'add-order-modal') {
                    return 'mt-4';
                } else {
                    return null;
                }
            }
        },

        data() {
            return {
                isEdit: false,
                patientId: '',
                code: '',
                name: '',
                editData: {},
                storeData: {},
                addMode: false,
                page: 1,
                searchPage: 1,
                fetchBySearch: false,
                searchVal: ''
            }
        },
        methods: {
            /**
             * Create new patient
             */
            add() {
                this.$store
                    .dispatch('patients/store', { data: this.storeData })
                    .then(data => {
                        this.successToast(data.message)

                        this.fetch()
                    })
                    .catch(error => {
                        this.catchError(error)
                    })
            },

            archive(patient) {
                Dialog.confirm({
                    title: 'Deleting patient',
                    message: 'Are you sure you want to <b>delete</b>? This action cannot be undone.',
                    confirmText: 'Confirm',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.delete(patient)
                })
            },

            delete(patient) {
                this.$store
                    .dispatch('patients/delete', { data: patient })
                    .then(data => {
                        const message = (data.data && data.data.message) || data.message
                        this.successToast(data.message)

                        this.fetch()
                    })
                    .catch(error => {
                        this.catchError(error)
                    })
            },

            async addPatientSuccess() {
                await this.fetch()
                if (this.fromPage === 'add-order-modal') {
                    this.$router.push({ name: 'client-orders', params: { fromPage: 'add-patient' }})
                }
            },

            /**
             * Fetch items
             *
             * @author goper
             * @return {void}
             */
            async fetch() {
                const payload = {}

                this.addMode = false

                if (this.fetchBySearch && this.searchVal) {
                    payload.page = this.searchPage
                    payload.key = this.searchVal

                    await this.$store
                        .dispatch('patients/search', { payload: payload })
                        .then(({ data }) => {})
                        .catch(err => {})
                } else {
                    payload.page = this.page
                    await this.$store
                        .dispatch('patients/fetch', { payload: payload })
                        .then(({ data }) => {})
                        .catch(err => {})
                }
            },

            async next() {
                if (this.fetchBySearch) {
                    this.searchPage++
                } else {
                    this.page++
                }

                await this.fetch()
            },
            async prev() {
                if (this.fetchBySearch) {
                    this.searchPage--
                } else {
                    this.page--
                }

                await this.fetch()
            },

            search: debounce(async function(value) {
                if (value) {
                    this.fetchBySearch = true
                    this.searchVal = value
                    await this.fetch()
                } else {
                    this.fetchBySearch = false
                    this.searchVal = ''
                    this.searchPage = 1
                    await this.fetch()
                }
            }, 500),

            /**
             * Editing state
             *
             * @param  {object} patient
             * @return {[type]}
             */
            editing(patient) {
                this.isEdit = true
                //this.editData = patient;
            },

            /**
             * Cancel editing state
             *
             * @return {[void]}
             */
            resetEditState() {
                this.isEdit = false
                this.editData = {}
            }
        },

        /**
         * Mounted hook
         * @return {[void]}
         */
        mounted() {
            // Fetch patients
            this.fetch()
        }
    }

</script>
<style lang="scss" scoped>

    @import '../../../sass/pages/patients/index.scss';

</style>
