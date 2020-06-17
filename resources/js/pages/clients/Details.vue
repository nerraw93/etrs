<template>
    <div class="client-details">
        <Header />
        <section>
            <div class="container-fluid main-container">
                <div class="column is-full page-content">
                    <div class="column is-full no-left-padding">
                        <router-link to="/clients">
                            <b-button
                            type="is-danger"
                            icon-left="keyboard-backspace"
                            >
                            Back
                        </b-button>
                    </router-link>
                    <div class="column portlet mt-4">
                        <section v-if="client">
                            <h1>CLIENT INFORMATION</h1>
                            <hr>
                            <b-field grouped>
                                <b-field
                                label="Client"
                                expanded
                                >
                                {{ client.full_name }}
                            </b-field>
                            <b-field
                            label="Date Added"
                            expanded
                            >
                            {{ client.created_at }}
                        </b-field>
                    </b-field>
                    <div class="tabs is-boxed">
                        <ul>
                            <!--<li
                            :class="isActive('Services')"
                            @click="activeTab = 'Services'"
                            >
                            <a>
                                <b-icon icon="hospital" />
                                <span>Services</span>
                            </a>
                            </li>-->
                        <li
                        :class="isActive('Sources')"
                        @click="activeTab = 'Sources'"
                        >
                        <a>
                            <b-icon icon="cash" />
                            <span>Sources</span>
                        </a>
                    </li>
                </ul>
            </div>
            <component
            :is="activeTab"
            v-bind="dynamicProps"
            @view="show"
            />
            <div class="column no-left-padding">
                <h2 class="h2-portlet">
                    PAYMENT MODE
                </h2>
                <b-field
                class="mt-2"
                grouped
                >
                <b-select
                v-model="form.paymentMode"
                placeholder="Select payment mode"
                >
                <option value="0">
                    Cash
                </option>
                <option value="1">
                    Charge
                </option>
            </b-select>
            <b-button
            tag="input"
            type="app-primary"
            value="Update"
            @click="updateClientPayment"
            />
        </b-field>
        <h2 class="h2-portlet">
            DISPATCH MODE
        </h2>
        <b-field class="mt-2"
            grouped>
        <b-select
            v-model="form.dispatchMode"
            placeholder="Select dispatch mode"
            >
            <option v-for="item in dispatchers" :key="item.id" :value="item.id">
                {{ item.name }}
            </option>
        </b-select>
    <b-button
    tag="input"
    type="app-primary"
    value="Update"
    @click="updateClientDispatchMode"
    />
</b-field>
</div>
</section>
</div>
</div>
</div>
</div>
</section>
</div>
</template>
<script>
import { mapActions } from 'vuex'
import Header from '@/components/global/Header'
import Services from '@/components/clients/Services'
import Sources from '@/components/clients/Sources'
import {isEmpty} from 'lodash'

export default {
    components: {
        Header,
        Services,
        Sources
    },

    mounted()
    {
       // Fetch dispatchers
       this.fetch()
    },

    data() {
        return {
            servicesList: [],
            sourcesList: [],
            activeTab: 'Sources',
            servicesPage: 1,
            sourcesPage: 1,
            form: {
                dispatchMode: null,
                paymentMode: null
            },
            sourceId: '',
        }
    },
    computed: {
        dynamicProps() {
            if (this.activeTab === 'Services') {
                return {
                    services: this.servicesList,
                    current: this.servicesPage,
                    code: this.$route.params.code,
                    source: this.sourceId
                }
            }
            else if (this.activeTab === 'Sources') {
                return {
                    sources: this.sourcesList,
                    current: this.sourcesPage,
                    code: this.$route.params.code
                }
            }
        },
        dispatchers() {
            return this.$store.getters['dispatcher/items'];
        },
        client() {
            let client = this.$store.getters['client/selectedClient']
            if (!isEmpty(client)) {
                this.form.paymentMode = client.payment_mode
                this.form.dispatchMode = client.dispatcher_id
            }
            return client;
        }
    },

    mounted()
    {
        const payload = {
            code: this.$route.params.code
        }

        this.fetchClient(payload)
        this.$store.dispatch('dispatcher/fetch', {payload:{page: 1}})
    },

    methods: {
        ...mapActions('client', ['fetchClient', 'updatePayment', 'updateDispatchMode']),
        ...mapActions('dispatcher', ['fetch']),
        isActive(currentComponent) {
            if (this.activeTab === currentComponent) {
                return 'details-active'
            }
        },
        updateClientPayment() {
            const payload = {
                code: this.$route.params.code,
                id: this.client.id,
                payment_mode: parseInt(this.form.paymentMode)
            }

            try {
                this.updatePayment(payload)
                this.$toast.open({
                    message: 'Successfully updated payment mode',
                    type: 'is-success'
                })
            } catch (e) {
                this.$toast.open({
                    message: e.message,
                    type: 'is-danger'
                })
            }
        },
        updateClientDispatchMode() {
            const payload = {
                code: this.$route.params.code,
                id: this.client.id,
                dispatcher_id: parseInt(this.form.dispatchMode)
            }

            this.updateDispatchMode(payload).then(({ data }) => {
                this.$toast.open({
                    message: data.message,
                    type: 'is-success'
                })
            }, e => {
                this.$toast.open({
                    message: e.message,
                    type: 'is-danger'
                })
            })
        },
        show(source)
        {
            this.sourceId = source.id
            this.activeTab = 'Services'
        }
    }
}
</script>
<style lang="scss" scoped>
@import "../../../sass/pages/clients/details.scss";
</style>
