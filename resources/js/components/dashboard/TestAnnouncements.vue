<template>
    <section class="test-announcements">
        <div class="columns">
            <div class="column">
                <h4>TEST/SERVICE ANNOUNCEMENTS</h4>
            </div>
        </div>
        <div class="columns-is-full">
            <div class="columns is-multiline">
                <div v-for="(announcement, index) in announcements"
                    :key="index" class="column is-4">
                    <div class="topic" @click="openAnnouncementModal(announcement.data)">
                        <span>{{ announcement.data.topic }}</span>
                    </div>
                </div>
            </div>
        </div>

        <Modal title="Test/Services Announcements"
	        @close="closeAnnouncementModal"
	        :isOpen="isModalActive">
	        <!-- Body -->
            <div class="columns">
                <div class="column">
                    Topic: <strong>{{ currentAnnouncement.topic }}</strong>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    Content:
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    {{ currentAnnouncement.content }}
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    Availability from: <strong>{{ dateFormat(currentAnnouncement.start_date) }}</strong>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    Availability to: <strong>{{ dateFormat(currentAnnouncement.end_date) }}</strong>
                </div>
            </div>

	        <span slot="footer">
	            <button class="button" @click="closeAnnouncementModal">Close</button>
	        </span>
	    </Modal>

    </section>
</template>
<script>
import moment from "moment";
import Modal from "@components/global/Modal";
import paginator from "@components/global/Paginator";

export default {
    components: {
        Modal,
        paginator,
    },
    data() {
        return {
            isModalActive: false,
            currentAnnouncement: {},
            userRole: this.$store.getters['auth/getUserRole'],
        }
    },
    computed: {
        announcements()
        {
            let path = 'allAnnouncements';
            let params = {};
            if (this.userRole == 10) {
                path = 'getAdminAnnouncements';
            }

            return this.$store.getters[`${this.storeNamespace}${path}`];
        },

        announcementsFullData()
        {
            let path = 'full';
            let params = {};
            if (this.userRole == 10) {
                path = 'getAdminAnnouncementList';
            }

            return this.$store.getters[`${this.storeNamespace}${path}`];
        },

        storeNamespace()
        {
            let namespace = 'userAnnouncement/';
            if (this.userRole == 10)
                namespace = 'adminDashboard/';

            return namespace;
        },
    },

    mounted()
    {
        this.fetch();
    },

    methods: {

        fetch()
        {
            if (this.userRole == 10)
                this.$store.dispatch(`${this.storeNamespace}fetchAdminAnnouncements`);
            else
                this.$store.dispatch(`${this.storeNamespace}fetchAll`);
        },

        openAnnouncementModal(announcement)
        {
            this.currentAnnouncement = announcement
            this.isModalActive = true
        },

        closeAnnouncementModal()
        {
            this.currentAnnouncement = {};
            this.isModalActive = false;
        },

        dateFormat(date)
        {
            return moment(date).format('MMM DD, YYYY');
        },
    },
}
</script>
<style lang="scss" scoped>
    @import "../../../sass/components/dashboard/testAnnouncements.scss";
    @import "../../../sass/components/dashboard/testAnnouncementsModal.scss";
</style>
