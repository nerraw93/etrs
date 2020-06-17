<template>

    <div class="dashboard">
        <Header />
        <section>
            <div class="container-fluid main-container">
                <div class="column is-full page-content">
                    <div class="column is-full no-left-padding">
                        <h1 class="float-left">
                            HI-PRECISION ORDERING SYSTEM
                        </h1>
                        <nav class="breadcrumb float-right has-bullet-separator"
                             aria-label="breadcrumbs">
                            <ul>
                                <li><a>HOME</a></li>
                                <li class="active">
                                    DASHBOARD
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="column" />
                    <div class="column" />
                    <div class="column">
                        <div class="columns">
                            <div class="column is-half side-borders">
                                <BatchOrders :orders="getDraftOrders"
                                             :total="totalDraft"
                                             :current-page="draftCurrentPage"
                                             @paginationEvent="paginationEvent"
                                             type="Draft" />
                            </div>
                            <div class="column">
                                <TestAnnouncements />
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns">
                            <div class="column is-half side-borders">
                                <BatchOrders :orders="getConfirmedOrders"
                                             :total="totalConfirmed"
                                             :current-page="confirmedCurrentPage"
                                             @paginationEvent="paginationEvent"
                                             type="Confirmed" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</template>

<script>

    import { mapActions, mapGetters, mapState } from 'vuex'
    import Header from '@/components/global/Header'
    import BatchOrders from '@/components/dashboard/BatchOrders'
    import TestAnnouncements from '@/components/dashboard/TestAnnouncements'
    import broadCasterMixin from '@/mixins/BroadcasterMixin'

    export default {
        mixins: [broadCasterMixin],
        components: {
            Header,
            BatchOrders,
            TestAnnouncements
        },
        mounted() {
            this.fetchAnnouncements(), this.fetchDraftBatch(), this.fetchConfirmedBatch()
        },
        data() {
            return {
                announcementCurrentPage: 1,
            }
        },

        created() {

            this.$toast.open({
                message: 'Welcome',
                type: 'is-success'
            })
        },

        computed: {
            ...mapState('adminDashboard', {
                adminAnnouncements: 'announcements',
                adminDraftOrders: 'draftBatch',
                adminTotalDraft: 'totalDraftOrders',
                adminConfirmedOrders: 'confirmedBatch',
                adminTotalConfirmed: 'totalConfirmedOrders',
                adminDraftBatchCurrentPage: 'draftBatchCurrentPage',
                adminConfirmedBatchCurrentPage: 'confirmBatchCurrentPage',
            }),

            ...mapState('clientDashboard', {
                clientAnnouncements: 'announcements',
                clientDraftOrders: 'draftBatch',
                clientTotalDraft: 'totalDraftOrders',
                clientConfirmedOrders: 'confirmedBatch',
                clientTotalConfirmed: 'totalConfirmedOrders',
                clientDraftBatchCurrentPage: 'draftBatchCurrentPage',
                clientConfirmedBatchCurrentPage: 'confirmBatchCurrentPage',
            }),

            ...mapGetters('auth', { userIsAdmin: 'isAdmin' }),

            announcementList() {
                return this.userIsAdmin ? this.adminAnnouncements : this.clientAnnouncements
            },

            getDraftOrders() {
                return this.userIsAdmin ? this.adminDraftOrders : this.clientDraftOrders
            },

            totalDraft() {
                return this.userIsAdmin ? this.adminTotalDraft : this.clientTotalDraft
            },

            getConfirmedOrders() {
                return this.adminConfirmedOrders.length ? this.adminConfirmedOrders : this.clientConfirmedOrders
            },

            totalConfirmed() {
                return this.userIsAdmin ? this.adminTotalConfirmed : this.clientTotalConfirmed
            },

            draftCurrentPage() {
                return this.userIsAdmin ? this.adminDraftBatchCurrentPage : this.clientDraftBatchCurrentPage
            },

            confirmedCurrentPage() {
                return this.userIsAdmin ? this.adminConfirmedBatchCurrentPage : this.clientConfirmedBatchCurrentPage
            }
        },
        methods: {
            ...mapActions('adminDashboard', [
                'fetchAdminDraftBatch',
                'fetchAdminConfirmedBatch',
                'fetchAdminAnnouncements'
            ]),
            ...mapActions('clientDashboard', [
                'fetchClientDraftBatch',
                'fetchClientConfirmedBatch',
                'fetchClientAnnouncements'
            ]),
            fetchAnnouncements() {},

            fetchDraftBatch() {
                this.fetchAdminDraftBatch()
                this.fetchClientDraftBatch()
            },

            fetchConfirmedBatch() {
                this.fetchAdminConfirmedBatch()
                this.fetchClientConfirmedBatch()
            },

            paginationEvent({ type, page }) {
                if (type == 'Draft') {
                    // Draft
                    if (this.userIsAdmin)
                        this.fetchAdminDraftBatch(page)
                    else
                        this.fetchClientDraftBatch(page)
                } else {
                    // Confirm
                    if (this.userIsAdmin)
                        this.fetchAdminConfirmedBatch(page)
                    else
                        this.fetchClientConfirmedBatch(page)
                }
            },
        }
    }

</script>
<style lang="scss" scoped>
    @import '../../sass/pages/dashboard.scss';
</style>
