<template>
    <header class="page-header">
        <nav class="navbar mega-menu" role="navigation" aria-label="main navigation">
            <div class="container-fluid">
                <div class="navbar-brand">
                    <router-link to="/">
                        <img class="company-logo" src="/images/header_logo.png">
                    </router-link>
                    <a role="button" class="navbar-burger burger" aria-label="menu"
                        aria-expanded="false" data-target="nav-content">
                        <span aria-hidden="true" />
                        <span aria-hidden="true" />
                        <span aria-hidden="true" />
                    </a>
                </div>
                <div class="navbar-menu">
                    <div class="navbar-end">
                        <div class="topbar-actions">
                            <b-dropdown position="is-bottom-left" aria-role="menu"
                                class="announcement">
                                <b-button slot="trigger" class="navbar-item button-action">
                                    <b-icon icon="bell" />
                                    <span>Announcements
                                        <strong v-if="unreadAnnouncements > 0"
                                            class="has-text-danger">
                                            ({{unreadAnnouncements}})
                                        </strong>
                                    </span>
                                    <b-icon icon="menu-down" />
                                </b-button>
                                <template slot="default" class="dropdown-class">
                                    <!-- Header dropdown announcements component -->
                                    <AnnouncementList />
                                </template>
                            </b-dropdown>
                            <b-dropdown position="is-bottom-left" aria-role="menu">
                                <b-button slot="trigger" class="navbar-item button-action">
                                    <b-icon icon="account" />
                                    <span>Hi, {{ getUserName }}</span>
                                    <b-icon icon="menu-down" />
                                </b-button>
                                <template slot="default" class="dropdown-class">
                                    <div class="dropdown-item" @click="exit">
                                        Sign out
                                    </div>
                                </template>
                            </b-dropdown>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-3">
                <div id="nav-content" class="navbar-menu">
                    <div class="navbar-start">
                        <router-link to="/" class="navbar-item main-nav"
                            :style="activeStyle('dashboard')">
                            <b-icon icon="home" />&nbsp;
                            <span>Dashboard</span>
                        </router-link>
                        <router-link v-if="userIsAdmin()" to="/clients"
                            class="navbar-item main-nav" :style="activeStyle('clients')">
                            <b-icon icon="account-star" />
                            <span>Clients</span>
                        </router-link>
                        <router-link v-if="userIsAdmin()" to="/processors"
                            class="navbar-item main-nav" :style="activeStyle('processors')">
                            <b-icon icon="incognito" />
                            <span>Processors</span>
                        </router-link>
                        <router-link v-if="userIsAdmin()" to="/orders"
                            class="navbar-item main-nav" :style="activeStyle('orders')" >
                            <b-icon icon="stethoscope" />
                            <span>Batch Orders</span>
                        </router-link>
                        <router-link
                            v-if="userIsClientOrStaff()"
                            to="/client-orders"
                            class="navbar-item main-nav"
                            :style="activeStyle('client-orders')"
                            >
                                <b-icon icon="stethoscope" />
                                <span>Batch Orders</span>
                        </router-link>
                        <router-link
                            v-if="userIsClientOrStaff()"
                            to="/patients"
                            class="navbar-item main-nav"
                            :style="activeStyle('patients')"
                            >
                            <b-icon icon="puzzle" />
                            <span>Patients</span>
                        </router-link>
                        <router-link v-if="userIsClient()"
                            to="/staff"
                            class="navbar-item main-nav"
                            :style="activeStyle('staff')"
                            >
                            <b-icon icon="account-multiple" />
                            <span>Staff</span>
                        </router-link>
                        <router-link
                            v-if="userIsClientOrStaff()"
                            to="/settings"
                            class="navbar-item main-nav"
                            :style="activeStyle('settings')"
                            >
                            <b-icon icon="settings" />
                            <span>Settings</span>
                        </router-link>
                        <router-link v-if="userIsAdmin()"
                            to="/services"
                            class="navbar-item main-nav"
                            :style="activeStyle('services')">
                            <b-icon icon="hospital" />
                            <span>Services</span>
                        </router-link>
                        <router-link v-if="userIsAdmin()"
                            to="/system-configurations"
                            class="navbar-item main-nav"
                            :style="activeStyle('system')">
                            <b-icon icon="settings" />
                            <span>System</span>
                        </router-link>
                    </div>
                </div>
            </div>
        </nav>

        <Modal title="All announcements"
            @close="closeAllAnnouncementModal"
            isWider
            :isOpen="isShowAllAnnouncements">
            <!-- Body -->
            <AllAnnouncementList />
            <!-- Footer -->
            <span slot="footer">
                <button class="button" @click="closeAllAnnouncementModal">Close</button>
            </span>
        </Modal>
    </header>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import AnnouncementList from './AnnouncementList';
import AllAnnouncementList from "@components/global/AllAnnouncementList";
import Modal from "@components/global/Modal";
import HeaderAnnouncementMixin from "@/mixins/HeaderAnnouncementMixin";

export default {

    components: {
        AnnouncementList,
        Modal,
        AllAnnouncementList,
    },

    /**
    * Mixins
    * @type {Array}
    */
    mixins: [HeaderAnnouncementMixin],

    computed: {
        ...mapGetters('auth', ['getUserName', 'getUserRole'])
    },
    methods: {
        ...mapActions('auth', ['logout']),
        exit() {
            this.logout()
            this.$router.push({ name: 'login' })
        },
        activeStyle(item) {
            if (this.$route.name === item) {
                return { 'background': '#f9f9f9!important', 'color': '#2a3239!important' }
            }
        },

        /**
         * Staff or client same link except `Client Staff Page`
         * @return {boolean}
         */
        userIsClientOrStaff()
        {
            return this.getUserRole == 0 ||  this.getUserRole == 3;
        },

        /**
         * User is client
         * @return {boolean}
         */
        userIsClient()
        {
            return this.getUserRole == 0;
        },

        /**
         * User is Admin
         * @return {boolean}
         */
        userIsAdmin()
        {
            return this.getUserRole == 10;
        }
    }
}
</script>
<style lang="scss" scoped>
    @import "../../../sass/components/global/header.scss";
</style>
