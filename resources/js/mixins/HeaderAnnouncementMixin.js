export default {

    computed: {

        unreadAnnouncements()
        {
            return this.$store.getters['userAnnouncement/unReadCount'];
        },
    },

    data()
    {
        return {
            isShowAllAnnouncements: false,
        }
    },

    methods: {
        /**
         * Close modal
         * @return {[type]} [description]
         */
        closeAllAnnouncementModal()
        {
            this.isShowAllAnnouncements = false;
            this.$store.dispatch('userAnnouncement/fetchUnread');
        },

        openShowAllAnnouncements()
        {
            this.isShowAllAnnouncements = true;
            // Fetch all announcements
            this.$store.dispatch('userAnnouncement/fetchAll');

            // Mark all as read then!
            this.$store.dispatch('userAnnouncement/updateMarkAsRead');
        },
    },

    mounted()
    {
        // Fetch all announcements
        this.$store.dispatch('userAnnouncement/fetchAll');
        window.AppEvent.on('user.announcements.show-all', this.openShowAllAnnouncements)
    },

};
